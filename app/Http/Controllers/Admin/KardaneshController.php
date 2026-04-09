<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kardanesh;
use Illuminate\Http\Request;

class KardaneshController extends Controller
{
    public function index()
    {
        if (Request()->ajax()) {
            $kardaneshs = Kardanesh::orderBy('name','asc')->get();
            return response()->json(['data' => $kardaneshs]);
        }
        $kardaneshs_count = Kardanesh::count();
        return view('admin.kardaneshs.index', compact('kardaneshs_count'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'نام کاردانش الزامی است.',
            'name.string' => 'نام کاردانش باید به صورت متنی باشد',
        ]);
        if (Kardanesh::where('name', $request->name)->first()) {
            return response()->json(['success' => false, 'message' => 'حداقل تحصیلات با این نام وجود دارد.']);
        }
        $item = new Kardanesh();
        $item->name = $request->name;
        $item->save();
        return response()->json(['success' => true, 'message' => 'کاردانش با موفقیت اضافه شد.']);
    }
    public function edit($id)
    {
        $kardanesh = Kardanesh::findOrFail($id);
        if (Request()->ajax()) {
            return response()->json(['data' => $kardanesh]);
        }
        return view('admin.kardaneshs.edit', compact('kardanesh'));
    }
    public function update(Request $request)
    {
        $job = Kardanesh::findOrFail($request->id);
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'نام نوع کاردانش الزامی است.',
            'name.string' => 'نام نوع کاردانش باید به صورت متنی باشد',
        ]);
        $job->name = $request->name;
        $job->save();
        return response()->json(['success' => true, 'message' => 'کاردانش با موفقیت ویرایش شد.']);
    }
    public function delete($id)
    {
        $kardaneshs = Kardanesh::findOrFail($id);
        $kardaneshs->delete();
        return response()->json(['success' => true, 'message' => 'کاردانش با موفقیت حذف شد.']);
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

        Kardanesh::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'رکوردها با موفقیت حذف شدند.'
        ]);
    }
}
