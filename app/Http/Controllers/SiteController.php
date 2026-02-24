<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\City;
use App\Models\Content;
use App\Models\Course;
use App\Models\Group;
use App\Models\Herfe;
use App\Models\HerfeOrgan;
use App\Models\Khabar;
use App\Models\Moases;
use App\Models\Organ;
use App\Models\Popup;
use App\Models\RegisterMessage;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Social;
use App\Models\StaticPageVisit;
use App\Models\topadv;
use App\Models\Training_course;
use App\Models\TuitionHerfe;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;


class SiteController extends Controller
{
    //
    public function policy()
    {
        $ghanon = setting::first()->ghanon;
        return view('dashboard.policy', compact('ghanon'));
    }

    public function policyChange(Request $req)
    {
        $pol = setting::first();
        $pol->ghanon = $req->ghanon;
        $pol->save();
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $page = StaticPageVisit::firstOrCreate(['slug' => 'home']);

        $existingVisit = $page->visits()
            ->where('ip', request()->ip())
            ->where('created_at', '>=', now()->subDay())
            ->first();

        if (!$existingVisit) {
            $page->visits()->create([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'user_id' => auth()->id(),
            ]);
        }
        $sliders = Slider::where('type', 0)->orderBy('order', 'asc')->get();
        if ($sliders->count() > 1) {
            // مثلا میخوای اسلایدری که slug اش برابر "special-slider" هست حذف بشه
            $sliders = $sliders->reject(function ($slider) {
                return $slider->id == 18;
            })->values(); // ریست اندیس‌های آرایه
        }
        foreach ($sliders as $slider) {
            $slider['time'] = $this->time($slider->created_at);
        }

        $Advertisements = [];
        $newCourses = [];
        $contents = [];
        $news = [];

        $popups = Popup::active()->get();


        return view('site.index',compact('sliders','Advertisements','newCourses','contents','news','popups'));
    }

    public function states($cityId)
    {
        $states = City::where('active', 1)->orderBy('title', 'asc')->where('parent', $cityId)->get(); // شهرستان ها رو با 'parent' برابر cityId میگیریم
        return response()->json($states);
    }

