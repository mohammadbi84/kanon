<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganRequest;
use App\Models\City;
use App\Models\File;
use App\Models\Group;
use App\Models\HerfeOrgan;
use App\Models\Khoshe;
use App\Models\LoginPageAd;
use App\Models\Moases;
use App\Models\Organ;
use App\Models\organsocial;
use App\Models\OrganUser;
use App\Models\RegisterAlert;
use App\Models\Setting;
use App\Models\Social;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function sms()
    {
        return view('site.school');
    }
    function sendSMS($code, $mobile)
    {
        $sms = Http::get('https://smspanel.trez.ir/SendPatternWithUrl.ashx', [
            'accessHash' => 'bb47d21f-c5af-47b8-8aad-0b3dff269aa1',
            'PhoneNumber' => '90004769',
            'PatternId' => '98e00938-b72e-48ff-80f8-670c9ebfe822',
            'token1' => $code,
            'RecNumber' => $mobile,
            'Smsclass' => 1
        ]);
        return $sms;
    }
    public function login()
    {
        $sliders = LoginPageAd::all();
        return view('auth.login', compact('sliders'));
    }
    public function signIn(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            $organ_id = OrganUser::where('user_id', $user->id)->where('role', 1)->first();
            if ($organ_id) {
                $organ = Organ::find($organ_id->organ_id);
            } else {
                $organ = null;
            }
            session()->forget('login_attempts'); // موفقیت: ریست شمارنده
            return redirect(route('register.status', ['user' => $user, 'organ' => $organ]));
        } else {
            return redirect()->back()->withInput()->with('fail', 'شماره موبایل اشتباه است لطفا دوباره تلاش کنید.');
        }
    }
    public function check_password(Request $request)
    {
        // شمارش دفعات ورود اشتباه
        $attempts = session()->get('login_attempts', 0);

        // اگر بیشتر از یک بار اشتباه کرده بود، کپچا رو اعتبارسنجی کن
        $rules = [
            'mobile' => 'required',
            'password' => 'required',
        ];

        if ($attempts >= 1) {
            $rules['captcha'] = 'required|captcha';
        }

        $request->validate($rules);


        $user = User::where('mobile', $request->mobile)->first();
        if ($user->hasRole('admin') || $user->hasRole('organ')) {
            if ($user and $user->id != 1) {
                if (Hash::check($request->password, $user->password)) {
                    session()->forget('login_attempts'); // موفقیت: ریست شمارنده
                    Auth::login($user);
                    if ($user->hasRole('admin')) {
                        return redirect('/dashboard/home');
                    } else {
                        return redirect(route('panel'))->with('success', 'با موفقیت وارد شدید.');
                    }
                } else {
                    // ورود ناموفق
                    session()->put('login_attempts', $attempts + 1);
                    return redirect()->back()->with('fail', 'رمز عبور اشتباه است لطفا دوباره تلاش کنید.');
                }
            } else if ($user->id == 1) {
                Auth::login($user);
                return redirect('/dashboard/home');
            }
        }
    }
    public function check_organ_id(Request $request)
    {
        $user = $request->user;
        $organ = Organ::where('number', $request->number)->first();
        if ($organ) {
            $status = true;
            return redirect(route('register.status', ['user' => $user, 'organ' => $organ, 'status' => $status]));
        } else {
            return back()->with('fail', 'شماره شناسایی آموزشگاه معتبر نیست.');
        }
    }
    public function one_time_password(Request $request)
    {
        $user = User::find($request->user);
        $user->sms = rand(100000, 999999);
        $user->save();
        $this->sendSMS($user->sms, $user->mobile);
        return redirect(route('loginCode', ['user' => $user]));
    }
    public function loginCode(Request $request)
    {
        // ورود با رمز یکبار مصرف
        $user = $request->user;
        $sliders = LoginPageAd::all();
        return view('auth.loginCode', compact('sliders', 'user'));
    }
    public function verifyCode(Request $request)
    {
        $request->validate([
            'user' => 'required|exists:users,id',
            'code' => 'required|array|size:6',
            'code.*' => 'numeric',
        ]);

        // تبدیل آرایه کد به یک رشته مثل "123456"
        $enteredCode = implode('', $request->code);

        // پیدا کردن کاربر
        $user = User::find($request->user);

        // بررسی تطابق کد
        if ($user->sms === $enteredCode) {
            Auth::login($user);

            // پاک‌کردن کد برای امنیت بیشتر
            $user->update(['sms' => null]);
            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            }
            return redirect()->route('panel');
        } else {
            return back()->with('fail', 'کد وارد شده نادرست است.');
        }
    }
    public function forgot_password(Request $request)
    {
        // return $request;
        $sliders = LoginPageAd::all();
        $status = $request->status ?? 1;
        $user = $request->user;
        return view('auth.forgot-password', compact('sliders', 'status','user'));
    }
    public function forgot_password_post(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        $organ = Organ::where('number', $request->number)->first();
        if ($user and OrganUser::where('user_id', $user->id)->where('organ_id', $organ->id)->first()) {
            $user->sms = rand(100000, 999999);
            $user->save();
            $this->sendSMS($user->sms, $user->mobile);
            return redirect(route('forgot_password', ['status' => 2,'user'=>$user]));
        } else {
            return redirect()->back()->with('fail', 'اطلاعات وارد شده اشتباه است لطفا دوباره تلاش کنید.');
        }
    }
    public function forgot_password_code_check(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'password' => 'required',
            'code' => 'required|array|size:6',
            'code.*' => 'numeric',
        ]);
        // return view('auth.code',compact('user'));
        $enteredCode = implode('', $request->code);
        $user = user::where('sms', $enteredCode)->where('id', $request->id)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect(route('login'))->with('success', 'رمز عبور با موفقیت تغییر گردید.');
        } else {
            return redirect()->back()->with('fail', 'اطلاعات وارد شده اشتباه است');
        }
    }
    public function loginPost(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        // dd($user);
        if ($user->hasRole('admin') || $user->hasRole('organ')) {
            if ($user and $user->id != 1) {
                if (Hash::check($request->password, $user->password)) {
                    Auth::login($user);
                    return redirect('/dashboard/home');
                }
            } else if ($user->id == 1) {

                Auth::login($user);
                return redirect('/dashboard/home');
            }
        }
        return redirect()->back()->with('msg', 'موبایل یا رمز عبور اشتباه است');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
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
        $herfes = Group::orderBy('name', 'asc')->get();
        // $citys = City::where('active', 1)->where('parent', null)->orderBy('title','asc')->get();
        $organs = Organ::where('status', 1)->take(1)->get();
        foreach ($organs as $organ) {
            $organ['ostan'] = City::find($organ->state);
            $organ['city'] = City::find($organ->city);
            $organ['moases'] = Moases::where('organ_id', $organ->id)->pluck('name')->first();
            $organ['time'] = $this->time_index($organ->created_at);
        }
        $alert = RegisterAlert::first();
        $khoshes = Khoshe::with('herfes')->orderBy('name', 'asc')->get();
        return view('auth.register', compact('khoshes', 'socials', 'alert', 'states', 'herfes', 'ghanon', 'organs'));
    }
    public function register_post(StoreOrganRequest $request)
    {
        // return $request;
        // return $request;
        // $user = User::where('mobile', $request->mobile)->first();
        // if ($user) {
        //     $user->sms = '123456';
        //     $user->save();
        //     return redirect(route('code', ['id' => $user->id]))->with('success', 'شما یک آموزشگاه دارید لطفا وارد شوید');
        // }
        // return redirect('/');
        //        return $data;

        $modir_national = str_replace('-', '', $request->modir_national);
        $postal = str_replace('-', '', $request->postal);

        $organ = new Organ();
        $organ->name = $request->name;

        $organ->lat = ' ';
        $organ->lang = ' ';
        $organ->number = $request->number;
        $organ->sodor_num = $request->sodor;
        $organ->sodor_start = $request->sodor_start;
        $organ->sodor_end = $request->sodor_end;
        //
        if ($request->tabsare) {
            $organ->tabsare34 = 1;
        }
        if ($request->mardzan == 1) {
            $organ->baradaran = 1;
            $organ->khaharan = 0;
        } elseif ($request->mardzan == 2) {
            $organ->baradaran = 0;
            $organ->khaharan = 1;
        } else {
            $organ->baradaran = 1;
            $organ->khaharan = 1;
            $organ->tabsare34 = 1;
        }

        $organ->state = $request->state;
        $organ->city = $request->city;

        $organ->address = $request->address;
        $organ->postal = $postal;

        $organ->tel = $request->tel_prefix . '-' . $request->tel;
        $organ->fax = $request->fax_prefix . '-' . $request->fax;
        $organ->mobile = $request->mobile ?? $request->modir_mobile ?? $request->hoghoghi_mobile;

        $organ->email = $request->email;
        $organ->site = $request->site;

        $organ->parvane_type = $request->parvane;
        $organ->parvane_date = $request->parvane_date;

        // $organ->organ_id = $o_id;
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

        if (isset($request->file_tasis_front)) {
            $file = $request->file('file_tasis_front');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/tasis', $pathName);
            $organ->file_tasis = 'file/tasis/' . $pathName;
        }
        if (isset($request->file_tasis_back)) {
            $file = $request->file('file_tasis_back');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/tasis', $pathName);
            $organ->file_tasis_back = 'file/tasis/' . $pathName;
        }

        if (isset($request->herfe_file)) {
            $file = $request->file('herfe_file');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/herfe_file', $pathName);
            $organ->herfes_file = 'file/herfe_file/' . $pathName;
        }


        DB::beginTransaction();

        try {

            $organ->save();

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $index => $singleFile) {
                    if ($singleFile) {
                        $pathName = time() . rand(1000, 9999) . '.' . $singleFile->getClientOriginalExtension();
                        $singleFile->move('file/herfe_file', $pathName);
                        // $organ->file_tasis_back = 'file/herfe_file/' . $pathName;
                        $organfiles = File::create(['organ_id' => $organ->id, 'file' => 'file/herfe_file/' . $pathName]);
                    }
                }
            }

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

            $moases = Moases::where('mobile', $request->modir_mobile ?? $request->hoghoghi_mobile)->first();
            if (!$moases) {
                $moases = new Moases();
                $moases->name = $request->modir_name;
                $moases->family = $request->modir_family;
                $moases->mobile = $request->modir_mobile ?? $request->hoghoghi_mobile;
                $moases->address = $request->address_moasses ?? $request->hoghoghi_address;
                $moases->national_code = $modir_national;
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
                $moases->tamas = $request->haghighi_prefix . "-" . $request->haghighi_number ?? $request->hoghoghi_tamas . "-" . $request->hoghoghi_prefix;
                $moases->email = $request->modir_email;
                $moases->save();
            }

            //            user
            $member = User::where('mobile', $request->modir_mobile ?? $request->hoghoghi_mobile)->first();
            if (!$member) {
                $member = new User();
                $member->name = $request->modir_name ?? $request->hoghoghi_modir;
                $member->family = $request->modir_family;
                $member->mobile = $request->modir_mobile ?? $request->hoghoghi_mobile;
                $member->save();
            }

            $member->addRole('organ');

            $membership = new OrganUser();
            $membership->user_id = $member->id;
            $membership->organ_id = $organ->id;
            $membership->role = '1';
            $membership->save();

            DB::commit();
            $user = User::findOrFail($member->id);
            $user->sms = rand(100000, 999999);
            $user->save();
            $this->sendSMS($user->sms, $user->mobile);
            return redirect(route('code', ['id' => $member->id]))->with('success', 'ثبت نام آموزشگاه ' . $request->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            // return redirect()->back()->with('error', 'خطای سیستمی')->withInput();
            // something went wrong
        }
    }
    public function status(Request $request)
    {
        $sliders = LoginPageAd::all();
        // return $request;
        $user = User::find($request->user);
        $organ = Organ::find($request->organ);
        $status = $request->status ?? false;

        return view('auth.password', compact('user', 'organ', 'status', 'sliders'));
    }
    public function loginCode_post(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        $user->sms = '123456';
        $user->save();
        return redirect(route('code', ['id' => $user->id]));
    }
    public function set_password(Request $request)
    {
        // return $request;
        $request->validate([
            'password' => 'required',
            'password_repet' => 'required|same:password',
        ], [
            'password.required' => 'وارد کردن رمز عبور الزامی است.',
            'password_repet.required' => 'وارد کردن تکرار رمز عبور الزامی است.',
            'password_repet.same' => 'رمز عبور با تکرار رمز عبور یکی نیست.',
        ]);
        // return $request;
        $user = User::findOrFail($request->user);
        $user->password = bcrypt($request->password);
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
        $user->save();
        Auth::login($user);
        return redirect(route('panel'))->with('success', 'رمز عبور با موفقیت تعیین شد');
        // return redirect('/login')->with('success', 'رمز عبور با موفقیت تعیین شد');
    }
    public function code($id)
    {
        $user = User::findOrFail($id);
        $sliders = LoginPageAd::all();
        return view('auth.code', compact('user', 'sliders'));
    }
    public function code_check(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'code' => 'required|array|size:6',
            'code.*' => 'numeric',
        ]);
        // return view('auth.code',compact('user'));
        $enteredCode = implode('', $request->code);
        $user = user::where('sms', $enteredCode)->where('id', $request->id)->first();
        if ($user) {
            $organ_id = OrganUser::where('user_id', $user->id)->first()->organ_id;
            if ($organ_id) {
                $organ = Organ::find($organ_id);
                $organ->status = '0';
                $organ->save();
                // $user->sms = null;
                $user->active = 1;
                $user->save();
            }
            Auth::login($user);
            return redirect(route('login'))->with('success', 'شماره موبایل با موفقیت تایید شد و درخواست شما در حال بررسی می‌باشد');
        } else {
            return redirect(route('code', ['id' => $request->id]))->with('fail', 'اطلاعات وارد شده اشتباه است');
        }
    }
    public function resendCode(User $user)
    {
        try {
            // تولید کد جدید
            $code = rand(100000, 999999);

            // ذخیره کد جدید در دیتابیس
            $user->update([
                'sms' => $code,
            ]);

            // ارسال SMS
            $smsResult = $this->sendSMS($code, $user->mobile);

            if ($smsResult->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'کد تأیید با موفقیت ارسال شد'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'خطا در ارسال پیامک'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
