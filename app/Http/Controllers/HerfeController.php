<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Herfe;
use App\Models\Jobtype;
use App\Models\Kardanesh;
use App\Models\Khoshe;
use App\Models\Pish;
use App\Models\SanadHerfe;
use App\Models\Standard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
// use DB;
use Illuminate\Support\Facades\File as FileFacade;
use PersianNLP\WordSegmenter;


class HerfeController extends Controller
{
    //


    public function list(Request $request)
    {
        $reshte = Group::find($request->id);
        $khoshe = Khoshe::find($reshte->khoshe_id);
        $raste = Standard::find($khoshe->standard_id);
        $items = Herfe::where('group_id', $request->id)->get();
        foreach ($items as $key => $item) {
            $item['kardaneshe'] = Kardanesh::find($item->kardanesh_id);
            $item['jobtype'] = Jobtype::find($item->type_id);
        }
        $jobs = Jobtype::all();
        $kardaneshs = Kardanesh::all();
        $herfes = Herfe::all();
        //        return view('dashboard.herfe.test',compact('items','jobs','kardaneshs','herfes'));
        return view('dashboard.herfe.list', compact('khoshe', 'raste', 'reshte', 'items', 'jobs', 'kardaneshs', 'herfes'));
    }
    public function list1()
    {
        $items = Herfe::all();
        foreach ($items as $key => $item) {
            $item['kardaneshe'] = Kardanesh::find($item->kardanesh_id);
            $item['jobtype'] = Jobtype::find($item->type_id);
        }
        $jobs = Jobtype::all();
        $kardaneshs = Kardanesh::all();
        $herfes = Herfe::all();
        $reshtes = Group::all();
        return view('dashboard.herfe.list1', compact('items', 'jobs', 'kardaneshs', 'herfes', 'reshtes'));

    }

    public function addPost(Request $request)
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'reshte' => 'required|integer',
            'name' => 'required|string|max:255',
            'old_code' => 'required|string|max:50',
            'code' => 'required|string|max:50',
            'teory_hour' => 'nullable|integer|required_with:teory_min',
            'teory_min' => 'nullable|integer|required_with:teory_hour|between:0,59',

            'amali_hour' => 'nullable|integer|required_with:amali_min',
            'amali_min' => 'nullable|integer|required_with:amali_hour|between:0,59',

            'karvarzi_hour' => 'nullable|integer|required_with:karvarzi_min',
            'karvarzi_min' => 'nullable|integer|required_with:karvarzi_hour|between:0,59',

