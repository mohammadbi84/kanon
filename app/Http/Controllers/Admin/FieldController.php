<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $clusterId = $request->query('cluster_id'); // اگر از صفحه خوشه‌ها اومده
        if ($clusterId and !Cluster::find($clusterId)) {
            abort('404');
        }

        if (request()->ajax()) {
            $clusters = null;
            if ($clusterId) {
                $fields = Field::with('cluster', 'professions')
                    ->when($clusterId, fn($q) => $q->where('cluster_id', $clusterId))
                    ->latest()
                    ->get();
            } else {
                $clusters = Cluster::all();
                $fields = Field::with('cluster', 'professions')->latest()->get();
            }
            return response()->json(['data' => $fields, 'clusters' => $clusters]);
        }
        $clusters = Cluster::with('category')->get();

        $cluster = [];
        if ($clusterId) {
            $cluster = Cluster::find($clusterId);
        }
        if ($clusterId) {
            $fields_count = Field::when($clusterId, fn($q) => $q->where('cluster_id', $clusterId))->count();
        } else {
            $fields_count = Field::count();
        }
        return view('admin.fields.index', compact('clusters', 'cluster', 'fields_count'));
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
}
