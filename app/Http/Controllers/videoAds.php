<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use App\Models\videoAd;
class videoAds extends Controller
{
    //
    
    public function video_list()
    {
        $items = VideoAd::all();
        return view('dashboard.ads.video.list', compact('items'));
    }

    public function video_add()
    {
        return view('dashboard.ads.video.add');
    }

    public function video_addPost(Request $request)
    {
        $data = $request->all();
        $rules = [
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:102400', // حداکثر 100 مگابایت
        ];
        $messages = [
            'video.required' => 'ویدیو الزامی است',
            'video.mimes' => 'فرمت ویدیو باید mp4, mov, avi یا wmv باشد',
            'video.max' => 'حجم ویدیو نباید بیشتر از 100 مگابایت باشد',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = new VideoAd();
        $file = $request->file('video');
        $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $file->move('file/video/videos', $pathName);
        $item->video = 'file/video/videos/' . $pathName;

        DB::beginTransaction();
        try {
            $item->save();
            DB::commit();
            return redirect(route('videoads.list'))->with('success', 'ویدیو با موفقیت ذخیره شد');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
        }
    }

    public function video_delete($id)
    {
        $item = VideoAd::find($id);
        if ($item && $item->video) {
            if (file_exists(public_path($item->video))) {
                unlink(public_path($item->video));
            }
            $item->delete();
            return redirect(route('videoads.list'))->with('success', 'ویدیو با موفقیت حذف شد');
        }
        return redirect(route('videoads.list'))->with('error', 'ویدیو یافت نشد');
    }

    public function video_edit($id)
    {
        $item = VideoAd::find($id);
        return view('dashboard.ads.video.edit', compact('item'));
    }

    public function video_editPost(Request $request, $id)
    {
        $item = VideoAd::find($id);
        if (!$item) {
            return redirect(route('videoads.list'))->with('error', 'ویدیو یافت نشد');
        }

        if ($request->hasFile('video')) {
            if ($item->video && file_exists(public_path($item->video))) {
                unlink(public_path($item->video));
            }

            $file = $request->file('video');
            $pathName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('file/video/videos', $pathName);
            $item->video = 'file/video/videos/' . $pathName;
        }

        $item->save();
        return redirect(route('videoads.list'))->with('success', 'ویدیو با موفقیت بروزرسانی شد');
    }
}
