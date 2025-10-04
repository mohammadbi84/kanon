<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kardanesh;
use Illuminate\Http\Request;

class KardaneshController extends Controller
{
    public function index()
    {
        $kardaneshs =Kardanesh::latest()->paginate(20);
        if (Request()->ajax()) {
            $kardaneshs =Kardanesh::latest()->get();
            return response()->json(['data' => $kardaneshs]);
        }
        return view('admin.kardaneshs.index', compact('kardaneshs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'نام نوع شغل الزامی است.',
            'name.string' => 'نام نوع شغل باید به صورت متنی باشد',
        ]);
        $item = new Kardanesh();
        $item->name = $request->name;
        $item->save();
        return response()->json(['success' => 'نوع شغل با موفقیت اضافه شد.']);
    }
    public function edit($id)
    {
        $kardanesh =Kardanesh::findOrFail($id);
        return view('admin.kardaneshs.edit', compact('kardanesh'));
    }
    public function update($id ,Request $request)
    {
        $job =Kardanesh::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'نام نوع کاردانش الزامی است.',
            'name.string' => 'نام نوع کاردانش باید به صورت متنی باشد',
        ]);
        $job->name = $request->name;
        $job->save();
        return redirect(route('admin.kardanesh.index'))->with('success','نوع کاردانش با موفقیت ویرایش شد.');
    }
    public function delete($id)
    {
        $kardaneshs =Kardanesh::findOrFail($id);
        $kardaneshs->delete();
        return response()->json(['success' => 'نوع شغل با موفقیت حذف شد.']);
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
