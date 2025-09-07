<?php

namespace App\Http\Controllers;

use App\Models\Jobtype;
use App\Models\Kardanesh;
use Illuminate\Http\Request;
use Validator;
use DB;

class KardaneshController extends Controller
{
    //

    public function list()
    {
        $items=Kardanesh::orderBy('id','desc')->get();


        return view('dashboard.kardanesh.list',compact('items'));
    }



    public function addPost(Request $request)
    {
        $data=$request->all();
        $rule=[
            'name' => 'required',
        ];
        $message=[
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item=new Kardanesh();
        $item->name=$request->name;

        DB::beginTransaction();

        try {
            $item->save();
            DB::commit();
            return redirect(route('kardanesh.list'))->with('success','ذخیره نوع ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }

    public function delete($id)
    {
        $item=Kardanesh::find($id);
        $name=$item->name;
        $item->delete();
        return redirect(route('kardanesh.list'))->with('success','حذف نوع ' . $name . ' با موفقیت انجام شد');

    }

    public function edit($id)
    {
        $item=Kardanesh::find($id);
        return view('dashboard.kardanesh.edit',compact('item'));
    }


    public function editPost(Request $request,$id)
    {
        $data=$request->all();
        $rule=[
            'name' => 'required',
        ];
        $message=[
            'name.required' => 'نام الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item=Kardanesh::find($id);
        $item->name=$request->name;
        DB::beginTransaction();

        try {
            $item->save();

            DB::commit();
            return redirect(route('kardanesh.list'))->with('success','ویرایش نوع ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }
}
