<?php

namespace App\Http\Controllers;

use App\Models\Khabar;
use App\Models\Khabar_image;
use App\Models\User;
use Illuminate\Http\Request;
// use Validator;
// use DB;
use Hekmatinasser\Verta\Verta; // Import Verta
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KhabarController extends Controller
{
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_items', []);

        if (!empty($ids)) {
            Khabar::whereIn('id', $ids)->delete();
        }

        return redirect()->back()->with('success', 'آیتم‌های انتخاب‌شده با موفقیت حذف شدند.');
    }
    public function list()
    {
        $khabars = Khabar::all();
        foreach ($khabars as $key => $item) {
            $item->author = User::find($item->user_id) ?? null;
            // نمایش نویسنده
            $authorDisplay = 'بدون نویسنده'; // مقدار پیش‌فرض
            if ($item->author) {
                if (empty($item->author->name)) {
                    $authorDisplay = $item->author->mobile ?? 'بدون نویسنده';
                } else {
                    $authorDisplay = !empty($item->author->family)
                        ? $item->author->name . ' ' . $item->author->family
                        : ($item->author->mobile ?? 'بدون نویسنده');
                }
            }
        }
        return view('dashboard.khabar.list', compact('khabars'));
    }

    public function add()
    {
        return view('dashboard.khabar.add');
    }

    public function addPost(Request $request)
    {
        $data = $request->all();
        $rule = [
            'title' => 'required',
            'text' => 'required',
            'publish_at' => 'required', // Jalali input
            'archive_at' => 'nullable', // Jalali input
            'media' => 'mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ];
        $message = [
            'title.required' => 'عنوان الزامی است',
            'text.required' => 'متن خبر الزامی است',
            'publish_at.required' => 'تاریخ انتشار الزامی است',
            'media.mimes' => 'فقط تصاویر یا ویدیوهای مجاز را آپلود کنید',
            'media.max' => 'حداکثر حجم هر فایل 20MB می‌باشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $convertToEnglish = function ($string) {
            $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            return str_replace($persianDigits, $englishDigits, $string);
        };


        $khabar = new Khabar();
        $khabar->title = $request->title;
        $khabar->text = $request->text;
        $khabar->short = $request->short;
        $khabar->user_id = auth()->id();

        $publish_at_jalali = $convertToEnglish($request->publish_at);
        $archive_at_jalali = $convertToEnglish($request->archive_at);


        // تبدیل تاریخ جلالی به میلادی با Verta و try-catch
        try {
            $khabar->publish_at = Verta::parseFormat('Y/m/d H:i:s', $publish_at_jalali)->toCarbon();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['publish_at' => 'فرمت تاریخ انتشار صحیح نیست.'])->withInput();
        }

        if ($archive_at_jalali) { // اگر تاریخ آرشیو وارد شده بود
            try {
                $khabar->archive_at = Verta::parseFormat('Y/m/d H:i:s', $archive_at_jalali)->toCarbon();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['archive_at' => 'فرمت تاریخ آرشیو صحیح نیست.'])->withInput();
            }
        }


        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/khabar/media', $pathName);
            $khabar->media = 'file/khabar/media/' . $pathName;
        }
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/khabar/media', $pathName);
            $khabar->cover = 'file/khabar/media/' . $pathName;
        }

        DB::beginTransaction();
        try {
            $khabar->save();
            DB::commit();
            return redirect()->route('khabar.list')->with('success', 'خبر با موفقیت اضافه شد');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی')->withInput();
        }
    }


    public function delete($id)
    {
        $Khabar = Khabar::find($id);
        $name = $Khabar->title;
        $Khabar->delete();
        return redirect()->back()->with('success', 'حذف خبر ' . $name . ' با موفقیت انجام شد');
    }

    public function edit($id)
    {
        $khabar = Khabar::find($id);
        return view('dashboard.khabar.edit', compact('khabar'));
    }

    public function editPost(Request $request, $id)
    {
        $data = $request->all();
        $rule = [
            'title' => 'required',
            'text' => 'required',
            'publish_at' => 'nullable', // Keep as string for Jalali input
            'archive_at' => 'nullable', // Keep as string for Jalali input
            'media' => 'mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ];
        $message = [  // Add messages for editPost
            'title.required' => 'عنوان الزامی است',
            'text.required' => 'متن خبر الزامی است',
            'publish_at.required' => 'تاریخ انتشار الزامی است',
            'media.mimes' => 'فقط تصاویر یا ویدیوهای مجاز را آپلود کنید',
            'media.max' => 'حداکثر حجم هر فایل 20MB می‌باشد',
        ];
        $validator = Validator::make($data, $rule, $message); // Pass messages to validator
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $khabar = Khabar::find($id);
        $khabar->title = $request->title;
        $khabar->text = $request->text;
        $khabar->short = $request->short;

        // Convert Jalali to Carbon using Verta
        try {
            $khabar->publish_at = (new Verta($request->publish_at))->datetime();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['publish_at' => 'فرمت تاریخ انتشار صحیح نیست.'])->withInput();
        }

        if ($request->archive_at) {
            try {
                $khabar->archive_at = (new Verta($request->archive_at))->datetime();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['archive_at' => 'فرمت تاریخ آرشیو صحیح نیست.'])->withInput();
            }
        }

        // آپلود و اضافه کردن رسانه‌های جدید
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/khabar/media', $pathName);
            $khabar->media = 'file/khabar/media/' . $pathName;
        }
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/khabar/media', $pathName);
            $khabar->cover = 'file/khabar/media/' . $pathName;
        }

        DB::beginTransaction();
        try {
            $khabar->save();
            DB::commit();
            return redirect(route('khabar.list'))->with('success', 'خبر با موفقیت ویرایش شد');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی')->withInput();
        }
    }
    public function gallary($id)
    {
        $khabar = Khabar::find($id);
        $images = $khabar->images()->get();
        return view('dashboard.khabar.gallary', compact('khabar', 'images'));
    }
    public function addImage(Request $request, $id)
    {
        $request->validate([
            'image.*' => 'mimes:jpg,jpeg,png,mp4,mov,avi|max:2048',
        ], [
            'image.*.mimes' => 'فقط تصاویر یا ویدیوهای مجاز را آپلود کنید',
            'image.*.max' => 'حداکثر حجم هر فایل 2MB می‌باشد',
        ]);
        $khabar = Khabar::find($id);
        $khabar_image = new Khabar_image();
        $khabar_image->khabar_id = $khabar->id;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move('file/khabar/media', $pathName);
            $khabar_image->image_path = 'file/khabar/media/' . $pathName;
            // $khabar_image->save();
            # code...
        }
        $khabar->images()->save($khabar_image);
        return redirect()->back()->with('success', 'تصاویر با موفقیت اضافه شد');
    }
    public function deleteImage($id)
    {
        $khabar_image = Khabar_image::find($id);
        if ($khabar_image) {
            $khabar_image->delete();
        } else {
            return redirect()->back()->with('error', 'تصویر یافت نشد');
        }
        return redirect()->back()->with('success', 'تصویر با موفقیت حذف شد');
    }
}
