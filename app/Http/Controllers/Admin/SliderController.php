<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $sliders = Slider::latest()->get();
            return response()->json(['data' => $sliders]);
        }
        $sliders = Slider::latest()->paginate(20);
        return view('admin.slider.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required',
            'type' => 'nullable',
            'video' => 'nullable',
            'show_time' => 'nullable',
            'order' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $order = Slider::count() + 1;

        $data = $validator->validated();

        $data['order'] = $order;

        Slider::create($validator->validated());
        return response()->json(['success' => 'اسلایدشو با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.bookmark.edit', compact('bookmark'));
    }

    public function update($id, Request $request)
    {
        $slider = Slider::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required',
            'type' => 'nullable',
            'video' => 'nullable',
            'show_time' => 'nullable',
            'order' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $slider->update($validator->validated());
        return redirect()->route('admin.slider.index')->with('success', 'اسلایدشو با موفقیت ویرایش شد.');
    }

    public function delete($id)
    {
        Slider::findOrFail($id)->delete();
        return response()->json(['success' => 'اسلایدشو با موفقیت حذف شد.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Slider::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }
}
