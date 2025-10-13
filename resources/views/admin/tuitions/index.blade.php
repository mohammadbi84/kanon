@extends('admin.layout.master')

@section('head')
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <div class="head-label p-3"></div>

            {{-- فرم افزودن شهریه --}}
            <form action="{{ route('admin.tuitions.store') }}" method="post"
                  class="add-new-record pt-0 row g-2 mt-3 px-3" id="form-add-new-record">
                @csrf

                {{-- عنوان شهریه --}}
                <div class="col-sm-12">
                    <label class="form-label" for="title">عنوان شهریه</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-credit-card"></i></span>
                        <input type="text" id="title" class="form-control" name="title"
                               placeholder="مثلاً شهریه تابستان ۱۴۰۴" required>
                    </div>
                </div>

                {{-- انتخاب شهر --}}
                <div class="col-sm-12 mt-3">
                    <label class="form-label" for="city_id">انتخاب شهر</label>
                    <select id="city_id" name="city_id" class="form-select select2" required>
                        <option value="" disabled selected>انتخاب کنید...</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->title }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- بازه زمانی --}}
                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="start_date">تاریخ شروع</label>
                    <input type="date" id="start_date" name="start_date" class="form-control">
                </div>

                <div class="col-sm-6 mt-3">
                    <label class="form-label" for="end_date">تاریخ پایان</label>
                    <input type="date" id="end_date" name="end_date" class="form-control">
                </div>

                {{-- دکمه ثبت --}}
                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت شهریه</button>
                </div>
            </form>

            {{-- جدول شهریه‌ها --}}
            <table class="dt-select-table tuitions table mt-4">
                <thead>
                    <tr></tr>
                </thead>
            </table>

            <div id="bulk-actions">
                <button id="bulk-delete" class="btn btn-danger" disabled>حذف انتخابی‌ها</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
