<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;

class TuitionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $tuitions = Tuition::with('state', 'cities', 'professions')
                ->get()
                ->sortBy([
                    fn($tuition) => $tuition->state->name ?? '',
                    // مرتب‌سازی بر اساس نام اولین شهر (یا می‌توانید تمام شهرها را یک رشته کنید)
                    fn($tuition) => $tuition->cities->sortBy('name')->pluck('name')->first() ?? '',
                    fn($tuition) => $tuition->end_date,
                ])
                ->values(); // ریست کردن کلیدهای عددی
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

        // همه استان‌ها به جز آنهایی که تداخل دارند
        $availableStates = City::where('active', 1)
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
            'start_date_miladi'  => 'required|date',
            'end_date_miladi'    => 'required|date|after:start_date_miladi',
            'city_ids' => 'required|array',
        ], [
            'title.required'      => 'عنوان شهریه الزامی است.',
            'state_id.required'    => 'انتخاب شهر الزامی است.',
            'state_id.exists'      => 'شهر انتخاب‌ شده معتبر نیست.',
            'start_date_miladi.required' => 'تاریخ شروع الزامی است.',
            'end_date_miladi.required'   => 'تاریخ پایان الزامی است.',
            'end_date_miladi.after'      => 'تاریخ پایان باید بعد از تاریخ شروع باشد.',
        ]);

        $corectStart = Carbon::make($request->start_date_miladi)->addDay();
        $corectEnd = Carbon::make($request->end_date_miladi)->addDay();

        $tuition = Tuition::create([
            'title'       => $request->title,
            'state_id'     => $request->state_id,
            'start_date'  => $corectStart,
            'end_date'    => $corectEnd,
        ]);


        if (in_array('all_cities', $validated['city_ids'])) {
            $stateId = $validated['state_id'];

            $conflictCityIds = Tuition::where('state_id', $stateId)
                ->where(function ($query) use ($corectStart, $corectEnd) {
                    $query->whereBetween('start_date', [$corectStart, $corectEnd])
                        ->orWhereBetween('end_date', [$corectStart, $corectEnd])
                        ->orWhere(function ($q) use ($corectStart, $corectEnd) {
                            $q->where('start_date', '<=', $corectStart)
                                ->where('end_date', '>=', $corectEnd);
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
                ->pluck('id')->toArray();

            $tuition->cities()->sync($availableCities);
        } else {
            $tuition->cities()->sync($validated['city_ids']);
        }
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
        $availableStates = City::where('active', 1)
            ->whereNull('parent')
            ->orderBy('title')
            ->get(['id', 'title']);
        if (request()->ajax()) {
            $tuition = Tuition::findOrFail($id);
            $tuition['startMiladi'] = Jalalian::forge($tuition->start_date)->format('Y-m-d');
            $tuition['endMiladi'] = Jalalian::forge($tuition->end_date)->format('Y-m-d');

            $conflictCityIds = Tuition::whereNotIn('id', [$tuition->id])
                ->where(function ($query) use ($tuition) {
                    $query->whereBetween('start_date', [$tuition->start_date, $tuition->end_date])
                        ->orWhereBetween('end_date', [$tuition->start_date, $tuition->end_date])
                        ->orWhere(function ($q) use ($tuition) {
                            $q->where('start_date', '<=', $tuition->start_date)
                                ->where('end_date', '>=', $tuition->end_date);
                        });
                })
                ->with('cities') // فرض: رابطه cities در مدل Tuition
                ->get()
                ->pluck('cities.*.id')
                ->flatten()
                ->unique()
                ->toArray();

            // همه شهرهای استان به جز آنهایی که تداخل دارند
            $availableCities = $tuition->cities()->get(['cities.id', 'cities.title']);


            return response()->json(['data' => $tuition, 'states' => $availableStates, 'cities' => $availableCities]);
        }
        return view('admin.tuitions.edit', compact('tuition', 'cities'));
    }

    public function availableCitiesForEdit(Request $request)
    {
        $stateId = $request->query('state_id');
        $tuitionId = $request->query('tuition_id');
        $tuition = Tuition::findOrFail($tuitionId);


        $miladi_start = Jalalian::fromFormat('Y-m-d', $request->query('start_date') ?? "1300-01-01")->toCarbon();
        $miladi_end = Jalalian::fromFormat('Y-m-d', $request->query('end_date') ?? "1500-01-01")->toCarbon();

        $start = Carbon::make($miladi_start);
        $end = Carbon::make($miladi_end);

        $conflictCityIds = Tuition::where('state_id', $stateId)->whereNotIn('id', [$tuition->id])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
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
            ->pluck('id', 'title')->toArray();

        return response()->json($availableCities);
    }

    /**
     * بروزرسانی شهریه
     */
    public function update(Request $request, Tuition $tuition)
    {
        Log::info($request);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'state_id' => 'required|exists:cities,id',
            'city_ids' => 'required|array',
            'city_ids.*' => 'exists:cities,id',
            'start_date'  => 'required',
            'end_date'    => 'required',
        ]);

        // بررسی تداخل دوباره (اختیاری اما توصیه می‌شود)
        // ... می‌توانید بررسی کنید شهرهای انتخابی در بازه تداخل ندارند
        $miladi_start = Jalalian::fromFormat('Y-m-d', $request->input('start_date') ?? "1300-01-01")->toCarbon();
        $miladi_end = Jalalian::fromFormat('Y-m-d', $request->input('end_date') ?? "1500-01-01")->toCarbon();
        $corectStart = Carbon::make($miladi_start);
        $corectEnd = Carbon::make($miladi_end);

        $tuition->update([
            'title' => $validated['title'],
            'state_id' => $validated['state_id'],
            'start_date'  => $corectStart,
            'end_date'    => $corectEnd,
        ]);

        $tuition->cities()->sync($validated['city_ids']);

        return response()->json(['success' => true, 'message' => 'شهریه ویرایش شد.']);
    }

    public function toggle(Tuition $tuition)
    {
        $tuition->update([
            'active' => !$tuition->active
        ]);
        if ($tuition->active) {
            return response()->json(['success' => true, 'message' => 'شهریه با موفقیت منتشر شد.']);
        }
        return response()->json(['success' => true, 'message' => 'شهریه با موفقیت از حالت انتشار خارج شد.']);
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
