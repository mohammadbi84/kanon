<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;

class TuitionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $tuitions = Tuition::with('state')->latest()->get();
            return response()->json(['data' => $tuitions]);
        }

        $tuitions_count = Tuition::count();
        return view('admin.tuitions.index', compact('tuitions_count'));
    }

    public function availableStates(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $gregorianDateStartString = Jalalian::fromFormat('Y/m/d', $startDate)->toCarbon();
        $gregorianDateEndString = Jalalian::fromFormat('Y/m/d', $endDate)->toCarbon();

        if (!$startDate || !$endDate) {
            return response()->json([]);
        }

        // استان‌هایی که در بازه زمانی تداخل دارند
        $conflictStateIds = Tuition::where(function ($query) use ($gregorianDateStartString, $gregorianDateEndString) {
            $query->whereBetween('start_date', [$gregorianDateStartString, $gregorianDateEndString])
                ->orWhereBetween('end_date', [$gregorianDateStartString, $gregorianDateEndString])
                ->orWhere(function ($q) use ($gregorianDateStartString, $gregorianDateEndString) {
                    $q->where('start_date', '<=', $gregorianDateStartString)
                        ->where('end_date', '>=', $gregorianDateEndString);
                });
        })->pluck('state_id')->unique()->filter()->toArray();

        // همه استان‌ها به جز آنهایی که تداخل دارند
        $availableStates = City::whereNotIn('id', $conflictStateIds)
            ->where('active', 1)
            ->whereNull('parent')
            ->orderBy('title')
            ->get(['id', 'title']);

        return response()->json($availableStates);
    }

    public function availableCities(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $stateId = $request->query('state_id');

        $gregorianDateStartString = Jalalian::fromFormat('Y/m/d', $startDate)->toCarbon();
        $gregorianDateEndString = Jalalian::fromFormat('Y/m/d', $endDate)->toCarbon();


        if (!$startDate || !$endDate || !$stateId) {
            return response()->json([]);
        }

        // شهرهایی از استان انتخاب‌شده که در بازه زمانی تداخل دارند
        $conflictCityIds = Tuition::where('state_id', $stateId)
            ->where(function ($query) use ($gregorianDateStartString, $gregorianDateEndString) {
                $query->whereBetween('start_date', [$gregorianDateStartString, $gregorianDateEndString])
                    ->orWhereBetween('end_date', [$gregorianDateStartString, $gregorianDateEndString])
                    ->orWhere(function ($q) use ($gregorianDateStartString, $gregorianDateEndString) {
                        $q->where('start_date', '<=', $gregorianDateStartString)
                            ->where('end_date', '>=', $gregorianDateEndString);
                    });
            })
            ->with('cities') // فرض: رابطه cities در مدل Tuition
            ->get()
            ->pluck('cities.*.id')
            ->flatten()
            ->unique()
            ->toArray();

        // همه شهرهای استان به جز آنهایی که تداخل دارند
        $availableCities = City::where('parent', $stateId)
            ->whereNotIn('id', $conflictCityIds)
            ->where('active', 1)
            ->whereNotNull('parent')
            ->orderBy('title')
            ->get(['id', 'title']);

        return response()->json($availableCities);
    }

    /**
     * ذخیره شهریه جدید
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'state_id'     => 'required|exists:cities,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'city_ids' => 'required|array',
            'city_ids.*' => 'exists:cities,id',
        ], [
            'title.required'      => 'عنوان شهریه الزامی است.',
            'state_id.required'    => 'انتخاب شهر الزامی است.',
            'state_id.exists'      => 'شهر انتخاب‌ شده معتبر نیست.',
            'start_date.required' => 'تاریخ شروع الزامی است.',
            'end_date.required'   => 'تاریخ پایان الزامی است.',
            'end_date.after'      => 'تاریخ پایان باید بعد از تاریخ شروع باشد.',
        ]);

        $gregorianDateStartString = Jalalian::fromFormat('Y/m/d', $request->start_date)->toCarbon()->format('Y-m-d');
        $gregorianDateEndString = Jalalian::fromFormat('Y/m/d', $request->end_date)->toCarbon()->format('Y-m-d');

        $tuition = Tuition::create([
            'title'       => $request->title,
            'state_id'     => $request->state_id,
            'start_date'  => $gregorianDateStartString,
            'end_date'    => $gregorianDateEndString,
        ]);

        $tuition->cities()->sync($validated['city_ids']);

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
            'state_id'     => 'required|exists:cities,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ], [
            'title.required'      => 'عنوان شهریه الزامی است.',
            'state_id.required'    => 'انتخاب شهر الزامی است.',
            'state_id.exists'      => 'شهر انتخاب‌شده معتبر نیست.',
            'start_date.required' => 'تاریخ شروع الزامی است.',
            'end_date.required'   => 'تاریخ پایان الزامی است.',
            'end_date.after'      => 'تاریخ پایان باید بعد از تاریخ شروع باشد.',
        ]);

        $tuition->update([
            'title'       => $request->title,
            'state_id'     => $request->state_id,
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
