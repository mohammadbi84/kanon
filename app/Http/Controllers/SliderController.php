<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\topadv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class SliderController extends Controller
{
    //

    public function list()
    {
        $items = Slider::orderBy('id', 'desc')->get();


        return view('dashboard.slider.list', compact('items'));
    }



    public function addPost(Request $request)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = new Slider();
        $item->name = $request->name;
        // if (isset($request->file)) {
        //     $file = $request->file('file');
        //     $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        //     $file->move('file/slide/images', $pathName);
        //     $item->image = 'file/slide/images/' . $pathName;
        // }
        $item->image = $request->image;
        $item->show_time = $request->show_time;
        $item->order = $request->order;
        // if (isset($request->video)) {
        //     $file = $request->file('video');
        //     $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        //     $file->move('file/slide/video', $pathName);
        //     $item->video = 'file/slide/video/' . $pathName;
        // }
        $item->video = $request->video;

        DB::beginTransaction();

        try {
            $item->save();
            DB::commit();
            return redirect(route('slider.list'))->with('success', 'ذخیره slider  با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }

    public function delete($id)
    {
        $item = Slider::find($id);
        $item->delete();
        return redirect(route('slider.list'))->with('success', 'حذف slider  با موفقیت انجام شد');
    }
    public function release($id, $type)
    {
        $slider = Slider::find($id);
        $slider->type = $type;
        $slider->save();
        if ($type == 0) {
            return redirect(route('slider.list'))->with('success', 'اسلایدر با موفقیت منتشر شد');
        } else {
            return redirect(route('slider.list'))->with('success', 'اسلایدر عدم انتشار یافت');
        }
    }

    public function edit($id)
    {
        $item = Slider::find($id);
        return view('dashboard.slider.edit', compact('item'));
    }
    public function editPost(Request $request, $id)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (!$request->image && !$request->video) {
            return redirect()->back()->with('error', 'اسلایدر باید عکس یا ویدیو داشته باشد');
        }
        $item = Slider::find($id);
        $item->name = $request->name;
        // if (isset($request->file)) {
        //     $file = $request->file('file');
        //     $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        //     $file->move('file/slide/images', $pathName);
        //     $item->image = 'file/slide/images/' . $pathName;
        // }
        $item->image = $request->image;
        $item->show_time = $request->show_time;
        $item->order = $request->order;
        // if (isset($request->video)) {
        //     $file = $request->file('video');
        //     $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        //     $file->move('file/slide/video', $pathName);
        //     $item->video = 'file/slide/video/' . $pathName;
        // }
        $item->video = $request->video;
        DB::beginTransaction();

        try {
            $item->save();

            DB::commit();
            return redirect(route('slider.list'))->with('success', 'ویرایش slider  با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }
    public function deleteMedia($id, Request $request)
    {
        $slider = Slider::findOrFail($id);

        if ($request->type == 1) { // Check if type is 1 for image
            if ($slider->video) {
                if (file_exists($slider->image)) {
                    unlink($slider->image);
                }
                $slider->image = 'no-image.png';
                $slider->save();
                return redirect()->back()->with('success', 'تصویر با موفقیت حذف شد');
            } else {
                return redirect()->back()->with('error', 'اسلایدر نمیتواند بدون عکس و ویدیو باشد.');
            }
        } elseif ($request->type == 2) { // Check if type is 2 for video
            if ($slider->video) {
                if (file_exists($slider->video)) {
                    unlink($slider->video);
                }
                $slider->video = null;
                $slider->save();
                if ($slider->image) {
                    return redirect()->back()->with('success', 'ویدیو با موفقیت حذف شد');
                } else {
                    return redirect()->back()->with('error', 'اسلایدر نمیتواند بدون عکس و ویدیو باشد.');
                }
            } else {
                return redirect()->back()->with('error', 'ویدیویی برای حذف وجود ندارد.');
            }
        } else {
            return redirect()->back()->with('error', 'نوع درخواست نامعتبر است.');
        }
    }
}
