<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Validator;
use Hekmatinasser\Verta\Verta;

use DB;

class TrainingCourseController extends Controller
{
    //
    public function list(){
        $courses = Course::all();
        foreach ($courses as $key => $course) {
            $course['time'] = ($course->date!=null) ? $this->time_topnav($course->date):'--';
        }
        return view('dashboard.training_course.list',compact('courses'));
    }
    public function add(){
        return view('dashboard.training_course.add');
    }
    public function addPost(request $request){
        $data=$request->all();
        $rule=[
            'name' => 'required',
            'description' => 'required',
            'teacher' => 'required',
        ];
        $message=[
            'name.required' => 'عنوان الزامی میباشد',
            'description.required' => 'توضیحات الزامی میباشد',
            'teacher.required' => 'نام استاد الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $corse = new Course();
        $corse->name = $request->name;
        $corse->description = $request->description;
        $corse->teacher = $request->teacher;
        $convertToEnglish = function ($string) {
            $persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            $englishDigits = ['0','1','2','3','4','5','6','7','8','9'];
            return str_replace($persianDigits, $englishDigits, $string);
        };
        $date = $convertToEnglish($request->date); 
        $date_final = Verta::parseFormat('Y/m/d H:i:s', $date)->toCarbon();
        $corse->date = $date_final;
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file/corse'), $pathName);
            $corse->image = 'file/corse/' . $pathName;
        }
        DB::beginTransaction();

        try {
            $corse->save();
            DB::commit();
            return redirect(route('course.list'))->with('success','ذخیره استاندارد آموزشی ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }
    public function delete($id)
    {
        $course=Course::find($id);
        $name=$course->name;
        $course->delete();
        return redirect(route('course.list'))->with('success','حذف استاندارد آموزشی ' . $name . ' با موفقیت انجام شد');
    }
    public function edit($id){
        $course = Course::find($id);
        return view('dashboard.training_course.edit',compact('course'));
    }
    public function editpost(request $request,$id){
        $data=$request->all();
        $rule=[
            'name' => 'required',
            'description' => 'required',        ];
        $message=[
            'name.required' => 'عنوان الزامی میباشد',
            'description.required' => 'توضیحات الزامی میباشد',
        ];
        $validator = Validator::make($data,$rule,$message);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        
        $course=Course::find($id);
        $course->name=$request->name;
        $course->description=$request->description;
        $course->teacher = $request->teacher;

        if ($request->date==null) {
            $course->date = $course->date;
        }else {
            $convertToEnglish = function ($string) {
                $persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
                $englishDigits = ['0','1','2','3','4','5','6','7','8','9'];
                return str_replace($persianDigits, $englishDigits, $string);
            };
            $date = $convertToEnglish($request->date); 
            $date_final = Verta::parseFormat('Y/m/d H:i:s', $date)->toCarbon();
            $course->date = $date_final;
        }
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file/corse'), $pathName);
            $course->image = 'file/corse/' . $pathName;
        }
        DB::beginTransaction();

        try {
            $course->save();

            DB::commit();
            return redirect(route('course.list'))->with('success','ویرایش استاندارد آموزشی ' . $request->name. ' با موفقیت انجام شد');

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','خطای سیستمی');
            // something went wrong
        }
    }
}
