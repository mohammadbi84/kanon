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



        $hot = $request->input('hot', 0);

        // Fetch Advertisements based on 'hot' status, and eager load the related 'organ'
        $Advertisements = Advertisement:: // Eager load relationships
            where(function ($query) use ($hot) {
                if ($hot) {
                    $query->orderByDesc('like_number'); // Assuming 0 means 'hot'
                } else {
                    $query->orderBy('created_at', 'desc');
                }
            })
            ->get();
        foreach ($Advertisements as $key => $Advertisement) {
            $existingVisit = $Advertisement->visits()
                ->where('ip', request()->ip())
                ->where('created_at', '>=', now()->subDay())
                ->first();
            if (!$existingVisit) {
                $Advertisement->visits()->create([
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'user_id' => auth()->id(),
                ]);
                // $Advertisement->view_count += 1;
                // $Advertisement->save();
            }
        }
        if ($request->ajax()) {
            // Map the Advertisements to the desired format for the AJAX response
            return response()->json($Advertisements->map(function ($ad) {
                // Access related data through eager loaded relationships
                return [
                    'id' => $ad->id,
                    'title' => $ad->title ? $ad->title : 'N/A',
                    'text' => $ad->text ? $ad->text : 'N/A',
                    'off' => $ad->discount_percent ?? 0,
                    'image' => $ad->image ? $ad->image : 'Untitled.png',
                    'tel' => $ad->organ ? $ad->organ->tel : '03512341234',
                    'city' => $ad?->organ?->cityRelation ? $ad->organ->cityRelation->title : 'یزد',
                    'time' => jdate($ad->created_at)->ago(),
                    'organ_logo' => $ad->organ?->file_logo ? $ad->organ?->file_logo : 'user.svg',
                    'views' => $ad->visits()->count(),
                    'likes' => $ad->likes()->count(),
                    // 'user_name' => $ad->organ?->user?->name ?? 'Unknown', // User's name through Organ.  Handles nulls gracefully
                    // 'city' => $ad->organ?->city?->title ?? 'یزد',    // City name
                    // 'state' => $ad->organ?->city?->parentCity?->title ?? "Unknown", // State name if you have nested city.
                ];
            }));
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

        $groups = Group::orderBy('name', 'asc')->get();
        $herfes = Herfe::orderBy('name', 'asc')->get();
        $organs = Organ::whereIn('status', [1, 5])->get();
        foreach ($organs as $organ) {
            $organ['ostan'] = City::find($organ->state);
            $organ['city'] = City::find($organ->city);
            $organ['moases'] = Moases::where('organ_id', $organ->id)->pluck('name')->first();
            $organ['time'] = $this->time_index($organ->created_at);
        }
        $organns = [
            [
                'latitude' => 31.87353,
                'longitude' => 54.34087,
                'layer' => "location1", // مثلا: فنی و حرفه‌ای
                'name' => "آموزشگاه الف (خواهران)",
                'address' => "یزد، محله آذر یزدی",
                'gender' => "female"
            ],
            [
                'latitude' => 31.8974,
                'longitude' => 54.3569,
                'layer' => "location2", // مثلا: کامپیوتر
                'name' => "آموزشگاه ب (برادران)",
                'address' => "یزد، میدان آزادی",
                'gender' => "male"
            ],
            [
                'latitude' => 31.8900,
                'longitude' => 54.3600,
                'layer' => "location3", // مثلا: هنر
                'name' => "آموزشگاه ج (چند منظوره)",
                'address' => "یزد، بلوار جمهوری",
                'gender' => "multi"
            ],
            [
                'latitude' => 31.8850,
                'longitude' => 54.3650,
                'layer' => "location1", // مثلا: فنی و حرفه‌ای
                'name' => "آموزشگاه د (چند منظوره)",
                'address' => "یزد، نزدیک بلوار جمهوری",
                'gender' => "multi"
            ],
            [
                'latitude' => 31.9010,
                'longitude' => 54.3500,
                'layer' => "location2", // مثلا: کامپیوتر
                'name' => "آموزشگاه ه (خواهران)",
                'address' => "یزد، خیابان فرخی",
                'gender' => "female"
            ]
        ];
        $news = Khabar::whereNotNull('publish_at')
            ->whereNotNull('archive_at')
            ->where('archive_at', '>=', now())
            ->get();

        //  (اختیاری) اگر می‌خواهید پردازش تصاویر رو در کنترلر انجام بدید:
        foreach ($news as $item) {
            $item->views_count += 1;
            $item->save();
            $media = json_decode($item->media, true) ?? [];
            $item->firstImage = $media[0] ?? null;
            $item->otherImages = array_slice($media, 1);
        }
        $HotNews = Khabar::take(4)->orderByDesc('created_at')->get();
        $herfeha = Group::get();
        $courses = Course::get();
        foreach ($courses as $course) {
            $price = TuitionHerfe::where('year', '1403')->where('herfe_id', $course->herfe_id)->first();

            if ($price && ($price->in_person_fee || $price->online_fee)) {
                if (!is_null($price->in_person_fee)) {
                    $course['PriceIn'] = $price->in_person_fee;
                }

                if (!is_null($price->online_fee)) {
                    $course['PriceOnline'] = $price->online_fee;
                }
            }

            $course->date = Carbon::parse($course->date); // تبدیل به Carbon
        }

        $newCourses = Course::orderByDesc('updated_at')->take(4)->get();
        // $yazd = City::where('title', 'یزد')->first()->id;
        $citys = City::where('active', 1)->where('parent', null)->orderBy('title', 'asc')->get();
        $states = City::where('active', 1)->where('parent', 31)->orderBy('title', 'asc')->get();
        $Advertisement_laddereds = Advertisement::where('status', 1)->orderBy('created_at', 'desc')->take(5)->get();
        $now = now();
        $content_title = Content::where('parent_id', null)->first();
        $contents = Content::whereNotNull('parent_id')->get();
        foreach ($contents as $content) {
            $content['title'] = $content->content['title'];
            $content['text'] = $content->content['text'];
        }
        $register_message = RegisterMessage::first();
        return view('site.index', compact('register_message', 'HotNews', 'states', 'organns', 'content_title', 'contents', 'news', 'organs', 'herfeha', 'citys', 'newCourses', 'courses', 'Advertisement_laddereds', 'sliders', 'groups', 'herfes', 'Advertisements', 'hot'));
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
        $herfes = Group::all();
        return view('site.register', compact('socials', 'states', 'herfes', 'ghanon'));
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
    public function job_index()
    {
        $groups = Group::orderBy('name', 'asc')->get();
        return view('site.job_opportunity.categories',compact('groups'));
    }
}
