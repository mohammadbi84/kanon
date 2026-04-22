<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use App\Models\Profession;
use App\Models\ProfessionTuition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                    DB::raw('COALESCE(profession_tuitions.price_in_person, 0) as price_in_person'),
                    DB::raw('COALESCE(profession_tuitions.price_virtual, 0) as price_virtual'),
                    DB::raw('COALESCE(profession_tuitions.price_online, 0) as price_online')
                );

            $professions = $query->get();

            Log::info($professions);

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
}
