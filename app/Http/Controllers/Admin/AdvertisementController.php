<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use App\Models\Advertisement;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    public function index()
    {
        $positions = Position::where('is_active', true)->get();
        return view('admin.advertisement.index', compact('positions'));
    }

    public function advertisements(Position $position)
    {
        if (request()->ajax()) {
            $advertisements = Advertisement::with('academy')->where('position_id', $position->id)
                ->whereIn('status', ['pending_review', 'approved', 'active'])->get();
            return response()->json(['data' => $advertisements]);
        }
        // return $advertisements;
        $academies = Academy::where('status', 'approved')->pluck('name');
        return view('admin.advertisement.advertisement', compact('position', 'academies'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academy'       => 'required',
            'position_id'       => 'required',
            'title'       => 'required|string|max:255',
            'description'        => 'string|required_if:position_id,[1,2,4,5]',
            'image'      => 'string|required_if:position_id,[1,3,4,5]',
            'video'      => 'string|required_if:position_id,3',
            'duration'      => 'integer|required_if:position_id,[1,2,3]',
        ], [
            'title.required'      => 'عنوان الزامی است.',
            'description.required'       => 'متن الزامی است.',
            'image.required'     => 'عکس آگهی الزامی است.',
            'video.required'     => 'ویدیو آگهی الزامی است.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $data = $validator->validated();

        $data['creator_id'] = auth()->id();

        if ($data['academy'] != 'ادمین') {
            $academy = Academy::where('status', 'approved')->where('name', 'like', '%' . $data['academy'] . '%')->first();
            $data['academy_id'] = $academy?->id ?? null;
        }

        Advertisement::create($data);

        return redirect()->back()->with('success', 'آگهی با موفقیت ساخته شد.');
    }

    public function toggle($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        if ($advertisement->status == 'approved') {
            $advertisement->status = 'rejected';
            $advertisement->save();
        } else {
            $advertisement->status = 'approved';
            $advertisement->save();
        }
        return response()->json(['success' => 'وضعیت آگهی با موفقیت تغییر کرد.']);
    }
}
