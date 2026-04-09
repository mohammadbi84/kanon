<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MinEducation;
use Illuminate\Http\Request;

class MinEducationController extends Controller
{
    public function index()
    {
        if (Request()->ajax()) {
            $educations = MinEducation::orderBy('name','asc')->get();
            return response()->json(['data' => $educations]);
        }
        $educations_count = MinEducation::count();
        return view('admin.educations.index', compact('educations_count'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'نام حداقل تحصیلات الزامی است.',
            'name.string' => 'نام حداقل تحصیلات باید به صورت متنی باشد',
        ]);
        if (MinEducation::where('name', $request->name)->first()) {
            return response()->json(['success' => false, 'message' => 'حداقل تحصیلات با این نام وجود دارد.']);
        }
        $item = new MinEducation();
        $item->name = $request->name;
        $item->save();
        return response()->json(['success' => true, 'message' => 'حداقل تحصیلات با موفقیت اضافه شد.']);
    }
    public function edit($id)
    {
        $minEducation = MinEducation::findOrFail($id);
        if (Request()->ajax()) {
            return response()->json(['data' => $minEducation]);
        }
        return view('admin.educations.edit', compact('minEducation'));
    }
    public function update(Request $request)
    {
        $minEducation = minEducation::findOrFail($request->id);
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'نام حداقل تحصیلات الزامی است.',
            'name.string' => 'نام حداقل تحصیلات باید به صورت متنی باشد',
        ]);
        $minEducation->name = $request->name;
        $minEducation->save();
        return response()->json(['success' => true, 'message' => 'حداقل تحصیلات با موفقیت ویرایش شد.']);
    }
    public function delete($id)
    {
        $minEducations = MinEducation::findOrFail($id);
        $minEducations->delete();
        return response()->json(['success' => true, 'message' => 'حداقل تحصیلات با موفقیت حذف شد.']);
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'
            ], 400);
        }

        MinEducation::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'رکوردها با موفقیت حذف شدند.'
        ]);
    }
}
