<?php

namespace App\Http\Controllers;

use App\Models\Off;
use App\Models\Organ;
use Illuminate\Http\Request;
use DB;
use Validator;

class OffController extends Controller
{
    //

    public function list()
    {
        $offs=Off::orderBy('id','desc')->get();
        foreach ($offs as $off) {
            if($off->type==1)
                $off['type_name']='%';
            else
                $off['type_name']=' تومان';

        }
        return view('dashboard.off.list',compact('offs'));
    }



    public function addPost(Request $request)
    {
        $data=$request->all();
        $rule=[
            'name' => 'required',
            'value' => 'required|numeric',
            'type' => 'required|numeric',
        ];
        $message=[
            'name.required' => 'نام الزامی میباشد',
            'value.required' => 'مقدار الزامی میباشد',
            'value.numeric' => 'مقدار عددی میباشد',
            'type.required' => 'نوع الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $off=new Off();
        $off->name=$request->name;
        $off->type=$request->type;
        $off->value=$request->value;

        DB::beginTransaction();

        try {
            $off->save();
            DB::commit();
            return redirect(route('off.list'))->with('success','ذخیره تخفیف ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }

    public function delete($id)
    {
        $off=Off::find($id);
        $name=$off->name;
        $off->delete();
        return redirect(route('off.list'))->with('success','حذف تخفیف ' . $name . ' با موفقیت انجام شد');

    }

    public function edit($id)
    {
        $off=Off::find($id);
        return view('dashboard.off.edit',compact('off'));
    }


    public function editPost(Request $request,$id)
    {
        $data=$request->all();
        $rule=[
            'name' => 'required',
            'value' => 'required|numeric',
            'type' => 'required|numeric',
        ];
        $message=[
            'name.required' => 'نام الزامی میباشد',
            'value.required' => 'مقدار الزامی میباشد',
            'value.numeric' => 'مقدار عددی میباشد',
            'type.required' => 'نوع الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $off=Off::find($id);
        $off->name=$request->name;
        $off->type=$request->type;
        $off->value=$request->value;
        DB::beginTransaction();

        try {
            $off->save();

            DB::commit();
            return redirect(route('off.list'))->with('success','ویرایش تخفیف ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }

}
