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
            $categories = Category::with('clusters')->latest()->get();
            return response()->json(['data' => $categories]);
        }
        $categories_count = Category::count();
        return view('admin.categories.index',compact('categories_count'));
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
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update($id, Request $request)
    {
        $category = Category::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->name]);
        return redirect()->route('admin.categories.index')->with('success', 'رسته با موفقیت ویرایش شد.');
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
}
