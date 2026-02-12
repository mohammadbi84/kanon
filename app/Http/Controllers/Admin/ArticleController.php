<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $articles = Article::latest()->get();
            return response()->json(['data' => $articles]);
        }
        $articles = Article::latest()->paginate(20);
        return view('admin.article.index', compact('articles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required',
        ], [
            'title.required' => 'نام صفحه الزامی است.',
            'body.required' => 'محتوای صفحه الزامی است.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Article::create($validator->validated());
        return response()->json(['success' => 'صفحه با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.article.edit', compact('article'));
    }

    public function update($id, Request $request)
    {
        $article = Article::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
        ], [
            'title.required' => 'نام صفحه الزامی است.',
            'body.required' => 'محتوای صفحه الزامی است.',
        ]);
        $article->update($request->all());
        return redirect()->route('admin.articles.index')->with('success', 'صفحه با موفقیت ویرایش شد.');
    }

    public function delete($id)
    {
        Article::findOrFail($id)->delete();
        return response()->json(['success' => 'صفحه با موفقیت حذف شد.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Article::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }
}
