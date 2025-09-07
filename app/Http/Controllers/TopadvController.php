<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use App\Models\topadv;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
class TopadvController extends Controller
{
    //

    public function list()
    {
        $items = topadv::orderBy('id', 'desc')->get();
        foreach ($items as $item) {
            $item['start_date'] = $this->time_topnav($item->start_date);
            $item['end_date'] = $this->time_topnav($item->end_date);
        }


        return view('dashboard.topadv.list', compact('items'));
    }
    public function add()
    {
        return view('dashboard.topadv.add');
    }



    public function addPost(Request $request)
    {
        $request->validate([
            'title'             => 'required',
            'text'              => 'required',
            'background_color'  => 'nullable',
            'animation_type'    => 'nullable',
            'background_image'  => 'nullable',
            'page_link'         => 'nullable|required_with:page_link_type',
            'page_link_type'    => 'nullable|required_with:page_link',
            'text_color'        => 'nullable',
            'duration'          => 'nullable|integer',
            'start_date'        => 'required', // در صورت نیاز می‌توانید قانون دقیق‌تری اضافه کنید
            'end_date'          => 'required',
        ]);

        // تابع کمکی برای تبدیل اعداد فارسی به انگلیسی
        $convertToEnglish = function ($string) {
            $persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            $englishDigits = ['0','1','2','3','4','5','6','7','8','9'];
            return str_replace($persianDigits, $englishDigits, $string);
        };

        // ایجاد نمونه جدید از مدل
        $item = new Topadv();

        // انتساب مقادیر به مدل
        $item->title           = $request->title;
        $item->text            = $request->text;
        $item->text_color      = $request->text_color;
        $item->background_color= $request->background_color;
        $item->animation_type  = $request->animation_type;
        $item->page_link       = $request->page_link;
        $item->page_link_type  = $request->page_link_type;

        // تبدیل تاریخ‌ها: ابتدا اعداد فارسی به انگلیسی تبدیل می‌شوند
        $start_date_jalali = $convertToEnglish($request->start_date);
        $end_date_jalali   = $convertToEnglish($request->end_date);
        $duration_seconds  = $request->duration;

        // توجه داشته باشید که فرمت ورودی باید با رشته ورودی مطابقت داشته باشد
        $start_date = Verta::parseFormat('Y/m/d H:i:s', $start_date_jalali)->toCarbon();
        $end_date   = Verta::parseFormat('Y/m/d H:i:s', $end_date_jalali)->toCarbon();
        $duration_seconds = (int) $duration_seconds;

        $item->start_date = $start_date;
        $item->end_date   = $end_date;
        $item->duration   = $duration_seconds;

        // if ($request->hasFile('background_image')) {
        //     $file = $request->file('background_image');
        //     $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('file/topadv'), $pathName);
        // }
        $item->background_image = $request->background_image;

        DB::beginTransaction();

        try {
            $item->save();
            DB::commit();
            return redirect(route('topadv.list'))->with('success', 'ذخیره اطلاعیه با موفقیت انجام شد');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'خطای سیستمی');
        }
    }

    public function edit($id)
    {
        $topadv = topadv::find($id);
        return view('dashboard.topadv.edit', compact('topadv'));
    }
    public function editPost(request $request, $id)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'animation_type' => 'nullable|string',
            'background_color' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'text_color' => 'nullable|string',
            'background_image' => 'nullable',
            'page_link' => 'nullable|string|url',
            'duration' => 'nullable|integer',
        ]);
        $item = Topadv::findOrFail($id);

        $item->title = $request->title;
        $item->text = $request->text;
        $item->animation_type = $request->animation_type;
        $item->background_color = $request->background_color;
        $item->text_color = $request->text_color;
        $item->page_link = $request->page_link;

        $start_date_jalali = $request->start_date;
        $end_date_jalali = $request->end_date;
        $duration_seconds = $request->duration;
        $start_date = Verta::parseFormat('Y/m/d/H:i:s', $start_date_jalali)->toCarbon();
        $end_date = Verta::parseFormat('Y/m/d/H:i:s', $end_date_jalali)->toCarbon();
        $duration_seconds = (int) $duration_seconds;

        $item->start_date = $start_date;
        $item->end_date = $end_date;
        $item->duration = $duration_seconds;
        // if ($request->hasFile('background_image')) {
        //     if ($item->background_image && file_exists(public_path($item->background_image))) {
        //         unlink(public_path($item->background_image));
        //     }

        //     $file = $request->file('background_image');
        //     $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        //     $file->move(public_path('file/topadv'), $pathName);
        //     $item->background_image = 'file/topadv/' . $pathName;
        // }
        $item->background_image = $request->background_image;


        if ($item->save()) {
            return redirect()->route('topadv.list')->with('success', 'اطلاعیه با موفقیت ویرایش شد');
        } else {
            return back()->with('error', 'مشکلی در ویرایش رخ داده است');
        }
    }

    public function delete($id)
    {
        $item = Topadv::findOrFail($id);

        if ($item->background_image && file_exists(public_path($item->background_image))) {
            unlink(public_path($item->background_image));
        }

        if ($item->delete()) {
            return redirect()->route('topadv.list')->with('success', 'اطلاعیه با موفقیت حذف شد');
        } else {
            return redirect()->route('topadv.list')->with('error', 'مشکلی در حذف رخ داده است');
        }
    }
}