            'project_hour' => 'nullable|integer|required_with:project_min',
            'project_min' => 'nullable|integer|required_with:project_hour|between:0,59',
            'sum_hour' => 'nullable|integer',
            'sum_min' => 'nullable|integer|between:0,59',
            'job' => 'nullable|integer',
            'kardanesh' => 'nullable|integer',
            'madrak' => 'nullable|integer',
            'salahiat' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pish.*' => 'nullable|integer|exists:herves,id',
        ], [
        // پیغام‌های عمومی
        'required' => 'پر کردن این فیلد اجباری است.',
        'integer' => 'مقدار این فیلد باید عدد باشد.',
        'exists' => 'مقدار انتخاب شده معتبر نیست.',

        // پیغام‌های اختصاصی هر فیلد
        'reshte.required' => 'انتخاب رشته الزامی است.',
        'name.required' => 'وارد کردن نام حرفه الزامی است.',
        'name.max' => 'نام حرفه نباید بیشتر از ۲۵۵ کاراکتر باشد.',

        'code.required' => 'وارد کردن کد استاندارد الزامی است.',
        'code.max' => 'کد استاندارد نباید بیشتر از ۵۰ کاراکتر باشد.',

        'teory_hour.between' => 'ساعت تئوری باید بین ۰ تا ۲۳ باشد.',
        'teory_min.between' => 'دقیقه تئوری باید بین ۰ تا ۵۹ باشد.',

        'amali_hour.between' => 'ساعت عملی باید بین ۰ تا ۲۳ باشد.',
        'amali_min.between' => 'دقیقه عملی باید بین ۰ تا ۵۹ باشد.',

        'karvarzi_hour.between' => 'ساعت کارورزی باید بین ۰ تا ۲۳ باشد.',
        'karvarzi_min.between' => 'دقیقه کارورزی باید بین ۰ تا ۵۹ باشد.',

        'project_hour.between' => 'ساعت پروژه باید بین ۰ تا ۲۳ باشد.',
        'project_min.between' => 'دقیقه پروژه باید بین ۰ تا ۵۹ باشد.',

        'sum_hour.between' => 'ساعت مجموع باید بین ۰ تا ۲۳ باشد.',
        'sum_min.between' => 'دقیقه مجموع باید بین ۰ تا ۵۹ باشد.',
        'teory_hour.required_with' => 'در صورت وارد کردن دقیقه تئوری، ساعت تئوری نیز الزامی است',
        'teory_min.required_with' => 'در صورت وارد کردن ساعت تئوری، دقیقه تئوری نیز الزامی است',

        'amali_hour.required_with' => 'در صورت وارد کردن دقیقه عملی، ساعت عملی نیز الزامی است',
        'amali_min.required_with' => 'در صورت وارد کردن ساعت عملی، دقیقه عملی نیز الزامی است',

        'karvarzi_hour.required_with' => 'در صورت وارد کردن دقیقه کارورزی، ساعت کارورزی نیز الزامی است',
        'karvarzi_min.required_with' => 'در صورت وارد کردن ساعت کارورزی، دقیقه کارورزی نیز الزامی است',

        'project_hour.required_with' => 'در صورت وارد کردن دقیقه پروژه، ساعت پروژه نیز الزامی است',
        'project_min.required_with' => 'در صورت وارد کردن ساعت پروژه، دقیقه پروژه نیز الزامی است',



        'salahiat.max' => 'صلاحیت مربی نباید بیشتر از ۲۵۵ کاراکتر باشد.',

        'file.file' => 'فایل ارسالی معتبر نیست.',
        'file.mimes' => 'فرمت فایل باید PDF یا Word باشد.',
        'file.max' => 'حجم فایل نباید بیشتر از ۲ مگابایت باشد.',

        'pic.image' => 'فایل تصویر باید از نوع عکس باشد.',
        'pic.mimes' => 'فرمت تصویر باید JPG، JPEG یا PNG باشد.',
        'pic.max' => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',

        'pish.*.integer' => 'مقادیر پیش نیازها باید عدد باشند.',
        ]);

        // اگر اعتبارسنجی ناموفق بود
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $segmenter = new WordSegmenter();
        $segmentedName = $segmenter->segment($request->name);

        // بررسی تکراری نبودن نام و کد
        if (Herfe::where('name', $segmentedName)->exists()) {
            return back()->with('error', 'این نام قبلاً ثبت شده است.');
        }

        if (Herfe::where('code', $request->code)->exists()) {
            return back()->with('error', 'این کد استاندارد جدید قبلاً ثبت شده است.');
        }

        DB::beginTransaction();

        try {
            $herfe = new Herfe();
            $herfe->group_id = $request->id ? $request->id : $request->reshte;
            $herfe->name = $segmentedName;
            $herfe->old_code = $request->old_code;
            $herfe->code = $request->code;
            if($request->teory_hour && $request->teory_min )
            $herfe->theory_time = $request->teory_hour   . ':' . $request->teory_min  ;
            if($request->amali_hour && $request->amali_min )
            $herfe->amali_time = $request->amali_hour   . ':' . $request->amali_min    ;
            if($request->karvarzi_hour && $request->karvarzi_min )
            $herfe->karvarzi_time = $request->karvarzi_hour   . ':' . $request->karvarzi_min   ;
            if($request->project_hour && $request->project_min )
            $herfe->project_time = $request->project_hour   . ':' . $request->project_min   ;
            if($request->sum_hour && $request->sum_min )
            $herfe->total_time = $request->sum_hour   . ':' . $request->sum_min   ;
            $herfe->type_id = $request->job;
            $herfe->kardanesh_id = $request->kardanesh;
            $herfe->min_tahsil_id = $request->madrak;
            $herfe->slahiat_morabi = $request->salahiat;
            $herfe->update = $request->update;
            $herfe->active = 1;
            $herfe->arshiv = 1;

            // آپلود فایل
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = './uploads/';
                $file->move($destinationPath, $filename);
                $herfe->file = $destinationPath . $filename;
            }

            // آپلود تصویر
            if ($request->hasFile('pic')) {
                $file = $request->file('pic');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = './uploads/';
                $file->move($destinationPath, $filename);
                $herfe->pic = $destinationPath . $filename;
            }

            $herfe->save();

            // ذخیره پیش نیازها
            if ($request->pish) {
                foreach ($request->pish as $pish) {
                    $pishniaz = new Pish();
                    $pishniaz->herfe_id = $herfe->id;
                    $pishniaz->pish_id = $pish;
                    $pishniaz->save();
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'ذخیره حرفه ' . $segmentedName . ' با موفقیت انجام شد');

        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            return redirect()->back()->with('error', 'خطای سیستمی: ' . $e->getMessage());
        }
    }


    public function delete($id)
    {
        $item = Herfe::find($id);
        if ($item->file) {
            $filePath = $item->file;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $item->delete();


        return redirect()->back()->with('success', 'حذف حرفه  با موفقیت انجام شد');

    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_items', []);
        if (!empty($ids)) {
            foreach (Herfe::whereIn('id', $ids)->get() as $item) {
                $filePath = $item->file;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            Herfe::whereIn('id', $ids)->delete();
        }

        return redirect()->back()->with('success', 'آیتم‌های انتخاب‌شده با موفقیت حذف شدند.');
    }

    public function edit($id)
    {
        $item = Herfe::find($id);
        $jobs = Jobtype::all();
        $kardaneshs = Kardanesh::all();
        $herfes = Herfe::all();

        foreach ($herfes as $herfe) {
            $old = Pish::where('herfe_id', $id)->where('pish_id', $herfe->id)->first();
            if ($old)
                $herfe['select'] = 1;
            else
                $herfe['select'] = 0;
        }
        return view('dashboard.herfe.edit', compact('item', 'herfes', 'jobs', 'kardaneshs'));
    }


    public function editPost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reshte' => 'required|integer',
            'name' => 'required|string|max:255',
            'old_code' => 'required|string|max:50',
            'code' => 'required|string|max:50',
            'teory_hour' => 'nullable|integer|required_with:teory_min',
            'teory_min' => 'nullable|integer|required_with:teory_hour|between:0,59',

            'amali_hour' => 'nullable|integer|required_with:amali_min',
            'amali_min' => 'nullable|integer|required_with:amali_hour|between:0,59',

            'karvarzi_hour' => 'nullable|integer|required_with:karvarzi_min',
            'karvarzi_min' => 'nullable|integer|required_with:karvarzi_hour|between:0,59',

            'project_hour' => 'nullable|integer|required_with:project_min',
            'project_min' => 'nullable|integer|required_with:project_hour|between:0,59',
            'sum_hour' => 'nullable|integer',
            'sum_min' => 'nullable|integer|between:0,59',
            'job' => 'nullable|integer',
            'kardanesh' => 'nullable|integer',
            'madrak' => 'nullable|integer',
            'salahiat' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pish.*' => 'nullable|integer|exists:herves,id',
        ], [
        // پیغام‌های عمومی
        'required' => 'پر کردن این فیلد اجباری است.',
        'integer' => 'مقدار این فیلد باید عدد باشد.',
        'exists' => 'مقدار انتخاب شده معتبر نیست.',

        // پیغام‌های اختصاصی هر فیلد
        'reshte.required' => 'انتخاب رشته الزامی است.',
        'name.required' => 'وارد کردن نام حرفه الزامی است.',
        'name.max' => 'نام حرفه نباید بیشتر از ۲۵۵ کاراکتر باشد.',

        'code.required' => 'وارد کردن کد استاندارد الزامی است.',
        'code.max' => 'کد استاندارد نباید بیشتر از ۵۰ کاراکتر باشد.',

        'teory_hour.between' => 'ساعت تئوری باید بین ۰ تا ۲۳ باشد.',
        'teory_min.between' => 'دقیقه تئوری باید بین ۰ تا ۵۹ باشد.',

        'amali_hour.between' => 'ساعت عملی باید بین ۰ تا ۲۳ باشد.',
        'amali_min.between' => 'دقیقه عملی باید بین ۰ تا ۵۹ باشد.',

        'karvarzi_hour.between' => 'ساعت کارورزی باید بین ۰ تا ۲۳ باشد.',
        'karvarzi_min.between' => 'دقیقه کارورزی باید بین ۰ تا ۵۹ باشد.',

        'project_hour.between' => 'ساعت پروژه باید بین ۰ تا ۲۳ باشد.',
        'project_min.between' => 'دقیقه پروژه باید بین ۰ تا ۵۹ باشد.',

        'sum_hour.between' => 'ساعت مجموع باید بین ۰ تا ۲۳ باشد.',
        'sum_min.between' => 'دقیقه مجموع باید بین ۰ تا ۵۹ باشد.',
        'teory_hour.required_with' => 'در صورت وارد کردن دقیقه تئوری، ساعت تئوری نیز الزامی است',
        'teory_min.required_with' => 'در صورت وارد کردن ساعت تئوری، دقیقه تئوری نیز الزامی است',

        'amali_hour.required_with' => 'در صورت وارد کردن دقیقه عملی، ساعت عملی نیز الزامی است',
        'amali_min.required_with' => 'در صورت وارد کردن ساعت عملی، دقیقه عملی نیز الزامی است',

        'karvarzi_hour.required_with' => 'در صورت وارد کردن دقیقه کارورزی، ساعت کارورزی نیز الزامی است',
        'karvarzi_min.required_with' => 'در صورت وارد کردن ساعت کارورزی، دقیقه کارورزی نیز الزامی است',

        'project_hour.required_with' => 'در صورت وارد کردن دقیقه پروژه، ساعت پروژه نیز الزامی است',
        'project_min.required_with' => 'در صورت وارد کردن ساعت پروژه، دقیقه پروژه نیز الزامی است',



        'salahiat.max' => 'صلاحیت مربی نباید بیشتر از ۲۵۵ کاراکتر باشد.',

        'file.file' => 'فایل ارسالی معتبر نیست.',
        'file.mimes' => 'فرمت فایل باید PDF یا Word باشد.',
        'file.max' => 'حجم فایل نباید بیشتر از ۲ مگابایت باشد.',

        'pic.image' => 'فایل تصویر باید از نوع عکس باشد.',
        'pic.mimes' => 'فرمت تصویر باید JPG، JPEG یا PNG باشد.',
        'pic.max' => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',

        'pish.*.integer' => 'مقادیر پیش نیازها باید عدد باشند.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $item = Herfe::find($id);
        $item->name = $request->name;
        $item->group_id = $request->id ? $request->id : $request->reshte;
        $item->old_code = $request->old_code;
        $item->code = $request->code;
        if($request->teory_hour && $request->teory_min )
        $item->theory_time = $request->teory_hour   . ':' . $request->teory_min  ;
        if($request->amali_hour && $request->amali_min )
        $item->amali_time = $request->amali_hour   . ':' . $request->amali_min    ;
        if($request->karvarzi_hour && $request->karvarzi_min )
        $item->karvarzi_time = $request->karvarzi_hour   . ':' . $request->karvarzi_min   ;
        if($request->project_hour && $request->project_min )
        $item->project_time = $request->project_hour   . ':' . $request->project_min   ;
        if($request->sum_hour && $request->sum_min )
        $item->total_time = $request->sum_hour   . ':' . $request->sum_min   ;
        $item->type_id = $request->job;
        $item->kardanesh_id = $request->kardanesh;
        $item->min_tahsil_id = $request->madrak;
        $item->slahiat_morabi = $request->salahiat;
        $item->update = $request->update;
        $item->active = 1;
        $item->arshiv = $request->arshiv;

        if ($request->hasFile('file')) {

            // حذف فایل قبلی از پوشه public/uploads
            if (FileFacade::exists($item->file)) {
                FileFacade::delete($item->file);
            }

            // ذخیره فایل جدید
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = 'uploads/'; // مسیر دستی در public/uploads

            $file->move($destinationPath, $filename);
            $newFilePath = $destinationPath . $filename;

            // بروزرسانی مسیر در دیتابیس
            $item->file = $newFilePath;
        }
        DB::beginTransaction();

        try {
            $item->save();
            $olds = Pish::where('herfe_id', $id)->get();
            foreach ($olds as $old) {
                $old->delete();
            }
            foreach ($request->pish as $pish) {
                $pishniaz = new Pish();
                $pishniaz->herfe_id = $item->id;
                $pishniaz->pish_id = $pish;
                $pishniaz->save();
            }


            DB::commit();
            return redirect(route('herfe.list', ['id' => $item->group_id]))->with('success', 'ویرایش حرفه ' . $request->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }

}
