<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profession;
use App\Models\Field;
use App\Models\Jobtype;
use App\Models\Kardanesh;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProfessionController extends Controller
{
    // 📄 لیست حرفه‌ها (با DataTables)
    public function index(Request $request)
    {
        $fieldId = $request->query('field_id'); // اگر از صفحه خوشه‌ها اومده
        if ($fieldId and !Field::find($fieldId)) {
            abort('404');
        }

        if (request()->ajax()) {
            $fields = null;
            if ($fieldId) {
                $professions = Profession::with('field', 'kardanesh', 'jobtype')
                    // ->when($fieldId, fn($q) => $q->where('field_id', $fieldId))
                    ->latest()
                    ->get();
            } else {
                $fields = Field::all();
                $professions = Profession::with('field', 'kardanesh', 'jobtype')->latest()->get();
            }
            return response()->json(['data' => $professions, 'fields' => $fields]);
        }

        // رشته‌ها برای فرم ایجاد
        $fields = Field::all();
        $kardaneshes = Kardanesh::all();
        $jobtypes = Jobtype::all();
        $fieldId = $request->get('field_id');
        $field = [];
        if ($fieldId) {
            $field = Field::find($fieldId);
        }

        return view('admin.professions.index', compact('fields', 'kardaneshes', 'jobtypes', 'fieldId', 'field'));
    }

    // 🆕 افزودن حرفه جدید
    public function store(Request $request)
    {
        // قوانین اعتبارسنجی
        $rules = [
            'field_id' => 'required|exists:fields,id',
            'name' => 'required|string|max:255',
            'old_standard_code' => 'required|string|max:255',
            'new_standard_code' => 'required|string|max:255|unique:professions,new_standard_code',
            'theory_hour' => 'nullable|integer|min:0',
            'theory_minute' => 'nullable|integer|min:0|max:59',
            'practice_hour' => 'nullable|integer|min:0',
            'practice_minute' => 'nullable|integer|min:0|max:59',
            'project_hour' => 'nullable|integer|min:0',
            'project_minute' => 'nullable|integer|min:0|max:59',
            'internship_hour' => 'nullable|integer|min:0',
            'internship_minute' => 'nullable|integer|min:0|max:59',
            'total_hour' => 'nullable|integer|min:0',
            'total_minute' => 'nullable|integer|min:0|max:59',
            'education_level' => 'nullable|string|max:255',
            'kardanesh_id' => 'nullable|exists:kardaneshes,id',
            'jobtype_id' => 'nullable|exists:jobtypes,id',
            'trainer_qualification' => 'nullable|string|max:255',
            'draft_date' => 'nullable|date',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'standard_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];

        // پیام‌های فارسی برای خطاها
        $messages = [
            'required' => 'فیلد :attribute الزامی است.',
            'string' => 'فیلد :attribute باید متن باشد.',
            'max' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
            'integer' => 'فیلد :attribute باید عدد باشد.',
            'min' => 'فیلد :attribute باید حداقل :min باشد.',
            'exists' => ':attribute انتخاب شده معتبر نیست.',
            'date' => 'فیلد :attribute باید تاریخ معتبر باشد.',
            'image' => 'فیلد :attribute باید یک تصویر معتبر باشد.',
            'file' => 'فیلد :attribute باید یک فایل معتبر باشد.',
            'mimes' => 'فیلد :attribute باید از نوع: :values باشد.',
            'image_path.max' => 'حجم تصویر نباید بیشتر از 2 مگابایت باشد.',
            'standard_file.max' => 'حجم فایل استاندارد نباید بیشتر از 5 مگابایت باشد.',
            'theory_minute.max' => 'دقیقه نظری نمی‌تواند بیشتر از 59 باشد.',
            'practice_minute.max' => 'دقیقه عملی نمی‌تواند بیشتر از 59 باشد.',
            'project_minute.max' => 'دقیقه پروژه نمی‌تواند بیشتر از 59 باشد.',
            'internship_minute.max' => 'دقیقه کارورزی نمی‌تواند بیشتر از 59 باشد.',
            'total_minute.max' => 'دقیقه کل نمی‌تواند بیشتر از 59 باشد.',
        ];

        // نام‌های فارسی برای فیلدها
        $attributes = [
            'field_id' => 'رشته',
            'name' => 'نام حرفه',
            'old_standard_code' => 'کد استاندارد قدیم',
            'new_standard_code' => 'کد استاندارد جدید',
            'theory_hour' => 'ساعت نظری',
            'theory_minute' => 'دقیقه نظری',
            'practice_hour' => 'ساعت عملی',
            'practice_minute' => 'دقیقه عملی',
            'project_hour' => 'ساعت پروژه',
            'project_minute' => 'دقیقه پروژه',
            'internship_hour' => 'ساعت کارورزی',
            'internship_minute' => 'دقیقه کارورزی',
            'total_hour' => 'ساعت کل',
            'total_minute' => 'دقیقه کل',
            'education_level' => 'حداقل تحصیلات',
            'kardanesh_id' => 'نوع کاردانش',
            'jobtype_id' => 'نوع شغل',
            'trainer_qualification' => 'صلاحیت مربی',
            'draft_date' => 'تاریخ تدوین',
            'image_path' => 'تصویر',
            'standard_file' => 'فایل استاندارد',
        ];
        // اعتبارسنجی داده‌ها
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        if (Profession::where('field_id', $request->field_id)->where('name', $request->name)->first()) {
            return response()->json(['success' => false, 'message' => 'حرفه با این نام و رشته وجود دارد.']);
        }

        try {
            $data = $validator->validated();

            // مدیریت آپلود تصویر
            if ($request->hasFile('image_path')) {
                $imagePath = 'uploads/professions/images/';
                $file = $request->file('image_path');
                $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/professions/images', $pathName);

                $data['image_path'] = $imagePath . $pathName;
            }

            // مدیریت آپلود فایل استاندارد
            if ($request->hasFile('standard_file')) {
                $filePath = 'uploads/professions/files/';
                $file = $request->file('standard_file');
                $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/professions/files', $pathName);

                $data['standard_file'] = $filePath . $pathName;
            }

            // محاسبه زمان کل اگر خالی است
            if (empty($data['total_hour']) && empty($data['total_minute'])) {
                $totalMinutes = 0;

                // محاسبه از زمان نظری
                if (!empty($data['theory_hour']) || !empty($data['theory_minute'])) {
                    $totalMinutes += ($data['theory_hour'] ?? 0) * 60 + ($data['theory_minute'] ?? 0);
                }

                // محاسبه از زمان عملی
                if (!empty($data['practice_hour']) || !empty($data['practice_minute'])) {
                    $totalMinutes += ($data['practice_hour'] ?? 0) * 60 + ($data['practice_minute'] ?? 0);
                }

                // محاسبه از زمان پروژه
                if (!empty($data['project_hour']) || !empty($data['project_minute'])) {
                    $totalMinutes += ($data['project_hour'] ?? 0) * 60 + ($data['project_minute'] ?? 0);
                }

                // محاسبه از زمان کارورزی
                if (!empty($data['internship_hour']) || !empty($data['internship_minute'])) {
                    $totalMinutes += ($data['internship_hour'] ?? 0) * 60 + ($data['internship_minute'] ?? 0);
                }

                if ($totalMinutes > 0) {
                    $data['total_hour'] = floor($totalMinutes / 60);
                    $data['total_minute'] = $totalMinutes % 60;
                }
            }

            // ایجاد حرفه جدید
            $profession = Profession::create($data);

            return response()->json([
                'success' => true,
                'message' => 'حرفه با موفقیت ایجاد شد.',
                'data' => $profession
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ایجاد حرفه',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ✏️ ویرایش حرفه
    public function edit($id)
    {
        $profession = Profession::findOrFail($id);
        $fields = Field::all();
        $kardaneshes = Kardanesh::all();
        $jobtypes = Jobtype::all();
        return view('admin.professions.edit', compact('profession', 'fields', 'kardaneshes', 'jobtypes'));
    }

    // 🔁 آپدیت حرفه
    public function update(Request $request, $id)
    {
        // قوانین اعتبارسنجی
        $rules = [
            'field_id' => 'required|exists:fields,id',
            'name' => 'required|string|max:255',
            'old_standard_code' => 'required|string|max:255',
            'new_standard_code' => 'required|string|max:255',
            'theory_hour' => 'nullable|integer|min:0',
            'theory_minute' => 'nullable|integer|min:0|max:59',
            'practice_hour' => 'nullable|integer|min:0',
            'practice_minute' => 'nullable|integer|min:0|max:59',
            'project_hour' => 'nullable|integer|min:0',
            'project_minute' => 'nullable|integer|min:0|max:59',
            'internship_hour' => 'nullable|integer|min:0',
            'internship_minute' => 'nullable|integer|min:0|max:59',
            'total_hour' => 'nullable|integer|min:0',
            'total_minute' => 'nullable|integer|min:0|max:59',
            'education_level' => 'nullable|string|max:255',
            'kardanesh_id' => 'nullable|exists:kardaneshes,id',
            'jobtype_id' => 'nullable|exists:jobtypes,id',
            'trainer_qualification' => 'nullable|string|max:255',
            'draft_date' => 'nullable|date',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'standard_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];

        // پیام‌های فارسی برای خطاها
        $messages = [
            'required' => 'فیلد :attribute الزامی است.',
            'string' => 'فیلد :attribute باید متن باشد.',
            'max' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
            'integer' => 'فیلد :attribute باید عدد باشد.',
            'min' => 'فیلد :attribute باید حداقل :min باشد.',
            'exists' => ':attribute انتخاب شده معتبر نیست.',
            'date' => 'فیلد :attribute باید تاریخ معتبر باشد.',
            'image' => 'فیلد :attribute باید یک تصویر معتبر باشد.',
            'file' => 'فیلد :attribute باید یک فایل معتبر باشد.',
            'mimes' => 'فیلد :attribute باید از نوع: :values باشد.',
            'image_path.max' => 'حجم تصویر نباید بیشتر از 2 مگابایت باشد.',
            'standard_file.max' => 'حجم فایل استاندارد نباید بیشتر از 5 مگابایت باشد.',
            'theory_minute.max' => 'دقیقه نظری نمی‌تواند بیشتر از 59 باشد.',
            'practice_minute.max' => 'دقیقه عملی نمی‌تواند بیشتر از 59 باشد.',
            'project_minute.max' => 'دقیقه پروژه نمی‌تواند بیشتر از 59 باشد.',
            'internship_minute.max' => 'دقیقه کارورزی نمی‌تواند بیشتر از 59 باشد.',
            'total_minute.max' => 'دقیقه کل نمی‌تواند بیشتر از 59 باشد.',
        ];

        // نام‌های فارسی برای فیلدها
        $attributes = [
            'field_id' => 'رشته',
            'name' => 'نام حرفه',
            'old_standard_code' => 'کد استاندارد قدیم',
            'new_standard_code' => 'کد استاندارد جدید',
            'theory_hour' => 'ساعت نظری',
            'theory_minute' => 'دقیقه نظری',
            'practice_hour' => 'ساعت عملی',
            'practice_minute' => 'دقیقه عملی',
            'project_hour' => 'ساعت پروژه',
            'project_minute' => 'دقیقه پروژه',
            'internship_hour' => 'ساعت کارورزی',
            'internship_minute' => 'دقیقه کارورزی',
            'total_hour' => 'ساعت کل',
            'total_minute' => 'دقیقه کل',
            'education_level' => 'حداقل تحصیلات',
            'kardanesh_id' => 'نوع کاردانش',
            'jobtype_id' => 'نوع شغل',
            'trainer_qualification' => 'صلاحیت مربی',
            'draft_date' => 'تاریخ تدوین',
            'image_path' => 'تصویر',
            'standard_file' => 'فایل استاندارد',
        ];

        // اعتبارسنجی داده‌ها
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $profession = Profession::findOrFail($id);

            $data = $validator->validated();

            // مدیریت آپلود تصویر
            if ($request->hasFile('image_path')) {
                $imagePath = 'uploads/professions/images/';
                $file = $request->file('image_path');
                $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/professions/images', $pathName);

                $data['image_path'] = $imagePath . $pathName;
            } else {
                $data['image_path'] = null; // اگر فایلی آپلود نشده، مقدار آن را حذف کن
            }

            // مدیریت آپلود فایل استاندارد
            if ($request->hasFile('standard_file')) {
                $filePath = 'uploads/professions/files/';
                $file = $request->file('standard_file');
                $pathName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move('uploads/professions/files', $pathName);

                $data['standard_file'] = $filePath . $pathName;
            } else {
                $data['standard_file'] = null; // اگر فایلی آپلود نشده، مقدار آن را حذف کن
            }

            // محاسبه زمان کل اگر خالی است
            if (empty($data['total_hour']) && empty($data['total_minute'])) {
                $totalMinutes = 0;

                // محاسبه از زمان نظری
                if (!empty($data['theory_hour']) || !empty($data['theory_minute'])) {
                    $totalMinutes += ($data['theory_hour'] ?? 0) * 60 + ($data['theory_minute'] ?? 0);
                }

                // محاسبه از زمان عملی
                if (!empty($data['practice_hour']) || !empty($data['practice_minute'])) {
                    $totalMinutes += ($data['practice_hour'] ?? 0) * 60 + ($data['practice_minute'] ?? 0);
                }

                // محاسبه از زمان پروژه
                if (!empty($data['project_hour']) || !empty($data['project_minute'])) {
                    $totalMinutes += ($data['project_hour'] ?? 0) * 60 + ($data['project_minute'] ?? 0);
                }

                // محاسبه از زمان کارورزی
                if (!empty($data['internship_hour']) || !empty($data['internship_minute'])) {
                    $totalMinutes += ($data['internship_hour'] ?? 0) * 60 + ($data['internship_minute'] ?? 0);
                }

                if ($totalMinutes > 0) {
                    $data['total_hour'] = floor($totalMinutes / 60);
                    $data['total_minute'] = $totalMinutes % 60;
                }
            }

            // ایجاد حرفه جدید
            $profession = $profession->update($data);

            return redirect()->route('admin.professions.index')->with('success', 'حرفه با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'خطا در ویرایش حرفه: ' . $e->getMessage()])->withInput();
        }
    }

    // 🗑️ حذف تکی
    public function delete($id)
    {
        $profession = Profession::findOrFail($id);
        $profession->delete();

        return response()->json(['success' => true, 'message' => 'حرفه با موفقیت حذف شد']);
    }

    // 🗑️ حذف گروهی
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        Profession::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'حرفه ها با موفقیت حذف شدند.']);
    }
}
