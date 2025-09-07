<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Group;
use App\Models\Herfe;
use App\Models\HerfeOrgan;
use App\Models\Moases;
use App\Models\Organ;
use App\Models\organsocial;
use App\Models\OrganUser;
use App\Models\ReshteOrgan;
use App\Models\Social;
use App\Models\User;
use App\Models\City;
use App\Models\LogOrgan;
use App\Models\OrganLogChanges;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class SchoolController extends Controller
{
    //
    public function files()
    {
        $user = Auth::user();
        $organ = OrganUser::where('user_id', $user->id)->first();
        $organ = Organ::find($organ->organ_id);
        $files = File::where('organ_id', $organ->id)->get();

        return view('dashboard.organ.files', compact('organ', 'files'));
    }

    public function filesPost(Request $request)
    {
        $user = Auth::user();
        $organ = OrganUser::where('user_id', $user->id)->first();
        if (isset($request->file)) {
            $file = $request->file('file');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/all', $pathName);
            $ff = new File();
            $ff->file = 'file/all/' . $pathName;
            $ff->organ_id = $organ->organ_id;
            $ff->save();
        }
        return redirect()->back();
    }
    public function reshtes()
    {

        $user = Auth::user();
        $organ = OrganUser::where('user_id', $user->id)->first();
        $herfe_id = HerfeOrgan::where('organ_id', $organ->organ_id)->pluck('herfe_id');

        $herfes = Herfe::whereIn('group_id', $herfe_id)->get();
        //        return $herfes;
        foreach ($herfes as $herfe) {
            $old = ReshteOrgan::where('reshte_id', $herfe->id)->where('organ_id', $organ->organ_id)->first();
            if ($old) {
                $herfe['set'] = 1;
            } else {
                $herfe['set'] = 0;
            }
        }
        return view('dashboard.organ.reshte', compact('herfes'));
    }
    public function herfes()
    {
        $user = Auth::user();

        $herfes = Group::all();
        $organ = OrganUser::where('user_id', $user->id)->first();
        foreach ($herfes as $herfe) {
            $old = HerfeOrgan::where('herfe_id', $herfe->id)->where('organ_id', $organ->organ_id)->first();
            if ($old) {
                $herfe['set'] = 1;
            } else {
                $herfe['set'] = 0;
            }
        }
        return view('dashboard.organ.herfe', compact('herfes'));
    }

    public function reshtesPost(Request $request)
    {
        $user = Auth::user();

        $organ = OrganUser::where('user_id', $user->id)->first();
        $olds = ReshteOrgan::where('organ_id', $organ->organ_id)->get();
        foreach ($olds as $old) {
            $old->delete();
        }

        //        return  $request;
        foreach ($request->herfe as $herfe) {
            $herf = new ReshteOrgan();
            $herf->reshte_id = $herfe;
            $herf->organ_id = $organ->organ_id;
            $herf->save();
        }
        return redirect()->back();
    }

    public function herfesPost(Request $request)
    {
        $user = Auth::user();

        $organ = OrganUser::where('user_id', $user->id)->first();
        $olds = HerfeOrgan::where('organ_id', $organ->organ_id)->get();
        foreach ($olds as $old) {
            $old->delete();
        }

        //        return  $request;
        foreach ($request->herfe as $herfe) {
            $herf = new HerfeOrgan();
            $herf->herfe_id = $herfe;
            $herf->organ_id = $organ->organ_id;
            $herf->save();
        }
        return redirect()->back();
    }

    public function list($o_id)
    {
        $organ = Organ::find($o_id);
        $schools = Organ::where('organ_id', $o_id)->get();
        return view('dashboard.school.list', compact('organ', 'schools'));
    }

    public function list1()
    {
        $schools = Organ::where('type', 2)
            ->where('status', '<>', -1)
            ->get();

        return view('dashboard.school.list1', compact('schools'));
    }

    public function add(Request $request, $o_id)
    {
        $organ = Organ::find($o_id);

        return view('dashboard.school.add', compact('organ'));
    }

    public function school_warning(request $request, $id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'خطای سیستمی');
        }
        if (!$request->filled('message')) {
            return redirect()->back()->with('error', 'پیامی وارد کنید ');
        }
        $organ = Organ::find($id);
        if (!$organ) {
            return redirect()->back()->with('error', 'خطای سیستمی');
        }
        if ($organ->status == '1' || $organ->status == '4') {
            $text = $organ->status == '1' ? 'تایید' : 'توسط مدیر تایید';
            return redirect()->back()->with('error', 'آموزشگاه قبلا ' . $text . ' شده است ! ');
        }

        $user = auth()->user();
        $log = new LogOrgan();
        $log->user = $user->id;
        $log->type = '3';
        $log->organ_id = $id;
        $log->save();
        $organ->status = '3';
        $organ->ReferenceText = $request->message;
        $organ->save();
        return redirect()->back()->with('success', 'ارجاع به آموزشگاه مربوط با موفقیت انجام شد !');
    }
    public function school_active($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'خطای سیستمی');
        }

        $organ = Organ::find($id);
        if (!$organ) {
            return redirect()->back()->with('error', 'خطای سیستمی');
        }
        $user = auth()->user();
        $log = new LogOrgan();
        $log->user = $user->id;
        $log->type = '1';
        $log->organ_id = $id;
        $log->save();
        $organ->status = '1';
        $organ->save();
        return redirect()->back()->with('success', 'تایید آموزشگاه با موفقیت انجام شد !');
    }
    public function school_delete($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'خطای سیستمی');
        }

        $organ = Organ::find($id);
        if (!$organ) {
            return redirect()->back()->with('error', 'خطای سیستمی');
        }
        Moases::where('organ_id', $id)->delete();
        organSocial::where('organ_id', $id)->delete();
        HerfeOrgan::where('organ_id', $id)->delete();
        OrganUser::where('organ_id', $id)->delete();
        ReshteOrgan::where('organ_id', $id)->delete();

        $user = auth()->user();
        $log = new LogOrgan();
        $log->user = $user->id;
        $log->type = '2';
        $log->organ_id = $id;
        $log->save();
        $organ->status = '2';
        $organ->save();
        $organ->delete();
        return redirect()->back()->with('success', 'حذف آموزشگاه با موفقیت انجام شد !');
    }

    public function show1($id)
    {
        $organ = Organ::find($id);

        $herfes = Group::with(['herfeOrgan' => function ($query) use ($id) {
            $query->where('organ_id', $id);
        }])->get();

        foreach ($herfes as $her) {
            $her['ok'] = $her->herfeOrgan->isNotEmpty() ? 1 : 0;
        }

        $socials = Social::all();
        $organSocials = OrganSocial::where('organ_id', $id)
            ->whereIn('social_id', $socials->pluck('id'))
            ->get();

        foreach ($socials as $soc) {
            $old = $organSocials->where('social_id', $soc->id)->first();
            $soc['value'] = $old ? $old->address : null;
        }

        $states = City::where('active', 1)->whereNull('parent')
            ->with(['cities' => function ($query) {
                $query->where('active', 1);
            }])->get();

        $moases = Moases::where('organ_id', $id)->first();
        $city = City::find($organ->city);
        $ostan = City::find($organ->state);

        return view('dashboard.school.show1', compact('city', 'ostan', 'moases', 'organ', 'socials', 'states', 'herfes'));
    }
    public function addPost(Request $request, $o_id = null)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //        return $data;
        $organ = new Organ();
        $organ->name = $request->name;

        $organ->lat = $request->lat;
        $organ->lang = $request->lang;
        $organ->number = $request->number;
        $organ->sodor_num = $request->sodor;
        $organ->sodor_start = $request->sodor_start;
        $organ->sodor_end = $request->sodor_end;
        //
        if (isset($request->tabsare34)) {
            $organ->tabsare34 = 1;
        }
        if (isset($request->mardzan)) {
            if ($request->mardzan == 1) {
                $organ->baradaran = 1;

                $organ->khaharan = 0;
            } else {
                $organ->baradaran = 0;

                $organ->khaharan = 1;
            }
        } else {
            if (isset($request->khaharan)) {
                $organ->khaharan = 1;
            }
            if (isset($request->baradaran)) {
                $organ->baradaran = 1;
            }
        }


        $organ->state = $request->state;
        $organ->city = $request->city;

        $organ->address = $request->address;
        $organ->postal = $request->postal;

        $organ->tel = $request->tel;
        $organ->fax = $request->fax;
        $organ->mobile = $request->mobile;

        $organ->email = $request->email;
        $organ->site = $request->site;

        $organ->organ_id = $o_id;
        $organ->type = 2;
        $organ->status = -1;


        if (isset($request->file_moases)) {
            $file = $request->file('file_moases');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/moases', $pathName);
            $organ->file_moases = 'file/moases/' . $pathName;
        }

        if (isset($request->file_logo)) {
            $file = $request->file('file_logo');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/logo', $pathName);
            $organ->file_logo = 'file/logo/' . $pathName;
        }

        if (isset($request->file_tasis)) {
            $file = $request->file('file_tasis');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/tasis', $pathName);
            $organ->file_tasis = 'file/tasis/' . $pathName;
        }

        DB::beginTransaction();

        try {

            $organ->save();

            if (isset($request->herfe)) {
                foreach ($request->herfe as $item) {
                    $herfnew = new HerfeOrgan();
                    $herfnew->organ_id = $organ->id;
                    $herfnew->herfe_id = $item;
                    $herfnew->save();
                }
            }

            $socials = Social::all();
            foreach ($socials as $social) {
                $iid = $social->id;
                $soc = new organsocial();
                $soc->social_id = $social->id;
                $soc->organ_id = $organ->id;
                $soc->address = $request->$iid;
                $soc->save();
            }

            $moases = new Moases();
            $moases->name = $request->modir_name;
            $moases->family = $request->modir_family;
            $moases->national_code = $request->modir_national;
            $moases->shenasname = $request->modir_shenasname;
            $moases->gender = $request->modir_gender;
            $moases->father = $request->modir_father;
            $moases->birthday = $request->modir_birthday;
            $moases->sadere = $request->modir_sodor;
            $moases->sherkat_name = $request->hoghoghi_name;
            $moases->sherkat_sab = $request->hoghoghi_sabt;
            $moases->sherkat_modir = $request->hoghoghi_modir;
            $moases->sherkat_tarikh = $request->hoghoghi_tarikh;
            $moases->organ_id = $organ->id;
            $moases->save();


            //            user
            $member = new User();
            $member->name = '';
            $member->family = '';
            $member->mobile = $request->mobile;
            $member->password = bcrypt($request->password);

            $member->save();

            $member->addRole('organ');

            $membership = new OrganUser();
            $membership->user_id = $member->id;
            $membership->organ_id = $organ->id;
            $membership->role = '1';
            $membership->save();

            DB::commit();
            return redirect('/dashboard/login')->with('success', 'ذخیره آموزشگاه ' . $request->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            return redirect()->back()->with('error', 'خطای سیستمی')->withInput();
            // something went wrong
        }
    }

    public function delete($o_id, $id)
    {
        $organ = Organ::find($id);
        $name = $organ->name;
        $organ->delete();
        return redirect()->back()->with('success', 'حذف آموزشگاه ' . $name . ' با موفقیت انجام شد');
    }

    public function edit($o_id, $id)
    {
        $organ = Organ::find($o_id);
        $school = Organ::find($id);
        return view('dashboard.school.edit', compact('school', 'organ'));
    }
    public function referral_update(Request $request, $id, $o_id = null)
    {
        $url = url()->current();
        $parts = explode('/', $url);
        $section = $parts[count($parts) - 2];

        $data = $request->all();
        $rule = ['name' => 'required'];
        $message = ['name.required' => 'نام الزامی میباشد'];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $organ = Organ::find($id);
        if (!$organ) {
            return redirect()->back()->with('error', 'سازمان یافت نشد')->withInput();
        }

        $changes = [];
        $fieldsToUpdate = ['name', 'lat', 'lang', 'number', 'sodor_num', 'sodor_start', 'sodor_end', 'state', 'city', 'address', 'postal', 'tel', 'fax', 'mobile', 'email', 'site'];

        foreach ($fieldsToUpdate as $field) {
            if ($organ->$field != $request->$field) {
                $changes[] = $field . ': ' . 'orginal=' . $organ->$field . ' now=' . $request->$field;
                $organ->$field = $request->$field;
            }
        }

        $organ->tabsare34 = isset($request->tabsare34) ? 1 : 0;
        if (isset($request->mardzan)) {
            if ($request->mardzan == 1) {
                $organ->baradaran = 1;
                $organ->khaharan = 0;
            } else {
                $organ->baradaran = 0;
                $organ->khaharan = 1;
            }
        } else {
            $organ->baradaran = isset($request->baradaran) ? 1 : 0;
            $organ->khaharan = isset($request->khaharan) ? 1 : 0;
        }

        $organ->organ_id = $o_id;
        $organ->type = 2;
        if ($section == 'admin_update') {
            $organ->status = 4;
        } elseif ($section == 'referral_update') {
            $organ->status = 0;
        }

        if ($request->hasFile('file_moases')) {
            if ($organ->file_moases) {
                $changes[] = "file_moases: original={$organ->file_moases}";
                unlink(public_path($organ->file_moases));
            }
            $file = $request->file('file_moases');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/moases', $pathName);
            $organ->file_moases = 'file/moases/' . $pathName;
            $changes[] = "file_moases: new={$organ->file_moases}";
        }

        if ($request->hasFile('file_logo')) {
            if ($organ->file_logo) {
                $changes[] = "file_logo: original={$organ->file_logo}";
                unlink(public_path($organ->file_logo));
            }
            $file = $request->file('file_logo');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/logo', $pathName);
            $organ->file_logo = 'file/logo/' . $pathName;
            $changes[] = "file_logo: new={$organ->file_logo}";
        }

        if ($request->hasFile('file_tasis')) {
            if ($organ->file_tasis) {
                $changes[] = "file_tasis: original={$organ->file_tasis}";
                unlink(public_path($organ->file_tasis));
            }
            $file = $request->file('file_tasis');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/tasis', $pathName);
            $organ->file_tasis = 'file/tasis/' . $pathName;
            $changes[] = "file_tasis: new={$organ->file_tasis}";
        }

        DB::beginTransaction();
        try {
            $organ->save();
            if (!empty($changes)) {
                $logChange = new OrganLogChanges();
                $logChange->user_id = auth()->id();
                $logChange->organ_id = $organ->id;
                $logChange->changes = implode('; ', $changes);
                $logChange->save();
            }

            if (isset($request->herfe)) {
                HerfeOrgan::where('organ_id', $organ->id)->delete();
                foreach ($request->herfe as $item) {
                    $herfnew = new HerfeOrgan();
                    $herfnew->organ_id = $organ->id;
                    $herfnew->herfe_id = $item;
                    $herfnew->save();
                }
            }

            $socials = Social::all();
            foreach ($socials as $social) {
                $iid = $social->id;
                Organsocial::updateOrCreate(
                    ['social_id' => $social->id, 'organ_id' => $organ->id],
                    ['address' => $request->$iid]
                );
            }

            Moases::updateOrCreate(
                ['organ_id' => $organ->id],
                [
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
                ]
            );

            $member = User::updateOrCreate(
                ['mobile' => $request->mobile],
                ['name' => '', 'family' => '', 'password' => bcrypt($request->password)]
            );

            OrganUser::updateOrCreate(
                ['user_id' => $member->id, 'organ_id' => $organ->id],
                ['role' => '1']
            );

            DB::commit();
            if ($section == 'admin_update') {
                $user = auth()->user();
                $log = new LogOrgan();
                $log->user = $user->id;
                $log->type = '4';
                $log->organ_id = $id;
                $log->save();
                return redirect('dashboard/asnaf/schools-list')->with('success', 'بروزرسانی آموزشگاه ' . $request->name . ' با موفقیت انجام شد');
            } elseif ($section == 'referral_update') {
                $user = auth()->user();
                $log = new LogOrgan();
                $log->user = $user->id;
                $log->type = '5';
                $log->organ_id = $id;
                $log->save();
                return redirect()->back()->with('success', 'بروزرسانی آموزشگاه ' . $request->name . ' با موفقیت انجام شد');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی')->withInput();
        }
    }

    public function editpost(Request $request, $o_id, $id)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $school = Organ::find($id);
        $school->name = $request->name;
        DB::beginTransaction();

        try {

            $school->save();
            DB::commit();
            return redirect(route('school.list', ['o_id' => $o_id]))->with('success', 'ویرایش آموزشگاه ' . $school->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی')->withInput();
            // something went wrong
        }
    }
}
