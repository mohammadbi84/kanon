<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cluster;
use App\Models\Field;
use App\Models\Profession;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $clusterId = $request->query('cluster_id'); // اگر از صفحه خوشه‌ها اومده
        if ($clusterId and !Cluster::find($clusterId)) {
            abort('404');
        }
        $category_id = $request->query('category_id'); // اگر از صفحه خوشه‌ها اومده
        if ($category_id and !Category::find($category_id)) {
            abort('404');
        }

        $clusters = null;
        $fields = null;

        if ($clusterId) {
            // حالت فیلتر بر اساس خوشه
            $fields = Field::with('cluster', 'cluster.category', 'professions')
                ->where('cluster_id', $clusterId)
                ->join('clusters', 'fields.cluster_id', '=', 'clusters.id')
                ->join('categories', 'clusters.category_id', '=', 'categories.id')
                ->orderBy('categories.name')  // اول: رسته
                ->orderBy('clusters.name')    // دوم: خوشه
                ->orderBy('fields.name')      // سوم: نام رشته
                ->select('fields.*')
                ->get();
        } elseif ($category_id) {
            // حالت فیلتر بر اساس رسته
            $clusters = Cluster::active()->get();

            $fields = Field::with('professions', 'cluster', 'cluster.category')
                ->join('clusters', 'fields.cluster_id', '=', 'clusters.id')
                ->join('categories', 'clusters.category_id', '=', 'categories.id')
                ->where('categories.id', $category_id)
                ->orderBy('categories.name')  // اول: رسته
                ->orderBy('clusters.name')    // دوم: خوشه
                ->orderBy('fields.name')      // سوم: نام رشته
                ->select('fields.*')
                ->get();
        } else {
            // حالت بدون فیلتر (همه موارد)
            $clusters = Cluster::active()->get();

            $fields = Field::with('cluster', 'cluster.category', 'professions')
                ->join('clusters', 'fields.cluster_id', '=', 'clusters.id')
                ->join('categories', 'clusters.category_id', '=', 'categories.id')
                ->orderBy('categories.name')  // اول: رسته
                ->orderBy('clusters.name')    // دوم: خوشه
                ->orderBy('fields.name')      // سوم: نام رشته
                ->select('fields.*')
                ->get();
        }
        if (request()->ajax()) {
            return response()->json(['data' => $fields, 'clusters' => $clusters]);
        }
        $clusters = Cluster::with('category')->active()->get();

        $cluster = [];
        $categoryCount = 1;
        if ($clusterId) {
            $cluster = Cluster::find($clusterId);
            $categoryCount = Category::whereHas('clusters')->count();
        }
        $clusterCount = 1;
        if ($category_id) {
            $clusterCount = Cluster::where('category_id', $category_id)
                ->whereHas('fields')  // فقط خوشه‌هایی که رشته دارند
                ->count();
        } else {
            $clusterCount = Cluster::whereHas('fields')->count();
        }

        $professionCount = 0;
        foreach ($fields as $key => $field) {
            $professionCount += $field->professions()->count();
        }

        return view('admin.fields.index', compact('clusters', 'cluster', 'professionCount', 'clusterCount', 'categoryCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cluster_id' => 'required|exists:clusters,id',
        ], [
            'name.required' => 'نام خوشه الزامی است.',
            'cluster_id|required' => 'انتخاب خوشه الزامی است.',
            'cluster_id|exists' => 'خوشه انتخابی نامعتبر است.',
        ]);

        if (Field::where('cluster_id', $request->cluster_id)->where('name', $request->name)->first()) {
            return response()->json(['success' => false, 'message' => 'رشته با این نام و رسته وجود دارد.']);
        }

        Field::create($request->only('name', 'cluster_id'));
        return response()->json(['success' => false, 'message' => 'رشته با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $field = Field::findOrFail($id);
            return response()->json(['data' => $field]);
        }
        $field = Field::findOrFail($id);
        $clusters = Cluster::get();
        return view('admin.fields.edit', compact('field', 'clusters'));
    }

    public function update(Request $request)
    {
        $field = Field::findOrFail($request->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'cluster_id' => 'required|exists:clusters,id',
        ], [
            'name.required' => 'نام خوشه الزامی است.',
            'cluster_id|required' => 'انتخاب خوشه الزامی است.',
            'cluster_id|exists' => 'خوشه انتخابی نامعتبر است.',
        ]);
        $field->update($request->only('name', 'cluster_id'));
        return response()->json(['success' => true, 'message' => 'رشته با موفقیت ویرایش شد.']);
    }

    public function delete($id)
    {
        $field = Field::findOrFail($id);
        if ($field->professions()->count() == 0) {
            $field->delete();
            return response()->json(['success' => true, 'message' => 'رشته با موفقیت حذف شد.']);
        } else {
            return response()->json(['success' => false, 'message' => 'رشته دارای حرفه یا سند حرفه میباشد.']);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        $fields = Field::whereIn('id', $ids)->get();
        foreach ($fields as $key => $field) {
            if ($field->professions()->count() == 0) {
                $field->delete();
            }
        }
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }

    public function toggle(Field $field)
    {
        $field->update([
            'active' => !$field->active
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

        $fields = Field::whereIn('id', $ids)->get();
        foreach ($fields as $key => $field) {
            $field->update([
                'active' => $request->status,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'وضعیت ها با موفقیت تغییر کرد.'
        ]);
    }
}
