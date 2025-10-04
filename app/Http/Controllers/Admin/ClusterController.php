<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cluster;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $clusters = Cluster::latest()->get();
            return response()->json(['data' => $clusters]);
        }
        $clusters = Cluster::latest()->paginate(20);
        $categories = Category::all();
        return view('admin.clusters.index', compact('clusters', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ],[
            'name.required'=>'نام خوشه الزامی است.',
            'category|required'=>'انتخاب رسته الزامی است.',
            'category|exists'=>'رسته انتخابی نامعتبر است.',
        ]);

        Cluster::create($request->only('name', 'category_id'));
        return response()->json(['success' => 'خوشه با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        $cluster = Cluster::findOrFail($id);
        $categories = Category::all();
        return view('admin.clusters.edit', compact('cluster', 'categories'));
    }

    public function update($id, Request $request)
    {
        $cluster = Cluster::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ],[
            'name.required'=>'نام خوشه الزامی است.',
            'category|required'=>'انتخاب رسته الزامی است.',
            'category|exists'=>'رسته انتخابی نامعتبر است.',
        ]);
        $cluster->update($request->only('name', 'category_id'));
        return redirect()->route('clusters.index')->with('success', 'خوشه با موفقیت ویرایش شد.');
    }

    public function delete($id)
    {
        Cluster::findOrFail($id)->delete();
        return response()->json(['success' => 'خوشه با موفقیت حذف شد.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Cluster::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }
}
