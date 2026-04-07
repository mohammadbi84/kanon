<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BenefitController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $benefits = Benefit::latest()->get();
            return response()->json(['data' => $benefits]);
        }
        return view('admin.benefit.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'text' => 'required',
        ], [
            'title.required' => 'عنوان الزامی است.',
            'text.required' => 'محتوا الزامی است.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Benefit::create($validator->validated());
        return response()->json(['success' => true, 'message' => 'محتوا با موفقیت ذخیره شد.']);
    }

    public function edit($id)
    {
        $benefit = Benefit::findOrFail($id);
        return view('admin.benefit.edit', compact('benefit'));
    }

    public function update($id, Request $request)
    {
        $benefit = Benefit::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'text' => 'required',
        ], [
            'title.required' => 'عنوان الزامی است.',
            'text.required' => 'محتوا الزامی است.',
        ]);
        $benefit->update($request->all());
        return response()->json(['success' => true, 'message' => 'محتوا با موفقیت ویرایش شد.']);
    }

    public function delete($id)
    {
        Benefit::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'محتوا با موفقیت حذف شد.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Benefit::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }
}
