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
                $fields = Field::with('cluster')
                    ->when($clusterId, fn($q) => $q->where('cluster_id', $clusterId))
                    ->latest()
                    ->get();
            } else {
                $clusters = Cluster::all();
                $fields = Field::with('cluster')->latest()->get();
            }
            return response()->json(['data' => $fields, 'clusters' => $clusters]);
        }
        $fields = Field::latest()->paginate(20);
        $clusters = Cluster::with('category')->get();
        return view('admin.fields.index', compact('fields', 'clusters'));
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

        Field::create($request->only('name', 'cluster_id'));
        return response()->json(['success' => 'رشته با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        $field = Field::findOrFail($id);
        $clusters = Cluster::get();
        return view('admin.fields.edit', compact('field', 'clusters'));
    }

    public function update($id, Request $request)
    {
        $field = Field::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'cluster_id' => 'required|exists:clusters,id',
        ], [
            'name.required' => 'نام خوشه الزامی است.',
            'cluster_id|required' => 'انتخاب خوشه الزامی است.',
            'cluster_id|exists' => 'خوشه انتخابی نامعتبر است.',
        ]);
        $field->update($request->only('name', 'cluster_id'));
        return redirect()->route('admin.fields.index')->with('success', 'رشته با موفقیت ویرایش شد.');
    }

    public function delete($id)
    {
        Field::findOrFail($id)->delete();
        return response()->json(['success' => 'رشته با موفقیت حذف شد.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Field::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }
}
