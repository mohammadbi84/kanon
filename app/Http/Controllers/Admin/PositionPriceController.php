<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\PositionPrice;
use Illuminate\Http\Request;

class PositionPriceController extends Controller
{
    public function index(Position $position)
    {
        if (request()->ajax()) {
            $prices = $position->prices()->orderBy('start_date')->get();
            return response()->json(['data' => $prices]);
        }
        $prices = $position->prices()->orderBy('start_date')->get();
        return view('admin.position_prices.index', compact('position', 'prices'));
    }

    public function store(Request $request, Position $position)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price_per_day' => 'required|numeric|min:0',
            'price_per_second' => 'nullable|numeric|min:0',
        ]);

        // 🚨 چک overlap
        $hasOverlap = $position->prices()
            ->where(function ($query) use ($validated) {
                $query->whereDate('start_date', '<=', $validated['end_date'])
                    ->whereDate('end_date', '>=', $validated['start_date']);
            })
            ->exists();

        if ($hasOverlap) {
            return response()->json([
                'success' => false,
                'message' => 'باین بازه زمانی با یک بازه دیگر تداخل دارد.'
            ]);
        }

        $position->prices()->create($validated);

        return response()->json([
                'success' => true,
                'message' => 'بازه قیمتی با موفقیت ساخته شد.'
            ]);
    }
}
