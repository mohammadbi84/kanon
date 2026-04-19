<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cluster;
use App\Models\Field;
use App\Models\Profession;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $categories = Category::with(['clusters.fields.professions'])->latest()->get();

            foreach ($categories as $category) {
                $fieldsCount = 0;
                $professionsCount = 0;

                foreach ($category->clusters as $cluster) {
                    $fieldsCount += $cluster->fields->count();

                    foreach ($cluster->fields as $field) {
                        $professionsCount += $field->professions->count();
                    }
                }

                $category['fieldsCount'] = $fieldsCount;
                $category['professionsCount'] = $professionsCount;
            }
            return response()->json(['data' => $categories]);
        }
        return view('admin.categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'نام رسته الزامی است.',
        ]);

        if (Category::where('name', $request->name)->first()) {
            return response()->json(['success' => false, 'message' => 'رسته با این نام وجود دارد.']);
        }

        Category::create(['name' => $request->name]);
        return response()->json(['success' => true, 'message' => 'رسته با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $category = Category::findOrFail($id);
            return response()->json(['data' => $category]);
        }
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->name]);
        return response()->json(['success' => true, 'message' => 'رسته با موفقیت ویرایش شد.']);
    }

    public function delete($id)
    {
        $cat = Category::findOrFail($id);
        if ($cat->clusters()->count() == 0) {
            $cat->delete();
            return response()->json(['success' => true, 'message' => 'رسته با موفقیت حذف شد.']);
        } else {
            return response()->json(['success' => false, 'message' => 'رسته دارای خوشه میباشد.']);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        $categories = Category::whereIn('id', $ids)->get();
        foreach ($categories as $key => $category) {
            if ($category->clusters()->count() == 0) {
                $category->delete();
            }
        }
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }

    public function toggle(Category $category)
    {
        $category->update([
            'active' => !$category->active
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

        $categories = Category::whereIn('id', $ids)->get();
        foreach ($categories as $key => $category) {
            $category->update([
                'active' => $request->status,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'وضعیت ها با موفقیت تغییر کرد.'
        ]);
    }
}