    public function schools(Request $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;

        // اگر مختصات بود
        if ($lat && $lng) {
            $schools = Organ::query()
                ->where('type', '2')
                ->where(function ($q) {
                    $q->where('status', '1')->orWhere('status', '4');
                })
                ->select('*')
                ->selectRaw("(
                    6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lang) - radians(?)) + sin(radians(?)) * sin(radians(lat)))
                ) AS distance", [$lat, $lng, $lat])
                ->having('distance', '<=', 1.1)
                ->orderBy('distance')
                ->get();

            // اگر پیدا نکرد، دوباره تو شعاع بزرگ‌تر
            if ($schools->isEmpty()) {
                $schools = Organ::query()
                    ->where('type', '2')
                    ->where(function ($q) {
                        $q->where('status', '1')->orWhere('status', '4');
                    })
                    ->select('*')
                    ->selectRaw("(
                        6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lang) - radians(?)) + sin(radians(?)) * sin(radians(lat)))
                    ) AS distance", [$lat, $lng, $lat])
                    ->having('distance', '<=', 10)
                    ->orderBy('distance')
                    ->get();
            }
        } else {
            // جستجو بدون مختصات
            $query = Organ::query()
                ->where('type', '2')
                ->where(function ($q) {
                    $q->where('status', '1')->orWhere('status', '4');
                });

            if ($request->group) {
                $organHerfe = HerfeOrgan::where('herfe_id', $request->group)->pluck('organ_id');
                $query->whereIn('id', $organHerfe);
            }
            if ($request->name) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if ($request->state) {
                $query->where('state', $request->state);
            }
            if ($request->city) {
                $query->where('city', $request->city);
            }

            $schools = $query->get();
            // اگر ورودی خالی بود و هیچ نتیجه نداد، همه مدارس با وضعیت درست رو بیاره
            if ($schools->isEmpty() && !$request->group && !$request->name && !$request->state && !$request->city) {
                $schools = Organ::where('type', '2')
                    ->where(function ($q) {
                        $q->where('status', '1')->orWhere('status', '4');
                    })
                    ->get();
            }
        }
        if ($schools->count() === 1 && $request->name) {
            return redirect()->route('school.show', ['id' => $schools->first()->id]);
        }

        // گرفتن 10 ارگان برای نمایش در سایدبار یا کارهای دیگر
        $organs = Organ::take(10)->get();

        return view('site.schools', compact('schools', 'organs'));
    }
    public function register()
    {
        $ghanon = Setting::first()->ghanon;
        $socials = Social::all();
        $states = City::where('active', 1)->whereNull('parent')->get();
        foreach ($states as $state) {
            $cities = City::where('active', 1)->where('parent', $state->id)->get();
            $state['cities'] = $cities;
        }
        $herfes = [];
        $khoshes = [];
        return view('auth.register', compact('socials', 'khoshes', 'states', 'herfes', 'ghanon'));
    }
    public function show($id)
    {
        $school = Organ::where('id', $id)->where('type', '2')->firstOrFail();

        $organs = Organ::take(10)->get();

        return view('site.school-show', compact('school', 'organs'));
    }
    public function news()
    {
        $organs = Organ::where('status', 1)->take(10)->get();
        foreach ($organs as $organ) {
            $organ['ostan'] = City::find($organ->state);
            $organ['city'] = City::find($organ->city);
            $organ['moases'] = Moases::where('organ_id', $organ->id)->pluck('name')->first();
            $organ['time'] = $this->time_index($organ->created_at);
        }
        $news = Khabar::orderByDesc('created_at')->get();
        return view('site.news', compact('news', 'organs'));
    }
    public function map()
    {
        $organns = [
            [
                'id' => 1,
                'lat' => 31.87353,
                'lng' => 54.34087,
                'name' => "آموزشگاه  bh jbhb hb bhbhالف (خواهران)",
                'address' => "یزد، محله آذر یزدی",
                'gender' => "female",
                'fields' => ["امور اداری", "بهداشت و ایمنی"],
                'city' => 'یزد'
            ],
            [
                'id' => 6,
                'lat' => 31.879196,
                'lng' => 54.373658,
                'name' => "دارالفنون فاضل",
                'address' => "یزد، خیابان کاشانی",
                'gender' => "both",
                'fields' => ["فناوری اطلاعات"],
                'city' => 'یزد'
            ],
            [
                'id' => 2,
                'lat' => 31.8974,
                'lng' => 54.3569,
                'name' => "آموزشگاه ب (برادران)",
                'address' => "یزد، میدان آزادی",
                'gender' => "male",
                'fields' => ["بهداشت و ایمنی"],
                'city' => 'یزد'
            ],
            [
                'id' => 3,
                'lat' => 31.8900,
                'lng' => 54.3600,
                'name' => "آموزشگاه ج (چند منظوره)",
                'address' => "یزد، بلوار جمهوری",
                'gender' => "both",
                'fields' => ["زیست فناوری"],
                'city' => 'یزد'
            ],
            [
                'id' => 4,
                'lat' => 31.8850,
                'lng' => 54.3650,
                'name' => "آموزشگاه د (چند منظوره)",
                'address' => "یزد، نزدیک بلوار جمهوری",
                'gender' => "both",
                'fields' => ["فناوری اطلاعات", "زیست فناوری"],
                'city' => 'یزد'
            ],
            [
                'id' => 5,
                'lat' => 31.9010,
                'lng' => 54.3500,
                'name' => "آموزشگاه ه (خواهران)",
                'address' => "یزد، خیابان فرخی",
                'gender' => "female",
                'fields' => ["فناوری اطلاعات", "مراقبت و زیبایی"],
                'city' => 'یزد'
            ]
        ];
        $organs = Organ::where('status', 1)->take(5)->get();
        $groups = Group::orderBy('name', 'asc')->get();
        $states = City::orderBy('title', 'asc')->where('active', 1)->where('parent', 31)->get();

        return view('site.map', compact('organns', 'organs', 'groups', 'states'));
    }
    public function school()
    {
        return view('site.school');
    }
}
