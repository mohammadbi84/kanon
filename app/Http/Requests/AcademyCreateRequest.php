<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:academies,name',
            'id_number' => 'required|numeric|unique:academies,id_number',
            'export_number' => 'required',
            'export_start' => 'required',
            'export_end' => 'required',
            'license' => 'required|in:first,extension',
            'first_license_date' => 'nullable',
            'gender' => 'required|in:male,female,both',
            'tabsare_34' => 'nullable|in:1',

            // اطلاعات موسس - حقیقی
            'haghighi' => 'required|in:1,2',
            'natural_name' => 'required_if:haghighi,1',
            'natural_family' => 'required_if:haghighi,1',
            'natural_father' => 'required_if:haghighi,1',
            'natural_birth_date' => 'required_if:haghighi,1',
            'national_code' => 'required_if:haghighi,1',
            'national_id_number' => 'required_if:haghighi,1',
            'natural_issue' => 'required_if:haghighi,1',

            'founder_phone' => 'required_if:haghighi,1',
            'founder_phone_prefix' => 'required_if:haghighi,1',
            'founder_mobile' => 'required_if:haghighi,1|nullable|regex:/^09\d{9}$/',
            'founder_email' => 'email|nullable',
            'founder_address' => 'nullable|max:1000',
            // اطلاعات موسس - حقوقی
            'legal_company_name' => 'required_if:haghighi,2',
            'legal_register_number' => 'required_if:haghighi,2',
            'register_date' => 'required_if:haghighi,2',
            'legal_manager' => 'required_if:haghighi,2',
            // new
            'founder_phone2' => 'required_if:haghighi,2',
            'founder_phone_prefix2' => 'required_if:haghighi,2',
            'founder_mobile2' => 'required_if:haghighi,2|nullable|regex:/^09\d{9}$/',
            'founder_email2' => 'email|nullable',
            'founder_address2' => 'nullable|max:1000',

            // اطلاعات تماس
            'state_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'postal_code' => 'required',
            'fax' => 'nullable|string|max:255',
            'mobile' => 'nullable|regex:/^09\d{9}$/',
            'address' => 'required|string|max:1000',
            'phone' => 'required|numeric',
            'phone_prefix' => 'required|numeric',

            // فایل ها
            'file_tasis_front' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_tasis_back' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'herfe' => 'required|array|min:1',
            'herfe.*' => 'required|integer',
            'file' => 'nullable|array|min:1',
            'file.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
    public function messages()
    {
        return [
            // فیلدهای اصلی
            'name.required' => 'نام آموزشگاه الزامی است.',
            'name.unique' => 'یک آموزشگاه با این نام ثبت شده است لطفا برای ورود اقدام کنید.',
            'id_number.required' => 'شماره شناسایی الزامی است.',
            'id_number.unique' => 'یک آموزشگاه با این شماره شناسایی ثبت شده است لطفا برای ورود اقدام کنید.',
            'export_number.required' => 'محل صدور الزامی است.',
            'export_start.required' => 'تاریخ شروع اعتبار الزامی است.',
            'export_start.date' => 'تاریخ شروع اعتبار معتبر نیست.',
            'export_end.required' => 'تاریخ پایان اعتبار الزامی است.',
            'export_end.date' => 'تاریخ پایان اعتبار معتبر نیست.',
            'export_end.after_or_equal' => 'تاریخ پایان باید بعد یا برابر با تاریخ شروع باشد.',
            'gender.required' => 'انتخاب جنسیت آموزش الزامی است.',
            'gender.in' => 'مقدار انتخابی جنسیت آموزش معتبر نیست.',
            'tabsare_34.required' => 'انتخاب تبصره ۳۴ الزامی است.',
            'tabsare_34.in' => 'مقدار تبصره ۳۴ معتبر نیست.',
            'license.required' => 'نوع پروانه کسب الزامی است.',
            'license.in' => 'مقدار نوع پروانه کسب معتبر نیست.',
            'first_license_date.required' => 'تاریخ پروانه کسب الزامی است.',
            'first_license_date.date' => 'تاریخ پروانه کسب معتبر نیست.',

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
            'natural_name.required_if' => 'نام مؤسس در حالت حقیقی الزامی است.',
            'natural_family.required_if' => 'نام خانوادگی مؤسس در حالت حقیقی الزامی است.',
            'national_code.required_if' => 'کد ملی مؤسس در حالت حقیقی الزامی است.',
            'national_code.digits' => 'کد ملی باید ۱۰ رقم باشد.',
            'national_id_number.required_if' => 'شماره شناسنامه مؤسس الزامی است.',
            'natural_father.required_if' => 'نام پدر مؤسس الزامی است.',
            'natural_birth_date.required_if' => 'تاریخ تولد مؤسس الزامی است.',
            'natural_birth_date.date' => 'تاریخ تولد مؤسس معتبر نیست.',
            'natural_issue.required_if' => 'محل صدور مؤسس الزامی است.',




            'founder_mobile.required_if' => 'شماره موبایل الزامی است.',
            'founder_mobile.regex' => 'فرمت شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد.',
            'founder_phone.required_if' => 'شماره تماس در حالت حقیقی الزامی است',
            'founder_phone.digits' => 'شماره تماس در حالت حقیقی باید 8 رقم باشد',
            'founder_phone_prefix.digits' => 'پیش شماره در حالت حقیقی باید 8 رقم باشد',
            'founder_phone_prefix.required_if' => 'پیش شماره در حالت حقیقی الزامی است.',
            'founder_email.email' => 'فرمت ایمیل درست نیست.',
            'founder_address.required_if' => 'آدرس الزامی است.',
            'founder_address.max' => 'آدرس نباید بیش از ۱۰۰۰ کاراکتر باشد.',
            'founder_mobile2.required_if' => 'شماره موبایل الزامی است.',
            'founder_mobile2.regex' => 'فرمت شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد.',
            'founder_phone2.required_if' => 'شماره تماس در حالت حقیقی الزامی است',
            'founder_phone2.digits' => 'شماره تماس در حالت حقیقی باید 8 رقم باشد',
            'founder_phone_prefix2.digits' => 'پیش شماره در حالت حقیقی باید 8 رقم باشد',
            'founder_phone_prefix2.required_if' => 'پیش شماره در حالت حقیقی الزامی است.',
            'founder_email2.email' => 'فرمت ایمیل درست نیست.',
            'founder_address2.required_if' => 'آدرس الزامی است.',
            'founder_address2.max' => 'آدرس نباید بیش از ۱۰۰۰ کاراکتر باشد.',

            // موسس حقوقی
            'legal_company_name.required_if' => 'نام شرکت در حالت حقوقی الزامی است.',
            'legal_register_number.required_if' => 'شماره ثبت شرکت الزامی است.',
            'legal_manager.required_if' => 'نام مؤسس شرکت الزامی است.',
            'register_date.required_if' => 'تاریخ ثبت شرکت الزامی است.',
            'register_date.date' => 'تاریخ ثبت شرکت معتبر نیست.',


            // تماس
            'state_id.required' => 'استان الزامی است.',
            'state_id.exists' => 'استان انتخاب‌شده معتبر نیست.',
            'city_id.required' => 'شهرستان الزامی است.',
            'city_id.exists' => 'شهر انتخاب‌شده معتبر نیست.',
            'address.required' => 'آدرس الزامی است.',
            'address.max' => 'آدرس نباید بیش از ۱۰۰۰ کاراکتر باشد.',
            'postal_code.required' => 'کد پستی الزامی است.',
            'postal_code.digits' => 'کد پستی باید ۱۰ رقم باشد.',
            'phone.required' => 'شماره تلفن الزامی است.',
            'phone.numeric' => 'شماره تلفن باید عددی باشد.',
            'phone_prefix.required' => 'شماره تلفن الزامی است.',
            'phone_prefix.numeric' => 'شماره تلفن باید عددی باشد.',
            'fax.required' => 'شماره فکس الزامی است.',
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex' => 'فرمت شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد.',
            'email.required' => 'آدرس ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل معتبر نیست.',

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
