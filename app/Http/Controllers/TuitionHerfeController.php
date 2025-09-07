<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\TuitionSanad;
use Illuminate\Http\Request;
use App\Models\TuitionHerfe;
use App\Models\Herfe;
use App\Models\SanadHerfe;
// use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Hekmatinasser\Verta\Verta; // Import Verta

class TuitionHerfeController extends Controller
{

    // نمایش لیست سال‌ها
    public function home()
    {
        // دریافت سال‌های منحصر به فرد از جدول TuitionHerfe
        $years = TuitionHerfe::all();
        foreach ($years as $key => $item) {
            $item['cityName'] = City::where('id', $item->city_id)->first()->title ?? 'بدون شهر';
        }

        // دریافت تمامی داده‌های TuitionHerfe (اگر لازم باشد)
        $tuitionHerfes = TuitionHerfe::all();

        // ارسال داده‌ها به ویو
        return view('dashboard.tuition_herfe.index', compact('years', 'tuitionHerfes'));
    }

    public function create()
    {
        $cities = City::where('active', 1)->whereNull('parent')->get();
        return view('dashboard.tuition_herfe.create', compact('cities'));
    }
    public function storeyear(request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'year' => 'required|integer|',
            'title' => 'required|string|max:255',
            'startDate' => 'required',
            'endDate' => 'required',
            'city_id' => 'required|exists:cities,id',
        ],[
            'year.required' => 'لطفا سال را وارد کنید.',
            'year.integer' => 'سال باید یک عدد صحیح باشد.',
            'title.required' => 'لطفا عنوان را وارد کنید.',
            'startDate.required' => 'لطفا تاریخ شروع را وارد کنید.',
            'endDate.required' => 'لطفا تاریخ پایان را وارد کنید.',
            'city_id.required' => 'لطفا شهر را انتخاب کنید.',
            'city_id.exists' => 'شهر انتخاب شده معتبر نیست.',
        ]);

        $convertToEnglish = function ($string) {
            $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            return str_replace($persianDigits, $englishDigits, $string);
        };
        $startDate_jalali = $convertToEnglish($request->startDate);
        $endDate_jalali = $convertToEnglish($request->endDate);

        $sanad = new TuitionSanad();
        $sanad->year = $request->year;
        $sanad->title = $request->title;
        // تبدیل تاریخ جلالی به میلادی با Verta و try-catch
        try {
            $sanad->start_date = Verta::parseFormat('Y/m/d', $startDate_jalali)->toCarbon();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['startDate' => 'فرمت تاریخ انتشار صحیح نیست.'])->withInput();
        }
        try {
            $sanad->end_date = Verta::parseFormat('Y/m/d', $endDate_jalali)->toCarbon();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['endDate' => 'فرمت تاریخ آرشیو صحیح نیست.'])->withInput();
        }
        $sanad->city_id = $request->city_id;
        $sanad->save();
        $herfe = new TuitionHerfe();
        $herfe->year = $request->year;
        $herfe->title = $request->title;
        // تبدیل تاریخ جلالی به میلادی با Verta و try-catch
        try {
            $herfe->start_date = Verta::parseFormat('Y/m/d', $startDate_jalali)->toCarbon();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['startDate' => 'فرمت تاریخ انتشار صحیح نیست.'])->withInput();
        }
        try {
            $herfe->end_date = Verta::parseFormat('Y/m/d', $endDate_jalali)->toCarbon();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['endDate' => 'فرمت تاریخ آرشیو صحیح نیست.'])->withInput();
        }
        $herfe->city_id = $request->city_id;
        $herfe->save();
        return redirect()->back()->with('success', 'سال با موفقیت اضافه شد!');
    }
    // نمایش شهریه‌ها برای یک سال خاص

    public function showYear($year)
    {
        // 1. Get ALL Herves, related tuition info, and group name
        $year = request('year'); // یا از پارامتر مستقیم یا مقدار پیش‌فرض

        // 1. Herves Data
        $hervesData = DB::table('herves')
            ->leftJoin('tuition_herves', function ($join) use ($year) {
                $join->on('herves.id', '=', 'tuition_herves.herfe_id')
                    ->where('tuition_herves.year', '=', $year);
            })
            ->leftJoin('groups', 'herves.group_id', '=', 'groups.id')
            ->select(
                'herves.id as id',
                DB::raw('NULL as tuition_id'),
                'herves.id as herfe_id',
                DB::raw('NULL as sanad_id'),
                'tuition_herves.year',
                'tuition_herves.in_person_fee',
                'tuition_herves.online_fee',
                'tuition_herves.electronic_fee',
                'herves.name as herfe_name',
                'herves.code as herfe_code',
                DB::raw('NULL as sanad_title'),
                DB::raw('NULL as sanad_code'),
                'herves.total_time as total_time',
                'groups.name as group_name',
                DB::raw("'herfe' as type")
            );

        // 2. SanadHerves Data
        $sanadHervesData = DB::table('sanad_herves')
            ->leftJoin('tuition_sanads', function ($join) use ($year) {
                $join->on('sanad_herves.id', '=', 'tuition_sanads.sanad_id')
                    ->where('tuition_sanads.year', '=', $year);
            })
            ->leftJoin('groups', 'sanad_herves.group_id', '=', 'groups.id')
            ->select(
                'sanad_herves.id as id',
                DB::raw('NULL as tuition_id'),
                DB::raw('NULL as herfe_id'),
                'sanad_herves.id as sanad_id',
                'tuition_sanads.year',
                'tuition_sanads.in_person_fee',
                'tuition_sanads.online_fee',
                'tuition_sanads.electronic_fee',
                DB::raw('NULL as herfe_name'),
                DB::raw('NULL as herfe_code'),
                'sanad_herves.title as sanad_title',
                'sanad_herves.code as sanad_code',
                DB::raw('NULL as total_time'),
                'groups.name as group_name',
                DB::raw("'sanad' as type")
            );

        // 3. Combine based on `type`
        $type = request('type');

        if ($type === 'herfe') {
            $combinedData = $hervesData;
        } elseif ($type === 'sanad') {
            $combinedData = $sanadHervesData;
        } else {
            $combinedData = $sanadHervesData->union($hervesData);
        }

        $combinedData = $combinedData->get();
        return view('dashboard.tuition_herfe.show', compact('combinedData', 'year'));
    }
    public function updateAll(Request $request)
    {
        // 1. Sanitize input: Remove commas  (same as before)
        $fields = ['in_person_fee', 'online_fee', 'electronic_fee'];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $newValues = [];

                // IMPORTANT CHANGE HERE:  Loop through $request->$field directly
                foreach ($request->{$field} as $combinedKey => $values) {
                    $newValues[$combinedKey] = [];
                    foreach ($values as $id => $value) { // $id is now herfe_id or sanad_id
                        $newValues[$combinedKey][$id] = str_replace(',', '', $value);
                    }
                }
                $request->merge([$field => $newValues]); // Changed key
            }
        }

        // 2. Validate inputs (Slight change in validation rules)
        $validator = Validator::make($request->all(), [
            'tuition_ids' => 'required|array',
            // 'tuition_ids.*'  => 'required|string',  // No longer needed, we validate herfe_id and sanad_id directly

            'in_person_fee.*.*' => 'nullable|numeric',
            'online_fee.*.*' => 'nullable|numeric',
            'electronic_fee.*.*' => 'nullable|numeric',
            'herfe_id.*' => 'nullable|integer|exists:herves,id',
            'sanad_id.*' => 'nullable|integer|exists:sanad_herves,id',
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // 3. Update records
        if ($request->has('tuition_ids') && is_array($request->tuition_ids)) {

            foreach ($request->tuition_ids as $combinedKey) { // $combinedKey is now "herfe_..." or "sanad_..."

                // Extract type and ID from the combined key
                [$type, $id] = explode('_', $combinedKey);


                if ($type === 'herfe') {

                    // Update/Create TuitionHerfe
                    $herfeId = $id; // $id is already herfe_id

                    // Find existing record
                    $tuitionHerve = TuitionHerfe::where('herfe_id', $herfeId)
                        ->where('year', $request->year)
                        ->first();

                    if ($tuitionHerve) {
                        // Update
                        $tuitionHerve->update([
                            'in_person_fee' => ($request->in_person_fee[$combinedKey][$herfeId] !=null)?$request->in_person_fee[$combinedKey][$herfeId] : null,
                            'online_fee' => ($request->online_fee[$combinedKey][$herfeId] !=null)?$request->online_fee[$combinedKey][$herfeId] : null,
                            'electronic_fee' => ($request->electronic_fee[$combinedKey][$herfeId]!=null)? $request->electronic_fee[$combinedKey][$herfeId] : null,
                            ]);
                    } else {
                        // Create
                        TuitionHerfe::create([
                            'herfe_id' => $herfeId,
                            'year' => $request->year,
                            'in_person_fee' => ($request->in_person_fee[$combinedKey][$herfeId] !=null)?$request->in_person_fee[$combinedKey][$herfeId] : null,
                            'online_fee' => ($request->online_fee[$combinedKey][$herfeId] !=null)?$request->online_fee[$combinedKey][$herfeId] : null,
                            'electronic_fee' => ($request->electronic_fee[$combinedKey][$herfeId]!=null)? $request->electronic_fee[$combinedKey][$herfeId] : null,
                            'tuition_id' => null, // Or some other default
                        ]);
                    }
                } elseif ($type === 'sanad') {
                    // Update/Create TuitionSanad
                    $sanadId = $id;  // $id is already sanad_id

                    // Find existing record
                    $tuitionSanad = TuitionSanad::where('sanad_id', $sanadId)
                        ->where('year', $request->year)
                        ->first();

                    if ($tuitionSanad) {
                        // Update
                        $tuitionSanad->update([
                            'in_person_fee' => ($request->in_person_fee[$combinedKey][$sanadId] != null) ? $request->in_person_fee[$combinedKey][$sanadId] : null,
                            'online_fee' => ($request->online_fee[$combinedKey][$sanadId] != null) ? $request->online_fee[$combinedKey][$sanadId] : null,
                            'electronic_fee' => ($request->electronic_fee[$combinedKey][$sanadId] != null) ? $request->electronic_fee[$combinedKey][$sanadId] : null,
                        ]);
                    } else {
                        // Create
                        TuitionSanad::create([
                            'sanad_id' => $sanadId,
                            'year' => $request->year,
                            'in_person_fee' => ($request->in_person_fee[$combinedKey][$sanadId] != null) ? $request->in_person_fee[$combinedKey][$sanadId] : null,
                            'online_fee' => ($request->online_fee[$combinedKey][$sanadId] != null) ? $request->online_fee[$combinedKey][$sanadId] : null,
                            'electronic_fee' => ($request->electronic_fee[$combinedKey][$sanadId] != null) ? $request->electronic_fee[$combinedKey][$sanadId] : null,
                            'tuition_id' => null, // or some other default
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'قیمت‌ها با موفقیت به‌روزرسانی شدند!');
    }

    // ذخیره شهریه جدید
    public function store(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'year' => 'required',
            'standard_code' => 'required',
            'herfe_id' => 'required|exists:herfes,id', // اطمینان از وجود herfe_id
            'sanad_id' => 'required|exists:sanad_herfes,', // اطمینان از وجود sanad_id
            'in_person_fee' => 'nullable|numeric',
            'online_fee' => 'nullable|numeric',
            'electronic_fee' => 'nullable|numeric',
            'City' => 'required',
        ]);

        // ذخیره اطلاعات در مدل TuitionHerfe
        TuitionHerfe::create([
            'herfe_id' => $request->herfe_id,
            'sanad_id' => $request->sanad_id,
            'year' => $request->year,
            'standard_code' => $request->standard_code,
            'duration' => $request->duration,
            'in_person_fee' => $request->in_person_fee,
            'online_fee' => $request->online_fee,
            'electronic_fee' => $request->electronic_fee,
            'City' => $request->City,
        ]);

        return redirect()->route('tuition')->with('success', 'شهریه با موفقیت اضافه شد!');
    }

}





