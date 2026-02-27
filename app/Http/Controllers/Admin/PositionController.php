<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $positions = Position::latest()->get();
            return response()->json(['data' => $positions]);
        }
        $positions = Position::latest()->paginate(20);

        return view('admin.positions.index', compact('positions'));
    }

    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'max_slots' => 'required|integer',
            'settings' => 'nullable|array',
        ]);

        $position->update([
            'name' => $validated['name'],
            'max_slots' => $validated['max_slots'],
            'settings' => $validated['settings'] ?? [],
        ]);

        return redirect()
            ->route('admin.positions.index')
            ->with('success', 'بخش با موفقیت بروزرسانی شد.');
    }

    public function toggle(Position $position)
    {
        $position->update([
            'is_active' => !$position->is_active
        ]);
        return response()->json(['success' => 'وضعیت با موفقیت تغییر کرد.']);
    }

    public function bulkToggle(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'
            ], 400);
        }

        $positions = Position::whereIn('id', $ids)->get();
        foreach ($positions as $key => $position) {
            $position->update([
                'is_active' => $request->status,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'وضعیت ها با موفقیت تغییر کرد.'
        ]);
    }
}
