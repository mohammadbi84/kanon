<?php

namespace App\Http\Controllers;

use App\Models\LoginPageAd;
use App\Models\SpecialAd;
use Illuminate\Http\Request;
use Validator;
use DB;

class LoginPageAds extends Controller
{
    //login

    public function login_list()
    {
        $items = LoginPageAd::all();
        return view('dashboard.ads.login.list', compact('items'));
    }

    public function login_add()
    {
        return view('dashboard.ads.login.add');
    }

    public function login_addPost(Request $request)
    {

        $data = $request->all();
        $rule = [
            'image' => 'required',
        ];
        $message = [
            'image.required' => 'عکس الزامی میباشد',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $item = new LoginPageAd();
        $file = $request->file('image');
        $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $file->move('file/login/images', $pathName);
        $item->image = 'file/login/images/' . $pathName;
        DB::beginTransaction();

        try {
            $item->save();
            DB::commit();
            return redirect(route('adslogin.list'))->with('success','ذخیره تبلیغات صفحه ورود  با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }        
    }

    public function login_delete($id)
    {

        $item = LoginPageAd::find($id);
        if ($item->image) {
            if ($item->image && file_exists(public_path($item->image))) {
                unlink(public_path($item->image));
            }
            if ($item->image) {
                $item->delete();
                return redirect(route('adslogin.list'))->with('success', ' تبلیغات صفحه ورود با موفقیت  حذف شد ');
            }
        }
    }

    public function login_edit($id)
    {
        $item = LoginPageAd::find($id);

        return view('dashboard.ads.login.edit',compact('item'));
    }

    public function login_editPost(Request $request, $id)
    {
        // کد ویرایش تبلیغ
        $item = LoginPageAd::find($id);

        if ($request->hasFile('image')) {
            if ($item->image) {
                $oldImage = $item->image;
                if ($oldImage && file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
            $picFile = $request->file('image');
            $picName = time() . '_' . uniqid() . '.' . $picFile->getClientOriginalExtension();
            $picFile->move('file/login/images', $picName);

            $item->image = 'file/login/images/' . $picName;
        }

        $item->save();
        return redirect(route('adslogin.list'))->with('success', ' تبلیغات صفحه ورود با موفقیت  بروزرسانی شد ');

    }

}
