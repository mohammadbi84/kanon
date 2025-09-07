<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Khoshe;
use App\Models\Standard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use DB;
use Illuminate\Support\Facades\Validator;
use PersianNLP\WordSegmenter;


class KhosheController extends Controller
{
    //
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_items', []);

        if (!empty($ids)) {
            Khoshe::whereIn('id', $ids)->delete();
        }

        return redirect()->back()->with('success', 'آیتم‌های انتخاب‌شده با موفقیت حذف شدند.');
    }
    public function list()
    {
        $items=Khoshe::orderBy('id','desc')->get();
        foreach ($items as $item) {
            $item['standard']=Standard::find($item->standard_id)->name;
            $item['group']=Group::where('khoshe_id',$item->id)->count();
        }
        $standards=Standard::orderByRaw("name COLLATE utf8mb4_unicode_ci")->get();
        return view('dashboard.khoshe.list',compact('items','standards'));
    }
    public function addPost(Request $request)
    {
        $data=$request->all();
        $rule=[
            'name' => 'required',
            'type' => 'required',
        ];
        $message=[
            'name.required' => 'نام الزامی میباشد',

        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $segmenter = new WordSegmenter();
        $request->name = $segmenter->segment($request->name);

        if (Khoshe::where('name', $request->name)->exists()) {
            return back()->with('error', 'این نام قبلاً ثبت شده است.');
        }
        $item=new Khoshe();
        $item->name=$request->name;
        $item->standard_id=$request->type;

        DB::beginTransaction();

        try {
            $item->save();
            DB::commit();
            return redirect(route('khoshe.list'))->with('success','ذخیره خوشه ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }

    public function delete($id)
    {

        $item=Khoshe::find($id);
        $group  = Group::where('khoshe_id' ,$id)->first();
        if ($group) {
            return redirect(route('khoshe.list'))->with('error','این خوشه دارای رشته میباشد اول رشته را حذف کنید');
        }
        $name=$item->name;
        $item->delete();
        return redirect(route('khoshe.list'))->with('success','حذف خوشه ' . $name . ' با موفقیت انجام شد');

    }

    public function edit($id)
    {
        $item=Khoshe::find($id);
        $standards=Standard::all();
        return view('dashboard.khoshe.edit',compact('item','standards'));
    }


    public function editPost(Request $request,$id)
    {
        $data=$request->all();
        $rule=[
            'name' => 'required',
            'type' => 'required',
        ];
        $message=[
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item=Khoshe::find($id);
        $item->name=$request->name;
        $item->standard_id=$request->type;
        DB::beginTransaction();

        try {
            $item->save();

            DB::commit();
            return redirect(route('khoshe.list'))->with('success','ویرایش خوشه ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }

}
