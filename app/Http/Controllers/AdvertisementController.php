<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Validator;
use DB;

class AdvertisementController extends Controller
{
    //

    public function list()
    {
        $khabars = Advertisement::all();
        return view('dashboard.Advertisement.list', compact('khabars',));
    }

    public function add()
    {
        return view('dashboard.Advertisement.add');
    }

    public function addPost(Request $request)
    {
        $data = $request->all();
        $rule = [
            'title' => 'required',
            'image' => 'required',
            'text' => 'required',
            'price' => 'required|numeric',
        ];
        $message = [
            'title.required' => 'نام الزامی میباشد',
            'image.required' => 'عکس الزامی میباشد',
            'text.required' => 'متن الزامی میباشد',
            'price.required' => 'مبلغ الزامی میباشد',
            'price.numeric' => 'مبلغ از نوع عدد میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $Khabar = new Advertisement();
        $Khabar->title = $request->title;
        $Khabar->text = $request->text;
        $Khabar->status = $request->Advertisement;
        $Khabar->price = $request->price;

        // $file = $request->file('image');
        // $pathName = time(). rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        // $file->move('file/Advertisement/images', $pathName);
        // $Khabar->image = 'file/Advertisement/images/'.$pathName;
        $Khabar->image = $request->image;


        DB::beginTransaction();

        try {
            $Khabar->save();
            DB::commit();
            return redirect(route('Advertisement.list'))->with('success', 'ذخیره آگهی ' . $request->title . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی')->withInput();
            // something went wrong
        }
    }

    public function delete($id)
    {
        $Khabar = Advertisement::find($id);
        $name = $Khabar->title;
        $Khabar->delete();
        return redirect()->back()->with('success', 'حذف آگهی ' . $name . ' با موفقیت انجام شد');
    }

    public function edit($id)
    {
        $khabar = Advertisement::find($id);
        return view('dashboard.Advertisement.edit', compact('khabar'));
    }
    public function editpost(Request $request, $id)
    {
        $data = $request->all();
        $rule = [
            'title' => 'required',
            'image' => 'required',
            'text' => 'required',
            'price' => 'required|numeric',
        ];
        $message = [
            'title.required' => 'نام الزامی میباشد',
            'image.required' => 'عکس الزامی میباشد',
            'text.required' => 'متن الزامی میباشد',
            'price.required' => 'مبلغ الزامی میباشد',
            'price.numeric' => 'مبلغ از نوع عدد میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $khabar = Advertisement::find($id);
        $khabar->title = $request->title;
        $khabar->text = $request->text;
        $khabar->status = $request->Advertisement;
        $khabar->price = $request->price;
        // if (isset($request->image)) {
        //     $file = $request->file('image');
        //     $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        //     $file->move('file/Advertisement/images', $pathName);
        //     $khabar->image = 'file/images/' . $pathName;
        // }
        $khabar->image = $request->image;

        DB::beginTransaction();

        try {

            $khabar->save();
            DB::commit();
            return redirect(route('Advertisement.list'))->with('success', 'ویرایش آگهی ' . $khabar->title . ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی')->withInput();
            // something went wrong
        }
    }
}
