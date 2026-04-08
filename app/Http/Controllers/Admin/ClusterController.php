<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cluster;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        if ($categoryId and !Category::find($categoryId)) {
            abort('404');
        }

        if (request()->ajax()) {
            $categories = null;
            if ($categoryId) {
                $clusters = Cluster::with('category', 'fields')
                    ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
                    ->latest()
                    ->get();
            } else {
                $categories = Category::active()->get();
                $clusters = Cluster::with('category', 'fields')->latest()->get();
            }
            return response()->json(['data' => $clusters, 'categories' => $categories]);
        }
        $categories = Category::active()->get();
        $category = [];
        if ($categoryId) {
            $category = Category::find($categoryId);
        }
        if ($categoryId) {
            $cluster_count = Cluster::when($categoryId, fn($q) => $q->where('category_id', $categoryId))->count();
        } else {
            $cluster_count = Cluster::count();
        }
        return view('admin.clusters.index', compact('categories', 'category', 'cluster_count'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'نام خوشه الزامی است.',
            'category|required' => 'انتخاب رسته الزامی است.',
            'category|exists' => 'رسته انتخابی نامعتبر است.',
        ]);
        if (Cluster::where('category_id', $request->category_id)->where('name', $request->name)->first()) {
            return response()->json(['success' => false, 'message' => 'خوشه با این نام و رسته وجود دارد.']);
        }

        Cluster::create($request->only('name', 'category_id'));
        return response()->json(['success' => true, 'message' => 'خوشه با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $cluster = Cluster::findOrFail($id);
            return response()->json(['data' => $cluster]);
        }
        $cluster = Cluster::findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.clusters.edit', compact('cluster', 'categories'));
    }

    public function update(Request $request)
    {
        $cluster = Cluster::findOrFail($request->id);
        $request->validate([
            'id' => 'required|exists:clusters,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'نام خوشه الزامی است.',
            'category|required' => 'انتخاب رسته الزامی است.',
            'category|exists' => 'رسته انتخابی نامعتبر است.',
        ]);
        $cluster->update($request->only('name', 'category_id'));
        return response()->json(['success' => true, 'message' => 'خوشه با موفقیت ویرایش شد.']);
    }

    public function delete($id)
    {
        $cluster = Cluster::findOrFail($id);
        if ($cluster->fields()->count() == 0) {
            $cluster->delete();
            return response()->json(['success' => true, 'message' => 'خوشه با موفقیت حذف شد.']);
        } else {
            return response()->json(['success' => false, 'message' => 'خوشه دارای رشته می‌باشد.']);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        $clusters = Cluster::whereIn('id', $ids)->get();
        foreach ($clusters as $key => $cluster) {
            if ($cluster->fields()->count() == 0) {
                $cluster->delete();
            }
        }
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }

    public function toggle(Cluster $cluster)
    {
        $cluster->update([
            'active' => !$cluster->active
        ]);
        return response()->json(['success' => true, 'message' => 'وضعیت با موفقیت تغییر کرد.']);
    }
    public function bulkToggle(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'
            ], 400);
        }

        $clusters = Cluster::whereIn('id', $ids)->get();
        foreach ($clusters as $key => $cluster) {
            $cluster->update([
                'active' => $request->status,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'وضعیت ها با موفقیت تغییر کرد.'
        ]);
    }
}
