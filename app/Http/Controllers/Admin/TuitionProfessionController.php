<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use App\Models\Profession;
use Illuminate\Http\Request;

class TuitionProfessionController extends Controller
{
    public function index(Tuition $tuition)
    {
        // دریافت لیست حرفه‌ها به همراه مبلغ‌ها از pivot table
        $professions = Profession::with('tuitions')->get();

        return view('admin.tuitions.professions', compact('tuition', 'professions'));
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
}
