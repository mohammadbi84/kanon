<?php

namespace App\Http\Controllers;

use App\Models\SanadHerfe;
use App\Models\TuitionHerfe;
use App\Models\TuitionSanad;
use Illuminate\Http\Request;

class TuitionSanadController extends Controller
{
    public function updateAll(Request $request)
    {
        try {
            foreach ($request->in_person_fee as $tuitionId => $fee) {
                $tuition = SanadHerfe::find($tuitionId);
                $tuition->in_person_fee = str_replace(',', '', $fee); // حذف کاما
                $tuition->online_fee = str_replace(',', '', $request->online_fee[$tuitionId]);
                $tuition->electronic_fee = str_replace(',', '', $request->electronic_fee[$tuitionId]);
                $tuition->save();
            }
            return response()->json(['message' => 'مبالغ با موفقیت بروزرسانی شد']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'خطا در بروزرسانی داده‌ها، لطفا دوباره تلاش کنید.'], 500);
        }
    }

    public function index()
    {
        $tuitionHerfes = TuitionSanad::with('sanad')->get();
        $herfes = SanadHerfe::all();
        return view('dashboard.tuition_sanad.index', compact('tuitionHerfes', 'herfes'));
    }

    public function create()
    {
        $herfes = SanadHerfe::all();
        return view('dashboard.tuition_sanad.create', compact('herfes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sanad_id' => 'required',
            'standard_code' => 'required|string',
            'year' => 'required',
            'duration' => 'required|string',
            'in_person_fee' => 'required|numeric',
            'online_fee' => 'required|numeric',
            'electronic_fee' => 'required|numeric',
            'City' => 'required',

        ]);

        $check = TuitionSanad::where('sanad_id', $request->sanad_id)->where('year', $request->year)->first();
        if ($check) {
            return redirect()->route('tuition_sanad.index')->with('error', 'برای این سند نرخ شهریه تعریف شده');
        }
        TuitionSanad::create($request->all());

        return redirect()->route('tuition_sanad.index')->with('success', 'نرخ شهریه با موفقیت اضافه شد.');
    }

    public function edit(Tuitionsanad $tuition)
    {
        $herfes = TuitionSanad::all();
        return view('dashboard.tuition_sanad.edit', compact('tuition', 'herfes'));
    }

    public function update(Request $request, Tuitionsanad $tuition)
    {
        $request->validate([
            'sanad_id' => 'required|exists:herfes,id',
            'standard_code' => 'required|string',
            'year' => 'required',
            'duration' => 'required|string',
            'tuition_fee' => 'required|numeric',
            'in_person_fee' => 'required|numeric',
            'online_fee' => 'required|numeric',
            'electronic_fee' => 'required|numeric',
        ]);

        $tuition->update($request->all());

        return redirect()->route('tuition_sanad.index')->with('success', 'نرخ شهریه با موفقیت ویرایش شد.');
    }

    public function delete(TuitionSanad $tuition)
    {
        $tuition->delete();
        return redirect()->route('tuition_sanad.index')->with('success', 'نرخ شهریه حذف شد.');
    }
}
