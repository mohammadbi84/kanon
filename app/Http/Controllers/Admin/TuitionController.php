<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use App\Models\City;
use Illuminate\Http\Request;

class TuitionController extends Controller
{
    /**
     * نمایش لیست شهریه‌ها (AJAX و Blade)
     */
    public function index()
    {
        if (request()->ajax()) {
            $tuitions = Tuition::with('city')->latest()->get();
            return response()->json(['data' => $tuitions]);
        }

        $cities = City::where('active', true)->get();
        return view('admin.tuitions.index', compact('cities'));
    }

    /**
     * ذخیره شهریه جدید
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'city_id'     => 'required|exists:cities,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ], [
            'title.required'      => 'عنوان شهریه الزامی است.',
            'city_id.required'    => 'انتخاب شهر الزامی است.',
            'city_id.exists'      => 'شهر انتخاب‌شده معتبر نیست.',
            'start_date.required' => 'تاریخ شروع الزامی است.',
            'end_date.required'   => 'تاریخ پایان الزامی است.',
            'end_date.after'      => 'تاریخ پایان باید بعد از تاریخ شروع باشد.',
        ]);

        $tuition = Tuition::create([
            'title'       => $request->title,
            'city_id'     => $request->city_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'شهریه با موفقیت اضافه شد.',
            'data'    => $tuition,
        ]);
    }

    /**
     * ویرایش شهریه
     */
    public function edit($id)
    {
        $tuition = Tuition::findOrFail($id);
        $cities = City::all();
        return view('admin.tuitions.edit', compact('tuition', 'cities'));
    }

    /**
     * بروزرسانی شهریه
     */
    public function update(Request $request, $id)
    {
        $tuition = Tuition::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'city_id'     => 'required|exists:cities,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ], [
            'title.required'      => 'عنوان شهریه الزامی است.',
            'city_id.required'    => 'انتخاب شهر الزامی است.',
            'city_id.exists'      => 'شهر انتخاب‌شده معتبر نیست.',
            'start_date.required' => 'تاریخ شروع الزامی است.',
            'end_date.required'   => 'تاریخ پایان الزامی است.',
            'end_date.after'      => 'تاریخ پایان باید بعد از تاریخ شروع باشد.',
        ]);

        $tuition->update([
            'title'       => $request->title,
            'city_id'     => $request->city_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        return redirect()->route('admin.tuitions.index')->with('success', 'شهریه با موفقیت ویرایش شد.');
    }

    /**
     * حذف یک شهریه
     */
    public function delete($id)
    {
        Tuition::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'شهریه با موفقیت حذف شد.']);
    }

    /**
     * حذف گروهی شهریه‌ها
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        Tuition::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'شهریه‌ها با موفقیت حذف شدند.']);
    }
}
