<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Khabar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KhabarController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $khabars = Khabar::latest()->get();
            return response()->json(['data' => $khabars]);
        }
        $khabars = Khabar::latest()->paginate(20);
        return view('admin.khabar.index', compact('khabars'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required',
            'status' => 'nullable',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'cover' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id();

        Khabar::create($data);
        return response()->json(['success' => 'خبر با موفقیت ذخیره شد.']);
    }

    public function edit($id)
    {
        $khabar = Khabar::findOrFail($id);
        return view('admin.khabar.edit', compact('khabar'));
    }

    public function update($id, Request $request)
    {
        $khabar = Khabar::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required',
            'status' => 'nullable',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'cover' => 'nullable',
        ]);
        $khabar->update($request->all());
        return redirect()->route('admin.khabar.index')->with('success', 'خبر با موفقیت ویرایش شد.');
    }

    public function delete($id)
    {
        Khabar::findOrFail($id)->delete();
        return response()->json(['success' => 'خبر با موفقیت حذف شد.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Khabar::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }

    /**
     * 📸 مدیریت عکس‌های پاپ‌آپ (Modal)
     */
    public function showImages($id)
    {
        $khabar = Khabar::findOrFail($id);
        $images = $khabar->files()->where('type', 'image')->get();

        return response()->json(['data' => $images]);
    }

    /**
     * 📤 آپلود عکس برای پاپ‌آپ
     */
    public function uploadImage(Request $request, $id)
    {
        $khabar = Khabar::findOrFail($id);

        $request->validate([
            'file' => 'required|string',
        ], [
            'file.required' => 'انتخاب عکس الزامی است.',
        ]);

        $file = $khabar->files()->create([
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
        // // حذف فایل از دیسک
        // unlink($file->url);
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
