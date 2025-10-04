<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jobtype;
use Illuminate\Http\Request;

class JobtypeController extends Controller
{
    public function index()
    {
        if (Request()->ajax()) {
            $jobtypes = Jobtype::latest()->get();
            return response()->json(['data' => $jobtypes]);
        }
        $jobtypes = Jobtype::latest()->paginate(20);
        return view('admin.jobtypes.index', compact('jobtypes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'نام نوع شغل الزامی است.',
            'name.string' => 'نام نوع شغل باید به صورت متنی باشد',
        ]);
        $item = new Jobtype();
        $item->name = $request->name;
        $item->save();
        return response()->json(['success' => 'نوع شغل با موفقیت اضافه شد.']);
    }
    public function edit($id)
    {
        $job = Jobtype::findOrFail($id);
        return view('admin.jobtypes.edit', compact('job'));
    }
    public function update($id ,Request $request)
    {
        $job = Jobtype::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'نام نوع شغل الزامی است.',
            'name.string' => 'نام نوع شغل باید به صورت متنی باشد',
        ]);
        $job->name = $request->name;
        $job->save();
        return redirect(route('admin.jobtype.index'))->with('success','نوع شغل با موفقیت ویرایش شد.');
    }
    public function delete($id)
    {
        $jobtype = Jobtype::findOrFail($id);
        $jobtype->delete();
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

        JobType::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'رکوردها با موفقیت حذف شدند.'
        ]);
    }
}
