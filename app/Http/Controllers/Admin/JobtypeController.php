<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jobtype;
use Illuminate\Http\Request;

class JobtypeController extends Controller
{
    public function index(){
        $jobtypes = Jobtype::latest()->paginate(20);
        return view('admin.jobtypes.index',compact('jobtypes'));
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|string',
        ],[
            'name.required'=>'نام نوع شغل الزامی است.',
            'name.string'=>'نام نوع شغل باید به صورت متنی باشد',
        ]);
        $item=new Jobtype();
        $item->name=$request->name;
        $item->save();
        return redirect()->back()->with('success','نوع شغل با موفقیت اضافه شد.');
    }
    public function delete($id){
        $jobtype = Jobtype::findOrFail($id);
        $jobtype->delete();
        return redirect()->back()->with('success','نوع شغل با موفقیت حذف شد.');
    }
}
