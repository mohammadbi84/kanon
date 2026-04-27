<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TuitionImport as ImportsTuitionImport;
use App\Models\Tuition;
use App\Models\Profession;
use App\Models\ProfessionTuition;
use App\Models\TuitionImport;
use App\Models\TuitionImportLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TuitionProfessionController extends Controller
{
    public function index(Tuition $tuition)
    {
        if (request()->ajax()) {
            $query = Profession::with([
                'field' => function ($q) {
                    $q->orderBy('name');
                },
                'field.cluster' => function ($q) {
                    $q->orderBy('name');
                },
                'field.cluster.category',
                'kardanesh',
                'jobtype',
            ])
                ->join('fields', 'professions.field_id', '=', 'fields.id')
                ->join('clusters', 'fields.cluster_id', '=', 'clusters.id')
                // left join به جدول واسط برای گرفتن نرخ شهریه مربوط به این دوره
                ->leftJoin('profession_tuitions', function ($join) use ($tuition) {
                    $join->on('professions.id', '=', 'profession_tuitions.profession_id')
                        ->where('profession_tuitions.tuition_id', '=', $tuition->id);
                })
                ->orderBy('clusters.name')
                ->orderBy('fields.name')
                ->orderBy('professions.name')
                ->select(
                    'professions.*',
                    // اضافه کردن فیلد نرخ شهریه (اگر null باشد 0 برگردان)
                    DB::raw('COALESCE(profession_tuitions.active) as tuition_active'),
                    DB::raw('COALESCE(profession_tuitions.price_in_person) as price_in_person'),
                    DB::raw('COALESCE(profession_tuitions.price_virtual) as price_virtual'),
                    DB::raw('COALESCE(profession_tuitions.price_online) as price_online')
                );

            $professions = $query->get();

            // Log::info($professions->toArray());

            return response()->json([
                'data' => $professions
            ]);
        }

        return view('admin.tuitions.professions', compact('tuition'));
    }

    public function prices(Request $request, Tuition $tuition)
    {
        $prices = $request->input('prices', []);

        foreach ($prices as $priceData) {
            $tuition->professions()->syncWithoutDetaching([
                $priceData['profession_id'] => [
                    'price_in_person' => $priceData['price_in_person'],
                    'price_virtual' => $priceData['price_virtual'],
                    'price_online' => $priceData['price_online'],
                ]
            ]);
        }

        return response()->json(['message' => 'Prices saved successfully.']);
    }

    public function update(Request $request, Tuition $tuition)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.*.profession_id' => 'required|exists:professions,id',
            'data.*.amount_in_person' => 'nullable|numeric|min:0',
            'data.*.amount_online' => 'nullable|numeric|min:0',
            'data.*.amount_virtual' => 'nullable|numeric|min:0',
        ], [
            'data.required' => 'هیچ اطلاعاتی ارسال نشده است.',
        ]);

        foreach ($validated['data'] as $item) {
            $tuition->professions()->syncWithoutDetaching([
                $item['profession_id'] => [
                    'price_in_person' => $item['amount_in_person'] ?? 0,
                    'price_online' => $item['amount_online'] ?? 0,
                    'price_virtual' => $item['amount_virtual'] ?? 0,
                ]
            ]);
        }

        return response()->json(['success' => true, 'message' => 'همه مبالغ با موفقیت ذخیره شدند.']);
    }

    public function bulkToggle(Request $request, Tuition $tuition)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'
            ], 400);
        }

        $professions = ProfessionTuition::whereIn('id', $ids)->where('tuition_id', $tuition->id)->get();
        if ($professions->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'لطفا ابتدا شهریه را ذخیره و سپس برای تغییر وضعیت اقدام کنید.'
            ], 400);
        }
        foreach ($professions as $key => $profession) {
            $profession->update([
                'active' => $request->status,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'وضعیت انتشار شهریه ها با موفقیت تغییر کرد.'
        ]);
    }

    public function toggle(Tuition $tuition, $professionTuition)
    {
        $professionTuition = ProfessionTuition::where('tuition_id', $tuition->id)->where('profession_id', $professionTuition)->first();

        if (!$professionTuition) {
            return response()->json([
                'success' => false,
                'message' => 'لطفا ابتدا شهریه را ذخیره و سپس برای تغییر وضعیت اقدام کنید.'
            ], 400);
        }

        $professionTuition->update([
            'active' => !$professionTuition->active
        ]);
        if ($professionTuition->active) {
            return response()->json(['success' => true, 'message' => 'شهریه با موفقیت منتشر شد.']);
        }
        return response()->json(['success' => true, 'message' => 'شهریه با موفقیت از حالت انتشار خارج شد.']);
    }

    public function uploadExcel(Request $request, Tuition $tuition)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);
        // return ('دریافت شد');

        $batchId = (string)Str::uuid();
        $import = TuitionImport::create([
            'tuition_id' => $tuition->id,
            'batch_id' => $batchId,
            'file_name' => $request->file('file')->getClientOriginalName(),
        ]);
        session()->put('import_id', $import->id);
        session()->put('tuition_id', $tuition->id);

        try {
            // استفاده از Excel::import بدون تعیین صریح نوع فایل
            // پکیج خودش سعی می‌کنه نوع فایل رو تشخیص بده
            Excel::import(new ImportsTuitionImport, $request->file('file'));

            $logs = $import->logs()->where('success', true)->get();
            return response()->json(['success' => true, 'message' => 'حرفه ها با موفقیت اضافه شد', 'logs' => $logs]);
        } catch (\Exception $e) {
            // لاگ کردن خطا برای اشکال‌زدایی
            Log::error('Excel import error: ' . $e->getMessage(), ['file_path' => $request->file('file')->getPathname()]);
            // برگرداندن پیام خطا به کاربر
            return back()->withErrors(['file' => 'خطا در پردازش فایل اکسل: ' . $e->getMessage()]);
        }
        Excel::import(new ImportsTuitionImport, $request->file('file'));

        return back()->with('success', 'حرفه ها با موفقیت وارد شد.');
    }

    // لیست همه آپلودها (برا نمایش در مدال)
    public function imports(Tuition $tuition)
    {
        $imports = TuitionImport::where('tuition_id', $tuition->id)->with('logs')->latest()->get(['id', 'file_name', 'created_at']);
        return response()->json($imports);
    }

    // لاگ‌های هر آپلود خاص
    public function import_log($id,$tuition)
    {
        // dd('hiiiii');
        $logs = TuitionImportLog::where('tuition_import_id',$tuition)
            ->orderBy('success')
            ->get(['row_number', 'error_message', 'data', 'success']);
        return response()->json($logs);
    }

    // لیست همه آپلودها (برا نمایش در مدال)
    public function print($id, Request $request, $tuition)
    {
        // return $tuition;
        $import = TuitionImport::findOrFail($tuition);
        if ($request->status == 'all') {
            $logs = $import->logs;
        } elseif ($request->status == 1) {
            $logs = $import->logs()->where('success', true);
        } else {
            $logs = $import->logs()->where('success', false);
        }
        return view('admin.tuitions.printLogs', compact('logs'));
    }
}
