<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PopupController extends Controller
{
    /**
     * لیست پاپ‌آپ‌ها برای DataTable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $popups = Popup::latest()->get();
            return response()->json(['data' => $popups]);
        }

        return view('admin.popups.index');
    }

    /**
     * ذخیره پاپ‌آپ جدید
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'text'        => 'required|string',
            'status'      => 'required|in:0,1',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ], [
            'title.required'      => 'عنوان پاپ‌آپ الزامی است.',
            'text.required'       => 'متن پاپ‌آپ الزامی است.',
            'status.required'     => 'وضعیت پاپ‌آپ را مشخص کنید.',
            'start_date.required' => 'تاریخ شروع الزامی است.',
            'end_date.required'   => 'تاریخ پایان الزامی است.',
            'end_date.after_or_equal' => 'تاریخ پایان باید بعد از تاریخ شروع باشد.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Popup::create($validator->validated());

        return response()->json(['success' => 'پاپ‌آپ با موفقیت اضافه شد.']);
    }

    /**
     * دریافت اطلاعات برای ویرایش
     */
    public function edit($id)
    {
        $popup = Popup::findOrFail($id);
        return response()->json(['data' => $popup]);
    }

    /**
     * بروزرسانی پاپ‌آپ
     */
    public function update(Request $request, $id)
    {
        $popup = Popup::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'text'        => 'required|string',
            'status'      => 'required|in:0,1',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ], [
            'title.required'      => 'عنوان الزامی است.',
            'text.required'       => 'متن الزامی است.',
            'status.required'     => 'وضعیت پاپ‌آپ الزامی است.',
            'start_date.required' => 'تاریخ شروع الزامی است.',
            'end_date.required'   => 'تاریخ پایان الزامی است.',
            'end_date.after_or_equal' => 'تاریخ پایان باید بعد از تاریخ شروع باشد.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $popup->update($validator->validated());

        return response()->json(['success' => 'پاپ‌آپ با موفقیت ویرایش شد.']);
    }

    /**
     * حذف تکی
     */
    public function destroy($id)
    {
        $popup = Popup::findOrFail($id);
        $popup->delete();

        return response()->json(['success' => 'پاپ‌آپ با موفقیت حذف شد.']);
    }

    /**
     * حذف گروهی
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Popup::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }

    /**
     * 📸 مدیریت عکس‌های پاپ‌آپ (Modal)
     */
    public function showImages($id)
    {
        $popup = Popup::findOrFail($id);
        $images = $popup->files()->where('type', 'image')->get();

        return response()->json(['data' => $images]);
    }

    /**
     * 📤 آپلود عکس برای پاپ‌آپ
     */
    public function uploadImage(Request $request, $id)
    {
        $popup = Popup::findOrFail($id);

        $request->validate([
            'file' => 'required|string',
        ], [
            'file.required' => 'انتخاب عکس الزامی است.',
        ]);

        // $file = $request->file('file');
        // $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        // $file->move('uploads/popups', $pathName);
        // $url = 'uploads/popups/' . $pathName;

        $file = $popup->files()->create([
            'url' => $request->file,
            'type' => 'image',
            'status' => 1,
        ]);

        return response()->json(['success' => 'عکس با موفقیت آپلود شد.', 'file' => $file]);
    }

    /**
     * 🗑 حذف عکس از پاپ‌آپ
     */
    public function deleteImage($id)
    {
        $file = File::findOrFail($id);
        // if (!file_exists(public_path($file->url))) {
        //     return response()->json(['error' => 'فایل یافت نشد.'], 404);
        // }
        // // حذف فایل از دیسک
        // unlink(public_path($file->url));
        $file->delete();

        return response()->json(['success' => 'عکس با موفقیت حذف شد.']);
    }

    /**
     * 🔁 تغییر وضعیت عکس (فعال / غیرفعال)
     */
    public function toggleImageStatus($id)
    {
        $file = File::findOrFail($id);
        $file->status = !$file->status;
        $file->save();

        return response()->json(['success' => 'وضعیت عکس با موفقیت تغییر کرد.']);
    }
}
