<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Jobtype;
use App\Models\Kardanesh;
use App\Models\Khoshe;
use App\Models\SanadHerfe;
use App\Models\Standard;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PersianNLP\WordSegmenter;

use Illuminate\Support\Facades\File as FileFacade;
use Validator;
class SanadController extends Controller
{
    //
    public function list(Request $request)
    {
        $reshte = Group::find($request->id);
        $khoshe = Khoshe::find($reshte->khoshe_id);
        $raste = Standard::find($khoshe->standard_id);
        $items = SanadHerfe::where('group_id', $request->id)->get();
        $jobs = Jobtype::all();
        return view('dashboard.sanad.list', compact('reshte','khoshe','raste', 'items', 'jobs'));
    }
    public function list1(Request $request)
    {
        $reshtes = Group::all();
        $items = SanadHerfe::all();
        $jobs = Jobtype::all();
        return view('dashboard.sanad.list1', compact('reshtes', 'items', 'jobs'));
    }
    public function addPost(Request $request)
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'reshte' => 'required|integer|exists:groups,id',
            'major_title' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'teory_hour' => 'nullable|integer|between:0,23',
            'teory_min' => 'nullable|integer|between:0,59',
            'job' => 'required|integer',
            'update' => 'nullable|string',
            'arshiv' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'reshte.required' => 'انتخاب رشته الزامی است.',
            'reshte.exists' => 'رشته انتخاب شده معتبر نیست.',
            'major_title.required' => 'عنوان اصلی سند الزامی است.',
            'major_title.max' => 'عنوان اصلی سند نباید بیشتر از 255 کاراکتر باشد.',
            'title.required' => 'عنوان سند الزامی است.',
            'title.max' => 'عنوان سند نباید بیشتر از 255 کاراکتر باشد.',
            'code.required' => 'کد سند الزامی است.',
            'code.max' => 'کد سند نباید بیشتر از 50 کاراکتر باشد.',
            'code.unique' => 'این کد سند قبلاً ثبت شده است.',
            'teory_hour.between' => 'ساعت باید بین 0 تا 23 باشد.',
            'teory_min.between' => 'دقیقه باید بین 0 تا 59 باشد.',
            'job.required' => 'نوع شغل الزامی است.',
            'job.exists' => 'نوع شغل انتخاب شده معتبر نیست.',
            'file.mimes' => 'فرمت فایل باید PDF یا Word باشد.',
            'file.max' => 'حجم فایل نباید بیشتر از 2 مگابایت باشد.',
        ]);

        // بررسی وجود رشته اگر id وجود ندارد
        if (!$request->id && !$request->reshte) {
            return redirect()->back()->with('error', 'قبل از افزودن سند، رشته را انتخاب کنید');
        }

        // بررسی خطاهای اعتبارسنجی
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $segmenter = new WordSegmenter();
        $segmentedTitle = $segmenter->segment($request->title);

        // بررسی تکراری نبودن عنوان
        if (SanadHerfe::where('title', $segmentedTitle)->exists()) {
            return back()->with('error', 'این عنوان قبلاً ثبت شده است.');
        }

        DB::beginTransaction();

        try {
            $herfe = new SanadHerfe();
            $herfe->group_id = $request->id ? $request->id : $request->reshte;
            $herfe->major_title = $request->major_title;
            $herfe->title = $segmentedTitle;
            $herfe->code = $request->code;

            // ترکیب ساعت و دقیقه اگر وجود داشته باشند
            if ($request->teory_hour || $request->teory_min) {
                $herfe->date = ($request->teory_hour ?? '00') . ':' . ($request->teory_min ?? '00');
            }

            $herfe->type_id = $request->job;
            $herfe->update = $request->update;
            $herfe->arshiv = $request->arshiv;

            // آپلود فایل
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = 'uploads/sanad/';

                // ایجاد پوشه اگر وجود نداشته باشد
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $filename);
                $herfe->file = $destinationPath . $filename;
            }

            $herfe->save();
            DB::commit();

            return redirect()->back()->with('success', 'ذخیره سند ' . $segmentedTitle . ' با موفقیت انجام شد');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error in addPost: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'خطای سیستمی در ذخیره سند')
                ->withInput();
        }
    }


    public function delete($id)
    {
        $item = SanadHerfe::find($id);
        $name = $item->title;
        if ($item->file) {
            $filePath = $item->file;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $item->delete();
        return redirect(route('sanad.list', ['id' => $item->group_id]))->with('success', 'حذف حرفه ' . $name . ' با موفقیت انجام شد');

    }

    public function edit($id)
    {
        $item = SanadHerfe::find($id);
        $jobs = Jobtype::all();
        $kardaneshs = Kardanesh::all();
        $herfes = SanadHerfe::all();
        return view('dashboard.sanad.edit', compact('item', 'herfes', 'jobs', 'kardaneshs'));
    }


    public function editPost(Request $request, $id)
    {
                // اعتبارسنجی داده‌های ورودی
                $validator = Validator::make($request->all(), [
                    'reshte' => 'required|integer|exists:groups,id',
                    'major_title' => 'required|string|max:255',
                    'title' => 'required|string|max:255',
                    'code' => 'required|string|max:50',
                    'teory_hour' => 'nullable|integer|between:0,23',
                    'teory_min' => 'nullable|integer|between:0,59',
                    'job' => 'required|integer',
                    'update' => 'nullable|string',
                    'arshiv' => 'nullable|string',
                    'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                ], [
                    'reshte.required' => 'انتخاب رشته الزامی است.',
                    'reshte.exists' => 'رشته انتخاب شده معتبر نیست.',
                    'major_title.required' => 'عنوان اصلی سند الزامی است.',
                    'major_title.max' => 'عنوان اصلی سند نباید بیشتر از 255 کاراکتر باشد.',
                    'title.required' => 'عنوان سند الزامی است.',
                    'title.max' => 'عنوان سند نباید بیشتر از 255 کاراکتر باشد.',
                    'code.required' => 'کد سند الزامی است.',
                    'code.max' => 'کد سند نباید بیشتر از 50 کاراکتر باشد.',
                    'code.unique' => 'این کد سند قبلاً ثبت شده است.',
                    'teory_hour.between' => 'ساعت باید بین 0 تا 23 باشد.',
                    'teory_min.between' => 'دقیقه باید بین 0 تا 59 باشد.',
                    'job.required' => 'نوع شغل الزامی است.',
                    'job.exists' => 'نوع شغل انتخاب شده معتبر نیست.',
                    'file.mimes' => 'فرمت فایل باید PDF یا Word باشد.',
                    'file.max' => 'حجم فایل نباید بیشتر از 2 مگابایت باشد.',
                ]);

        $herfe = SanadHerfe::find($id);
        $herfe->major_title = $request->major_title;
        $herfe->title = $request->title;
        $herfe->code = $request->code;
        $herfe->date = $request->teory_hour . ':' . $request->teory_min;
        $herfe->type_id = $request->job;
        $herfe->update = $request->update;
        $herfe->arshiv = $request->arshiv;

        if ($request->hasFile('file')) {

            // حذف فایل قبلی از پوشه public/uploads
            if (FileFacade::exists($herfe->file)) {
                FileFacade::delete($herfe->file);
            }

            // ذخیره فایل جدید
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = 'uploads/sanad'; // مسیر دستی در public/uploads

            $file->move($destinationPath, $filename);
            $newFilePath = $destinationPath . $filename;

            // بروزرسانی مسیر در دیتابیس
            $herfe->file = $newFilePath;
        }
        DB::beginTransaction();

        try {
            $herfe->save();
            DB::commit();
            return redirect(route('sanad.list', ['id' => $herfe->group_id]))->with('success', 'ویرایش سند ' . $request->title . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }
}
