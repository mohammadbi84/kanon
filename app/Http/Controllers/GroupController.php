<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Herfe;
use App\Models\Khoshe;
use App\Models\SanadHerfe;
use App\Models\Standard;
use Illuminate\Http\Request;
use Validator;
use DB;
use PersianNLP\WordSegmenter;

class GroupController extends Controller
{
    //


    public function list($id)
    {
        $khoshe = Khoshe::find($id);
        $raste = Standard::where('id', $khoshe->standard_id)->first();
        $items = Group::where('khoshe_id', $id)->orderBy('id', 'desc')->get();

        return view('dashboard.group.list', compact('items', 'khoshe', 'raste', 'id'));
    }


    public function list1()
    {
        $items = Group::get();
        $khoshes = Khoshe::orderByRaw("name COLLATE utf8mb4_unicode_ci")->get();

        return view('dashboard.group.list1', compact('items', 'khoshes'));
    }





    public function addPost(Request $request, $id)
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
        
        if (Group::where('name', $request->name)->exists()) {
            return back()->with('error', 'این نام قبلاً ثبت شده است.');
        }
        $item = new Group();
        $item->name = $request->name;
        $item->khoshe_id = $id;

        DB::beginTransaction();

        try {
            $item->save();
            DB::commit();
            return redirect(route('group.list', ['id' => $id]))->with('success', 'ذخیره رشته ' . $request->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }
    public function addPost1(Request $request)
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
        $item = new Group();
        $item->name = $request->name;
        $item->khoshe_id = $request->khoshe;

        DB::beginTransaction();

        try {
            $item->save();
            DB::commit();
            return redirect(route('group.list1'))->with('success', 'ذخیره رشته ' . $request->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }

    public function delete($id)
    {
        $item = Group::find($id);
        $get = Herfe::where('group_id', $id)->first();
        if ($get) {
            return redirect()->back()->with('error', 'این رشته دارای حرفه میباشد اول حرفه را حذف کنید');
        }
        $get1 = SanadHerfe::where('group_id', $id)->first();
        if ($get1) {
            return redirect()->back()->with('error', 'این رشته دارای سند حرفه میباشد اول سند حرفه را حذف کنید');
        }

        $item->delete();
        return redirect()->back()->with('success', 'حذف گروه  با موفقیت انجام شد');

    }

    public function edit($id)
    {
        $item = Group::find($id);
        return view('dashboard.group.edit', compact('item'));
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

        $item = Group::find($id);
        $item->name = $request->name;
        DB::beginTransaction();

        try {
            $item->save();

            DB::commit();
            return redirect(route('group.list', ['id' => $item->khoshe_id]))->with('success', 'ویرایش گروه ' . $request->name . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
            // something went wrong
        }
    }
}
