<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Group;
use App\Models\Organ;
use App\Models\HerfeOrgan;
use App\Models\Social;
use App\Models\organsocial;
use App\Models\Moases;
use App\Models\User;
use App\Models\OrganUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminOrganController extends Controller
{
    public function index()
    {
        $organs = Organ::where('type', 2)->latest()->paginate(10);
        return view('dashboard.organ.index', compact('organs'));
    }

    public function create()
    {
        $socials = Social::all();
        return view('dashboard.organ.create', compact('socials'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $organ = new Organ();
            $organ->name = $request->name;
            $organ->lat = $request->lat;
            $organ->lang = $request->lang;
            $organ->number = $request->number;
            $organ->sodor_num = $request->sodor;
            $organ->sodor_start = $request->sodor_start;
            $organ->sodor_end = $request->sodor_end;

            $organ->tabsare34 = $request->has('tabsare34') ? 1 : 0;
            $organ->baradaran = $request->mardzan == 1 ? 1 : ($request->has('baradaran') ? 1 : 0);
            $organ->khaharan = $request->mardzan == 1 ? 0 : ($request->has('khaharan') ? 1 : 0);

            $organ->state = $request->state;
            $organ->city = $request->city;
            $organ->address = $request->address;
            $organ->postal = $request->postal;
            $organ->tel = $request->tel;
            $organ->fax = $request->fax;
            $organ->mobile = $request->mobile;
            $organ->email = $request->email;
            $organ->site = $request->site;
            $organ->type = 2;

            // فایل‌ها
            if ($request->hasFile('file_moases')) {
                $file = $request->file('file_moases');
                $organ->file_moases = $file->store('file/moases', 'public');
            }
            if ($request->hasFile('file_logo')) {
                $file = $request->file('file_logo');
                $organ->file_logo = $file->store('file/logo', 'public');
            }
            if ($request->hasFile('file_tasis')) {
                $file = $request->file('file_tasis');
                $organ->file_tasis = $file->store('file/tasis', 'public');
            }

            $organ->save();

            // حرفه‌ها
            if ($request->herfe) {
                foreach ($request->herfe as $item) {
                    HerfeOrgan::create([
                        'organ_id' => $organ->id,
                        'herfe_id' => $item,
                    ]);
                }
            }

            // شبکه‌های اجتماعی
            $socials = Social::all();
            foreach ($socials as $social) {
                organsocial::create([
                    'social_id' => $social->id,
                    'organ_id' => $organ->id,
                    'address' => $request->input($social->id),
                ]);
            }

            // موسس
            Moases::create([
                'name' => $request->modir_name,
                'family' => $request->modir_family,
                'national_code' => $request->modir_national,
                'shenasname' => $request->modir_shenasname,
                'gender' => $request->modir_gender,
                'father' => $request->modir_father,
                'birthday' => $request->modir_birthday,
                'sadere' => $request->modir_sodor,
                'sherkat_name' => $request->hoghoghi_name,
                'sherkat_sab' => $request->hoghoghi_sabt,
                'sherkat_modir' => $request->hoghoghi_modir,
                'sherkat_tarikh' => $request->hoghoghi_tarikh,
                'organ_id' => $organ->id,
            ]);

            // کاربر عضو
            $user = User::create([
                'name' => '',
                'family' => '',
                'mobile' => $request->mobile,
                'password' => bcrypt($request->password),
            ]);
            $user->addRole('organ');

            OrganUser::create([
                'user_id' => $user->id,
                'organ_id' => $organ->id,
                'role' => '1',
            ]);

            DB::commit();
            return redirect()->route('organ.index')->with('success', 'آموزشگاه با موفقیت ثبت شد');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'خطا در ثبت اطلاعات')->withInput();
        }
    }

    public function edit($id)
    {
        $organ = Organ::findOrFail($id);

        $states = City::where('active', 1)->whereNull('parent')->get();
        foreach ($states as $state) {
            $state['cities'] = City::where('active', 1)->where('parent', $state->id)->get();
        }

        $cities = City::where('parent', $organ->state)->get(); // برای انتخاب شهر
        $socials = Social::all();
        $herfes = Group::all();

        return view('dashboard.organ.edit', compact('organ', 'states', 'cities', 'socials', 'herfes'));
    }

    public function update(Request $request, $id)
    {
        $organ = Organ::findOrFail($id);
        $organ->update($request->only([
            'name',
            'lat',
            'lang',
            'number',
            'sodor_num',
            'sodor_start',
            'sodor_end',
            'state',
            'city',
            'address',
            'postal',
            'tel',
            'fax',
            'mobile',
            'email',
            'site'
        ]));
        return redirect()->route('organ.index')->with('success', 'آموزشگاه بروزرسانی شد');
    }

    public function destroy($id)
    {
        $organ = Organ::findOrFail($id);

        // حذف روابط مرتبط
        $organ->users()->delete();
        $organ->herfes()->delete();
        $organ->socials()->delete();
        $organ->moases()?->delete(); // چون one-to-one هست

        // حذف خود ارگان
        $organ->delete();

        return redirect()->route('organ.index')->with('success', 'آموزشگاه حذف شد');
    }
    public function status(Organ $organ, Request $request) {
        $organ->status = $request->status;
        $organ->save();
        return redirect()->back()->with('success','وضعیت سازمان با موفقیت تغییر کرد');
    }
}
