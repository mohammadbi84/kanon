<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // نمایش لیست تیتر اصلی و زیرمجموعه‌ها
    public function index()
    {
        // گرفتن تنها یک تیتر اصلی
        $title = Content::whereNull('parent_id')->first();
        return view('dashboard.contents.index', compact('title'));
    }

    // فرم ایجاد تیتر اصلی
    public function createTitle()
    {
        // چک می‌کنیم که آیا تیتر اصلی قبلاً وجود دارد یا نه
        $title = Content::whereNull('parent_id')->first();
        if ($title) {
            return redirect()->route('contents.index')->with('error', 'تیتر اصلی قبلاً اضافه شده است.');
        }

        return view('dashboard.contents.createTitle');
    }

    // ذخیره تیتر اصلی
    public function storeTitle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        
        $check = Content::where('parent_id', null)->first();
        
        if ($check) {
            // به‌روزرسانی تیتر اصلی
            $check->title = $request->title;
            $check->content = [];
            $check->parent_id = null;
            $check->save();
        } else {
            // ایجاد یک رکورد جدید به‌عنوان تیتر اصلی
            $check = Content::create([
                'title' => $request->title,
                'content' => [],  
                'parent_id' => null, 
            ]);
        }
        
        // به‌روزرسانی تمام رکوردهایی که parent_id نال ندارند
        Content::whereNotNull('parent_id')->update(['parent_id' => $check->id]);
        
        // ذخیره تیتر اصلی در دیتابیس


        return redirect()->route('contents.index')->with('success', 'تیتر اصلی اضافه شد.');
    }

    // فرم ایجاد زیرمجموعه
    public function create()
    {
        return view('dashboard.contents.create');
    }

    // ذخیره زیرمجموعه
    public function store(Request $request)
    {
        $request->validate([
            'content_title' => 'required|string|max:255', // عنوان زیرمجموعه
            'content_text' => 'required|string', // متن زیرمجموعه
        ]);

        // دریافت تیتر اصلی (اگر قبلاً وجود داشته باشد)
        $title = Content::whereNull('parent_id')->first();

        // ذخیره زیرمجموعه به عنوان فرزند تیتر اصلی
        Content::create([
            'title' => $title->title, // تیتر اصلی
            'content' => [
                'title' => $request->content_title, // عنوان زیرمجموعه
                'text' => $request->content_text,   // متن زیرمجموعه
            ],
            'parent_id' => $title->id, // ارتباط با تیتر اصلی
        ]);

        return redirect()->route('contents.index')->with('success', 'زیرمجموعه اضافه شد.');
    }

    // فرم ویرایش زیرمجموعه
    public function edit($id)
    {
        $content = Content::findOrFail($id);
        return view('dashboard.contents.edit', compact('content'));
    }

    // بروزرسانی زیرمجموعه
    public function update(Request $request, $id)
    {
        $request->validate([
            'content_title' => 'required|string|max:255', // عنوان زیرمجموعه
            'content_text' => 'required|string', // متن زیرمجموعه
        ]);

        $content = Content::findOrFail($id);
        $content->update([
            'content' => [
                'title' => $request->content_title, // عنوان جدید زیرمجموعه
                'text' => $request->content_text,   // متن جدید زیرمجموعه
            ],
        ]);

        return redirect()->route('contents.index')->with('success', 'زیرمجموعه بروزرسانی شد.');
    }

    // حذف زیرمجموعه
    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        return redirect()->route('contents.index')->with('success', 'زیرمجموعه حذف شد.');
    }

    // حذف تیتر اصلی
    public function destroyTitle()
    {
        $titles = Content::where('parent_id',null)->first();
        $titles->delete();


        return redirect()->route('contents.index')->with('success', 'تیتر اصلی حذف شد.');
    }
}
