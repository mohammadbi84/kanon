<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:organs,name',
            'number' => 'required|numeric|unique:organs,number',
            'sodor' => 'required',
            'sodor_start' => 'required',
            'sodor_end' => 'required',
            'mardzan' => 'required|in:1,2,3',
            'tabsare' => 'nullable|in:1',
            'parvane' => 'required|in:1,2',
            'parvane_date' => 'nullable',
            'file_tasis_front' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_tasis_back' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'herfe' => 'required|array|min:1',
            'herfe.*' => 'required|integer',
            // 'herfe_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file' => 'nullable|array|min:1',
            'file.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // اطلاعات موسس - حقیقی
            'haghighi' => 'required|in:1,2',
            'modir_name' => 'required_if:haghighi,1',
            'modir_family' => 'required_if:haghighi,1',
            'modir_national' => 'required_if:haghighi,1',
            'modir_shenasname' => 'required_if:haghighi,1',
            // 'modir_gender' => 'required_if:haghighi,1',
            'modir_father' => 'required_if:haghighi,1',
            'modir_birthday' => 'required_if:haghighi,1',
            'modir_sodor' => 'required_if:haghighi,1',
            'modir_mobile' => 'required_if:haghighi,1|nullable|regex:/^09\d{9}$/',
            'haghighi_number' => 'required_if:haghighi,1',
            'haghighi_prefix' => 'required_if:haghighi,1',
            'modir_email' => 'email|nullable',
            'address_moasses' => 'nullable|max:1000',


            // اطلاعات موسس - حقوقی
            'hoghoghi_name' => 'required_if:haghighi,2',
            'hoghoghi_sabt' => 'required_if:haghighi,2',
            'hoghoghi_modir' => 'required_if:haghighi,2',
            'hoghoghi_tarikh' => 'required_if:haghighi,2',
            // new
            'hoghoghi_tamas' => 'required_if:haghighi,2',
            'hoghoghi_prefix' => 'required_if:haghighi,2',
            'hoghoghi_mobile' => 'required_if:haghighi,2|nullable|regex:/^09\d{9}$/',
            'hoghoghi_address' => 'nullable|max:1000',

            // اطلاعات تماس
            'state' => 'required|numeric',
            'city' => 'required|numeric',
            'address' => 'required|string|max:1000',
            'postal' => 'required|digits:10',
            'tel' => 'required|numeric',
            'fax' => 'nullable|string|max:255',
            'mobile' => 'nullable|regex:/^09\d{9}$/',
            // 'site' => 'required|url',
            // 'email' => 'required|email',

            // رمز عبور
            // 'password' => 'required|string|min:6',
        ];
    }
    public function messages()
    {
        return [
            // فیلدهای اصلی
            'name.required' => 'نام آموزشگاه الزامی است.',
            'name.unique' => 'یک آموزشگاه با این نام ثبت شده است لطفا برای ورود اقدام کنید.',
            'number.required' => 'شماره شناسایی الزامی است.',
            'number.unique' => 'یک آموزشگاه با این شماره شناسایی ثبت شده است لطفا برای ورود اقدام کنید.',
            'sodor.required' => 'محل صدور الزامی است.',
            'sodor_start.required' => 'تاریخ شروع اعتبار الزامی است.',
            'sodor_start.date' => 'تاریخ شروع اعتبار معتبر نیست.',
            'sodor_end.required' => 'تاریخ پایان اعتبار الزامی است.',
            'sodor_end.date' => 'تاریخ پایان اعتبار معتبر نیست.',
            'sodor_end.after_or_equal' => 'تاریخ پایان باید بعد یا برابر با تاریخ شروع باشد.',
            'mardzan.required' => 'انتخاب جنسیت آموزش الزامی است.',
            'mardzan.in' => 'مقدار انتخابی جنسیت آموزش معتبر نیست.',
            'tabsare.required' => 'انتخاب تبصره ۳۴ الزامی است.',
            'tabsare.in' => 'مقدار تبصره ۳۴ معتبر نیست.',
            'parvane.required' => 'نوع پروانه کسب الزامی است.',
            'parvane.in' => 'مقدار نوع پروانه کسب معتبر نیست.',
            'parvane_date.required' => 'تاریخ پروانه کسب الزامی است.',
            'parvane_date.date' => 'تاریخ پروانه کسب معتبر نیست.',
            'file_tasis_front.required' => 'بارگذاری فایل تأسیس رو الزامی است.',
            'file_tasis_front.file' => 'فایل تأسیس رو معتبر نیست.',
            'file_tasis_front.mimes' => 'فرمت فایل تأسیس رو باید یکی از pdf, jpg, jpeg, png باشد.',
            'file_tasis_front.max' => 'حجم فایل تأسیس رو نباید بیشتر از ۲ مگابایت باشد.',
            'file_tasis_back.required' => 'بارگذاری فایل تأسیس پشت الزامی است.',
            'file_tasis_back.file' => 'فایل تأسیس پشت معتبر نیست.',
            'file_tasis_back.mimes' => 'فرمت فایل تأسیس پشت باید یکی از pdf, jpg, jpeg, png باشد.',
            'file_tasis_back.max' => 'حجم فایل تأسیس پشت نباید بیشتر از ۲ مگابایت باشد.',

            // حرفه
            'herfe.required' => 'انتخاب حداقل یک حرفه الزامی است.',
            'herfe.array' => 'ساختار حرفه معتبر نیست.',
            'herfe.*.required' => 'هر آیتم حرفه الزامی است.',
            'herfe.*.integer' => 'آیتم‌های حرفه باید عدد صحیح باشند.',
            'herfe.*.exists' => 'آیتم حرفه انتخاب‌شده معتبر نیست.',
            'herfe_file.required' => 'فایل حرفه الزامی است.',
            'herfe_file.file' => 'فایل حرفه معتبر نیست.',
            'herfe_file.mimes' => 'فرمت فایل حرفه باید یکی از pdf, jpg, jpeg, png باشد.',
            'herfe_file.max' => 'حجم فایل حرفه نباید بیشتر از ۲ مگابایت باشد.',

            // موسس حقیقی
            'haghighi.required' => 'انتخاب نوع شخصیت (حقیقی یا حقوقی) الزامی است.',
            'haghighi.in' => 'مقدار انتخابی برای نوع شخصیت معتبر نیست.',
            'modir_name.required_if' => 'نام مؤسس در حالت حقیقی الزامی است.',
            'modir_family.required_if' => 'نام خانوادگی مؤسس در حالت حقیقی الزامی است.',
            'modir_national.required_if' => 'کد ملی مؤسس در حالت حقیقی الزامی است.',
            'modir_national.digits' => 'کد ملی باید ۱۰ رقم باشد.',
            'modir_shenasname.required_if' => 'شماره شناسنامه مؤسس الزامی است.',
            'modir_gender.required_if' => 'جنسیت مؤسس الزامی است.',
            'modir_gender.in' => 'مقدار جنسیت مؤسس معتبر نیست.',
            'modir_father.required_if' => 'نام پدر مؤسس الزامی است.',
            'modir_birthday.required_if' => 'تاریخ تولد مؤسس الزامی است.',
            'modir_birthday.date' => 'تاریخ تولد مؤسس معتبر نیست.',
            'modir_sodor.required_if' => 'محل صدور مؤسس الزامی است.',
            'modir_mobile.required_if' => 'شماره موبایل الزامی است.',
            'modir_mobile.regex' => 'فرمت شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد.',
            'haghighi_number.required_if' => 'شماره تماس در حالت حقیقی الزامی است',
            'haghighi_number.digits' => 'شماره تماس در حالت حقیقی باید 8 رقم باشد',
            'haghighi_prefix.digits' => 'پیش شماره در حالت حقیقی باید 8 رقم باشد',
            'haghighi_prefix.required_if' => 'پیش شماره در حالت حقیقی الزامی است.',
            'modir_email.email' => 'فرمت ایمیل درست نیست.',
            'address_moasses.required_if' => 'آدرس الزامی است.',
            'address_moasses.max' => 'آدرس نباید بیش از ۱۰۰۰ کاراکتر باشد.',

            // موسس حقوقی
            'hoghoghi_name.required_if' => 'نام شرکت در حالت حقوقی الزامی است.',
            'hoghoghi_sabt.required_if' => 'شماره ثبت شرکت الزامی است.',
            'hoghoghi_modir.required_if' => 'نام مؤسس شرکت الزامی است.',
            'hoghoghi_tarikh.required_if' => 'تاریخ ثبت شرکت الزامی است.',
            'hoghoghi_tarikh.date' => 'تاریخ ثبت شرکت معتبر نیست.',
            // new
            'hoghoghi_tamas.required_if' => 'شماره تماس در حالت حقوقی باید 8 رقم باشد',
            'hoghoghi_prefix.required_if' => 'پیش شماره در حالت حقوقی باید 8 رقم باشد.',
            'hoghoghi_address.required_if' => 'آدرس الزامی است.',
            'hoghoghi_address.max' => 'آدرس نباید بیش از ۱۰۰۰ کاراکتر باشد.',
            'hoghoghi_mobile.required_if' => 'شماره موبایل الزامی است.',
            'hoghoghi_mobile.regex' => 'فرمت شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد.',


            // تماس
            'state.required' => 'استان الزامی است.',
            'state.exists' => 'استان انتخاب‌شده معتبر نیست.',
            'city.required' => 'شهرستان الزامی است.',
            'city.exists' => 'شهر انتخاب‌شده معتبر نیست.',
            'address.required' => 'آدرس الزامی است.',
            'address.max' => 'آدرس نباید بیش از ۱۰۰۰ کاراکتر باشد.',
            'postal.required' => 'کد پستی الزامی است.',
            'postal.digits' => 'کد پستی باید ۱۰ رقم باشد.',
            'tel.required' => 'شماره تلفن الزامی است.',
            'tel.numeric' => 'شماره تلفن باید عددی باشد.',
            'fax.required' => 'شماره فکس الزامی است.',
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex' => 'فرمت شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد.',
            'site.required' => 'آدرس وب‌سایت الزامی است.',
            'site.url' => 'فرمت آدرس وب‌سایت معتبر نیست.',
            'email.required' => 'آدرس ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل معتبر نیست.',

            // رمز عبور
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',

            // file
            'file.required' => 'آپلود حداقل یک فایل عنوان آموزشی الزامی است.',
            'file.array' => 'ساختار فایل عنوان آموزشی معتبر نیست.',
            'file.*.required' => 'آپلود هر فایل عنوان آموزشی الزامی است.',
            'file.*.file' => 'فایل عنوان آموزشی معتبر نیست.',
            'file.*.mimes' => 'فرمت فایل عنوان آموزشی باید یکی از pdf, jpg, jpeg, png باشد.',
            'file.*.max' => 'حجم فایل عنوان آموزشی نباید بیشتر از ۲ مگابایت باشد.',
        ];
    }
}
