<?php

namespace App\Http\Controllers;

use App\Models\Organ;
use App\Models\OrganUser;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use DB;

class MemberController extends Controller
{
    //
    public function list($o_id){
        $organ=Organ::find($o_id);
        $members_id=OrganUser::where('organ_id',$o_id)->pluck('user_id');
        $members=User::whereIn('id',$members_id)->get();
        foreach ($members as $member) {
            $role=OrganUser::where('organ_id',$o_id)->where('user_id',$member->id)->first()->role;
            if($role==1)
                $member['role_name']='مدیر';
            else if($role==2)
                $member['role_name']='معاون';
            else if($role==3)
                $member['role_name']='کاربر';

        }
        return view('dashboard.member.list',compact('organ','members'));
    }

    public function addPost(Request $request,$o_id)
    {
        $data=$request->all();
        $rule=[
            'name' => 'required',
            'family' => 'required',
            'mobile' => 'required|ir_mobile:zero',
            'role' => 'required|numeric',
        ];
        $message=[
            'name.required' => 'نام الزامی میباشد',
            'family.required' => 'فامیل الزامی میباشد',
            'mobile.required' => 'موبایل الزامی میباشد',
            'mobile.ir_mobile' => 'قالب موبایل درست نیست',
            'role.required' => 'نقش الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $member=User::where('mobile',$request->mobile)->first();

        DB::beginTransaction();

        try {
            if(!$member) {
                $member = new User();
                $member->name = $request->name;
                $member->family = $request->family;
                $member->mobile = $request->mobile;
                $member->password = bcrypt($request->mobile);

                $member->save();

                $member->addRole('user');
            }
            $membership=new OrganUser();
            $membership->user_id=$member->id;
            $membership->organ_id=$o_id;
            $membership->role=$request->role;
            $membership->save();
            DB::commit();
            return redirect(route('member.list',['o_id'=>$o_id]))->with('success','ذخیره کاربر ' . $request->name.' '.$request->family. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی')->withInput();
            // something went wrong
        }
    }

    public function delete($o_id,$id)
    {
        $user=User::find($id);
        $name=$user->name.' '.$user->family;
        $membership=OrganUser::where('organ_id',$o_id)->where('user_id',$id)->first();
        $membership->delete();
        return redirect()->back()->with('success','حذف کارمند ' . $name . ' با موفقیت انجام شد');

    }

    public function edit($o_id,$id)
    {
        $user=User::find($id);
        $organ=Organ::find($o_id);
        $role=OrganUser::where('user_id',$id)->where('organ_id',$o_id)->first()->role;
        return view('dashboard.member.edit',compact('user','organ','role'));
    }
    public function editpost(Request $request,$o_id,$id)
    {
        $data=$request->all();
        $rule=[
//            'name' => 'required',
//            'family' => 'required',
//            'mobile' => 'required|ir_mobile:zero',
            'role' => 'required|numeric',
        ];
        $message=[
//            'name.required' => 'نام الزامی میباشد',
//            'family.required' => 'فامیل الزامی میباشد',
//            'mobile.required' => 'موبایل الزامی میباشد',
//            'mobile.ir_mobile' => 'قالب موبایل درست نیست',
            'role.required' => 'نقش الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $membership=OrganUser::where('user_id',$id)->where('organ_id',$o_id)->first();
        $user=User::find($id);
        DB::beginTransaction();

        try {

            $membership->role=$request->role;
            $membership->save();
            DB::commit();
            return redirect(route('member.list',['o_id'=>$o_id]))->with('success','ویرایش کاربر ' . $user->name.' '.$user->family. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی')->withInput();
            // something went wrong
        }
    }


}
