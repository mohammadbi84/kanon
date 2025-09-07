<?php

namespace App\Http\Controllers;

use App\Models\Khoshe;
use App\Models\Off;
use App\Models\Standard;
use Illuminate\Http\Request;
use Validator;
use DB;
use PersianNLP\WordSegmenter;

class StandardController extends Controller
{
    //

    public function list()
    {
        $items = Standard::orderBy('id', 'desc')->get();
        foreach ($items as $key => $item) {
            $item['qty'] = Khoshe::where('standard_id',$item->id)->count();
        }

        return view('dashboard.standards.list', compact('items'));
    }
    



    public function addPost(Request $request)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $segmenter = new WordSegmenter();
        $request->name = $segmenter->segment($request->name);
        
        if (Standard::where('name', $request->name)->exists()) {
            return back()->with('error', 'این نام قبلاً ثبت شده است.');
        }
        $item = new Standard();
        $item->name = $request->name;

        DB::beginTransaction();

        try {
            $item->save();
            DB::commit();
            return redirect(route('standard.list'))->with('success', 'ذخیره رسته ' . $request->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }

    public function delete($id)
    {
        $item = Standard::find($id);
        $khoshe = Khoshe::where('standard_id', $id)->first();
        if ($khoshe) {
            return redirect(route('standard.list'))->with('error', 'این رسته دارای خوشه میباشد اول خوشه را حذف کنید');
        }
        $name = $item->name;
        $item->delete();
        return redirect(route('standard.list'))->with('success', 'حذف رسته ' . $name . ' با موفقیت انجام شد');

    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_items', []);

        if (!empty($ids)) {
            Standard::whereIn('id', $ids)->delete();

        }

        return redirect()->back()->with('success', 'آیتم‌های انتخاب‌شده با موفقیت حذف شدند.');
    }

    public function edit($id)
    {
        $item = Standard::find($id);
        return view('dashboard.standards.edit', compact('item'));
    }


    public function editPost(Request $request, $id)
    {
        $data = $request->all();
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = Standard::find($id);
        $item->name = $request->name;
        DB::beginTransaction();

        try {
            $item->save();

            DB::commit();
            return redirect(route('standard.list'))->with('success', 'ویرایش رسته ' . $request->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }

}
