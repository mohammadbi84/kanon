<?php

namespace App\Http\Controllers;

use App\Models\popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function edit()
    {
        $popup = popup::firstOrCreate([], [
            'title' => 'سورپرایز ویژه!',
            'text'=>'یک تجربه فوق‌العاده در انتظار شماست! همین حالا پیشنهادات ویژه ما را بررسی کنید',
        ]);
        return view('dashboard.popup.edit', compact('popup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $popup = popup::first();
        $popup->title = $request->title;
        $popup->text = $request->text;
        $popup->status = $request->status;
        $popup->save();
        return redirect()->back()->with('success', 'پیام قبل ثبت نام با موفقیت ویرایش شد');
    }
}
