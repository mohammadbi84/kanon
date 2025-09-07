<?php

namespace App\Http\Controllers;

use App\Models\Organ;
use Illuminate\Http\Request;
use Validator;
use DB;


class SenfController extends Controller
{
    //
    public function list()
    {
        $senfs=Organ::where('type',1)->orderBy('id','desc')->get();
        return view('dashboard.senf.list',compact('senfs'));
    }

    public function add()
    {
        return view('dashboard.senf.add');
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

$senf=new Organ();
        $senf->name=$request->name;
        $senf->type=1;
        DB::beginTransaction();

        try {
            $senf->save();

            DB::commit();
            return redirect(route('senf.list'))->with('success','ذخیره صنف ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }

    public function delete($id)
    {
        $senf=Organ::find($id);
        $name=$senf->name;
        $senf->delete();
        return redirect(route('senf.list'))->with('success','حذف صنف ' . $name . ' با موفقیت انجام شد');

    }

    public function edit($id)
    {
        $senf=Organ::find($id);
        return view('dashboard.senf.edit',compact('senf'));
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

        $senf=Organ::find($id);
        $senf->name=$request->name;
        $senf->type=1;
        DB::beginTransaction();

        try {
            $senf->save();

            DB::commit();
            return redirect(route('senf.list'))->with('success','ویرایش صنف ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }

}
