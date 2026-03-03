<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcademyController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $academies = Academy::latest()->get();
            return response()->json(['data' => $academies]);
        }
        $academies = Academy::latest()->paginate(20);
        return view('admin.academy.index', compact('academies'));
    }

    public function create()
    {
        return view('admin.academy.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return response()->json(['success' => 'آموزشگاه با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        $academy = Academy::findOrFail($id);
        return view('admin.academy.edit', compact('academy'));
    }

    public function update($id, Request $request)
    {
        $academy = Academy::findOrFail($id);
        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $academy->update($validator->validated());
        return redirect()->route('admin.academy.index')->with('success', 'آموزشگاه با موفقیت ویرایش شد.');
    }

    public function toggle($id)
    {
        Academy::findOrFail($id)->update(['status', 'suspended']);
        return response()->json(['success' => 'آموزشگاه با موفقیت حذف شد.']);
    }

    public function bulkToggle(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Academy::whereIn('id', $ids)->update(['status', 'suspended']);
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }
}
