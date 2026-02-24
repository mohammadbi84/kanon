<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $bookmarks = Bookmark::latest()->get();
            return response()->json(['data' => $bookmarks]);
        }
        $bookmarks = Bookmark::latest()->paginate(20);
        return view('admin.bookmark.index', compact('bookmarks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required',
            'sort' => 'nullable',
            'active' => 'nullable',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'duration' => 'required',
            'height' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $sort = Bookmark::count() + 1;

        $data = $validator->validated();

        $data['sort'] = $sort;

        Bookmark::create($validator->validated());
        return response()->json(['success' => 'صفحه با موفقیت اضافه شد.']);
    }

    public function edit($id)
    {
        $bookmark = Bookmark::findOrFail($id);
        return view('admin.bookmark.edit', compact('bookmark'));
    }

    public function update($id, Request $request)
    {
        $bookmark = Bookmark::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required',
            'sort' => 'required|numeric',
            'active' => 'required',
            'start_at' => 'nullable',
            'end_at' => 'nullable',
            'duration' => 'required',
            'height' => 'nullable',
        ]);
        $bookmark->update($request->all());
        return redirect()->route('admin.bookmark.index')->with('success', 'صفحه با موفقیت ویرایش شد.');
    }

    public function delete($id)
    {
        Bookmark::findOrFail($id)->delete();
        return response()->json(['success' => 'صفحه با موفقیت حذف شد.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Bookmark::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'رکوردها با موفقیت حذف شدند.']);
    }
}
