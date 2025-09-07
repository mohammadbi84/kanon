<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $data=$request->all();
        $rule=[
            'name' => 'required',
            'family'=> 'required'
        ];
        $message=[
            'name.required' => 'نام الزامی میباشد',
            'family.required' => 'فامیل الزامی میباشد',
        ];
//        https://github.com/sadegh19b/laravel-persian-validation
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();

        try {


            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('success','okkkkkkkk');
            // something went wrong
        }
    }
}
