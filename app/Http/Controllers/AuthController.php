<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademyCreateRequest;
use App\Http\Requests\StoreOrganRequest;
use App\Models\Academy;
use App\Models\City;
use App\Models\Cluster;
use App\Models\Field;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
        return view('auth.login');
    }
    public function signIn(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            session()->forget('login_attempts'); // موفقیت: ریست شمارنده
            session()->put('user_id', $user->id);
            return redirect(route('register.status'));
        } else {
            return redirect()->back()->withInput()->with('fail', 'شماره موبایل ثبت نشده است لطفا ابتدا ثبت نام کنید.');
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
                        return redirect()->route('admin.index')->with('success', 'خوش آمدید.');
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
                return redirect()->route('admin.index')->with('success', 'خوش آمدید.');
            }
        }
    }
    public function check_organ_id(Request $request)
    {
        $user = $request->user;
        $organ = Academy::where('id_number', $request->number)->first();
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
        return view('auth.loginCode', compact('user'));
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
                return redirect()->route('admin.index')->with('success', 'خوش آمدید.');
            }
            return redirect()->route('panel');
        } else {
            return back()->with('fail', 'کد وارد شده نادرست است.');
        }
    }
    public function forgot_password(Request $request)
    {
        // return $request;
        $status = $request->status ?? 1;
        $user = $request->user;
        return view('auth.forgot-password', compact('status', 'user'));
    }
    public function forgot_password_post(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();
        $organ = Academy::where('id_number', $request->number)->first();
        if ($user and $organ->manager_id == $user->id) {
            $user->sms = rand(100000, 999999);
            $user->save();
            $this->sendSMS($user->sms, $user->mobile);
            return redirect(route('forgot_password', ['status' => 2, 'user' => $user]));
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
                    return redirect()->route('admin.index')->with('success', 'خوش آمدید.');
                }
            } else if ($user->id == 1) {

                Auth::login($user);
                return redirect()->route('admin.index')->with('success', 'خوش آمدید.');
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
        $fields = Field::all();
        $clusters = Cluster::all();

        $states = City::whereNull('parent')->get();
        return view('auth.register', compact('fields', 'clusters', 'states'));
    }
    public function register_post(AcademyCreateRequest $request)
    {

        $data = $request->all();

        $national_code = str_replace('-', '', $request->national_code);
        $postal_code = str_replace('-', '', $request->postal_code);

        $data['national_code'] = $national_code;
        $data['postal_code'] = $postal_code;
        $data['tabsare_34'] = $request->tabsare_34 ? true : false;


        if (isset($request->file_tasis_front)) {
            $license_front = $request->file_tasis_front->store('/licenses', 'public');
        }
        if (isset($request->file_tasis_back)) {
            $license_back = $request->file_tasis_back->store('/licenses', 'public');
        }
        $data['license_file_front'] = $license_front;
        $data['license_file_back'] = $license_back;

        $data['phone'] = $request->phone_prefix . $request->phone;
        $data['fax'] = $request->fax_prefix . $request->fax;


        $data['founder_phone'] = $data['founder_phone'] ? $request->founder_phone_prefix . $request->founder_phone : $request->founder_phone_prefix2  . $request->founder_phone2;
        $data['founder_mobile'] = $data['founder_mobile'] ? $request->founder_mobile : $request->founder_mobile2;
        $data['founder_email'] = $data['founder_email'] ? $request->founder_email : $request->founder_email2;
        $data['founder_address'] = $data['founder_address'] ? $request->founder_address : $request->founder_address2;

        $data['creator_id'] = auth()->id();



        $user = User::where('mobile', $request->founder_mobile ?? $request->founder_mobile2)->first();
        if (!$user) {
            $user = User::create([
                'name' => $request->natural_name ?? $request->legal_manager,
                'family' => $request->natural_family,
                'mobile' => $request->founder_mobile ?? $request->founder_mobile2,
            ]);
        }

        $user->syncRoles(['manager']);

        $data['manager_id'] = $user->id;
        $data['slug'] = Str::slug($request->name);
        $data['status'] = 'approved';

        $academy = Academy::create($data);


        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $index => $singleFile) {
                $path = $singleFile->store('/fields', 'public');
                $file = $academy->files()->create([
                    'url' => $path,
                    'type' => 'image',
                    'status' => 1,
                ]);
            }
        }

        if (isset($request->herfe)) {
            foreach ($request->herfe as $item) {
                $academy->fields()->attach($item);
            }
        }

        return redirect(route('code', ['id' => $user->id]))->with('success', 'ثبت نام آموزشگاه ' . $request->name . ' با موفقیت انجام شد');
    }
    public function status(Request $request)
    {
        // return $request;
        $user = User::findOrFail(session()->get('user_id'));
        $status = $request->status ?? false;

        return view('auth.password', compact('user', 'status'));
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
        return view('auth.code', compact('user'));
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
            $organ_id = $user->academies()->first()->id;
            if ($organ_id) {
                $organ = Academy::find($organ_id);
                $organ->status = 'pending';
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
