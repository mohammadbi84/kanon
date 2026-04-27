<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademyCreateRequest;
use App\Models\Academy;
use App\Models\City;
use App\Models\Cluster;
use App\Models\Field;
use App\Models\File;
use App\Models\Profession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class AcademyController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $academies = Academy::with('creator')->latest()->orderBy('name')->where('status', '!=', 'pending')->get();
            foreach ($academies as $academy) {
                if ($academy->export_end) {
                    // تبدیل تاریخ شمسی به معادل میلادی (Carbon)
                    $expireDate = Jalalian::fromFormat('Y-m-d', $academy->export_end)->toCarbon();
                    $now = Carbon::now()->startOfDay();
                    $expireDateStart = $expireDate->copy()->startOfDay();

                    // اختلاف روز با علامت (مثبت: آینده، منفی: گذشته)
                    $diffDays = $now->diffInDays($expireDateStart, false);

                    // تنظیم وضعیت بر اساس مقدار $diffDays
                    if ($diffDays < 0) {
                        $academy->sodor_end_status = 'منقضی شده';
                    } elseif ($diffDays == 0) {
                        $academy->sodor_end_status = 'امروز';
                    } else {
                        $academy->sodor_end_status = 'فعال';
                    }

                    // تعداد روز باقی‌مانده (می‌تواند منفی باشد؛ در صورت نیاز صفر نمایش دهید)
                    $academy->sodor_end_remain = $diffDays;
                } else {
                    $academy->sodor_end_status = 'نامشخص';
                    $academy->sodor_end_remain = null;
                }
            }
            return response()->json(['data' => $academies]);
        }
        $academies = Academy::latest()->where('status', '!=', 'pending')->get();
        return view('admin.academy.index', compact('academies'));
    }
    public function pending()
    {
        if (request()->ajax()) {
            $academies = Academy::latest()->where('status', '==', 'pending')->get();
            return response()->json(['data' => $academies]);
        }
        $academies = Academy::latest()->where('status', '==', 'pending')->get();
        return view('admin.academy.pendings', compact('academies'));
    }

    public function create()
    {
        $fields = Field::all();
        $clusters = Cluster::all();

        $states = City::whereNull('parent')->get();
        return view('admin.academy.create', compact('fields', 'clusters', 'states'));
    }

    public function store(AcademyCreateRequest $request)
    {

        $data = $request->all();

        $national_code = str_replace('-', '', $request->national_code);
        $postal_code = str_replace('-', '', $request->postal_code);

        $data['national_code'] = $national_code;
        $data['postal_code'] = $postal_code;
        $data['tabsare_34'] = $request->tabsare_34 ? true : false;


        if (isset($request->file_tasis_front)) {
            $license_front = $request->file_tasis_front->store('/licenses', 'public');
        }
        if (isset($request->file_tasis_back)) {
            $license_back = $request->file_tasis_back->store('/licenses', 'public');
        }
        $data['license_file_front'] = $license_front;
        $data['license_file_back'] = $license_back;

        $data['phone'] = $request->phone_prefix . $request->phone;
        $data['fax'] = $request->fax_prefix . $request->fax;


        $data['founder_phone'] = $data['founder_phone'] ? $request->founder_phone_prefix . $request->founder_phone : $request->founder_phone_prefix2  . $request->founder_phone2;
        $data['founder_mobile'] = $data['founder_mobile'] ? $request->founder_mobile : $request->founder_mobile2;
        $data['founder_email'] = $data['founder_email'] ? $request->founder_email : $request->founder_email2;
        $data['founder_address'] = $data['founder_address'] ? $request->founder_address : $request->founder_address2;

        $data['creator_id'] = auth()->id();



        $user = User::where('mobile', $request->founder_mobile ?? $request->founder_mobile2)->first();
        if (!$user) {
            $user = User::create([
                'name' => $request->natural_name ?? $request->legal_manager,
                'family' => $request->natural_family,
                'mobile' => $request->founder_mobile ?? $request->founder_mobile2,
            ]);
        }

        $user->syncRoles(['manager']);

        $data['manager_id'] = $user->id;
        $data['slug'] = Str::slug($request->name);
        $data['status'] = 'approved';

        $academy = Academy::create($data);


        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $index => $singleFile) {
                $path = $singleFile->store('/fields', 'public');
                $file = $academy->files()->create([
                    'url' => $path,
                    'type' => 'image',
                    'status' => 1,
                ]);
            }
        }

        if (isset($request->herfe)) {
            foreach ($request->herfe as $item) {
                $academy->fields()->attach($item);
            }
        }


        return redirect()->route('admin.academy.index')->with('success', 'آموزشگاه با موفقیت اضافه شد');
    }

    public function edit($id)
    {
        $academy = Academy::findOrFail($id);

        $fields = Field::all();
        $clusters = Cluster::all();
        $states = City::whereNull('parent')->get();
        return view('admin.academy.edit', compact('academy','fields', 'clusters', 'states'));
    }

    public function update($id, Request $request)
    {
        $academy = Academy::findOrFail($id);
        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $academy->update($validator->validated());
        return redirect()->route('admin.academy.index')->with('success', 'آموزشگاه با موفقیت ویرایش شد.');
    }

    public function toggle($id)
    {
        $academy = Academy::findOrFail($id);
        if ($academy->status == 'approved') {
            $academy->status = 'suspended';
            $academy->save();
        } else {
            $academy->status = 'approved';
            $academy->save();
        }
        return response()->json(['success' => true, 'message' => 'وضعیت آموزشگاه با موفقیت تغییر کرد.']);
    }

    public function bulkToggle(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ آی‌دی‌ای ارسال نشده است.'], 400);
        }

        $academies = Academy::whereIn('id', $ids)->get();
        foreach ($academies as $key => $academy) {
            if ($request->status) {
                $academy->status = 'approved';
                $academy->save();
            } else {
                $academy->status = 'suspended';
                $academy->save();
            }
        }
        return response()->json(['success' => true, 'message' => 'وضعیت آموزشگاه ها با موفقیت تغییر کرد..']);
    }

    public function delete($id)
    {
        $academy = Academy::findOrFail($id);

        // حذف عکس ها
        foreach ($academy->files as $key => $file) {
            if (File::exists($file->id)) {
                if (file_exists('/files/' . $file->url)) {
                    unlink('/files/' . $file->url);
                }
                $file->delete();
            }
        }
        if (file_exists('/files/' . $academy->license_file_front)) {
            unlink('/files/' . $academy->license_file_front);
        }
        if (file_exists('/files/' . $academy->license_file_back)) {
            unlink('/files/' . $academy->license_file_back);
        }

        // حذف ارتباطات
        $academy->fields()->detach();

        // حذف کاربر
        $academy->manager->delete();

        $academy->delete();



        return response()->json(['success' => true, 'message' => 'آموزشگاه با موفقیت حذف شد.']);
    }

    public function show(Academy $academy)
    {
        return view("admin.academy.show", compact('academy'));
    }
}
