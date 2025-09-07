<?php

namespace App\Http\Controllers;

use App\Models\RegisterAlert;
use Illuminate\Http\Request;

class RegisterAlertController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $alert = RegisterAlert::firstOrCreate([], ['title' => 'توجه!','text' => 'تست']);
        return view('dashboard.register-alert.edit', compact('alert'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $message = RegisterAlert::first();
        $message->title = $request->title;
        $message->text = $request->text;
        $message->color = $request->color;
        $message->status = $request->status;
        $message->save();
        return redirect()->back()->with('success', 'پیام قبل ثبت نام با موفقیت ویرایش شد');
    }
}
