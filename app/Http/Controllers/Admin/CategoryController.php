<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $categories = Category::latest()->get();
            return response()->json(['data' => $categories]);
        }
        $categories = Category::latest()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'نام رسته الزامی است.',
        ]);

        Category::create(['name' => $request->name]);
        return response()->json(['success' => 'رسته با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update($id, Request $request)
    {
        $category = Category::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'رسته با موفقیت ویرایش شد.');
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['success' => 'رسته با موفقیت حذف شد.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Category::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }
}
