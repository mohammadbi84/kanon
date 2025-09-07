<?php

namespace App\Http\Controllers;

use App\Models\RegisterMessage;
use Illuminate\Http\Request;

class RegisterMessageController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $message = RegisterMessage::firstOrCreate([], ['text' => 'تست']);
        return view('dashboard.register-message.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $message = RegisterMessage::first();
        $message->text = $request->text;
        $message->status = $request->status;
        $message->save();
        return redirect()->back()->with('success', 'پیام قبل ثبت نام با موفقیت ویرایش شد');
    }
}
