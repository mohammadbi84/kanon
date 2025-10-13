@extends('admin.layout.master')

@section('head')
    <title>ویرایش شهریه</title>
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">ویرایش شهریه: {{ $tuition->title }}</h5>

            <form action="{{ route('admin.tuitions.update', $tuition->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                {{-- نام شهریه --}}
                <div class="col-md-6">
                    <label for="title" class="form-label">عنوان شهریه</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', $tuition->title) }}" placeholder="مثلاً شهریه تابستان ۱۴۰۴" required>
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- شهر --}}
                <div class="col-md-6">
                    <label for="city_id" class="form-label">شهر</label>
                    <select name="city_id" id="city_id" class="form-select" required>
                        <option value="">انتخاب کنید...</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}"
                                {{ old('city_id', $tuition->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- تاریخ شروع --}}
                <div class="col-md-6">
                    <label for="start_date" class="form-label">تاریخ شروع</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ old('start_date', $tuition->start_date) }}" required>
                    @error('start_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- تاریخ پایان --}}
                <div class="col-md-6">
                    <label for="end_date" class="form-label">تاریخ پایان</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ old('end_date', $tuition->end_date) }}" required>
                    @error('end_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- دکمه‌ها --}}
                <div class="col-12 mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.tuitions.index') }}" class="btn btn-secondary">بازگشت</a>
                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const start_date = document.querySelector('#start_date');
        if (start_date) {
            start_date.flatpickr({
                monthSelectorType: 'static',
                locale: 'fa',
                altInput: true,
                altFormat: 'Y/m/d',
                disableMobile: true
            });
        }
        const end_date = document.querySelector('#end_date');
        if (end_date) {
            end_date.flatpickr({
                monthSelectorType: 'static',
                locale: 'fa',
                altInput: true,
                altFormat: 'Y/m/d',
                disableMobile: true
            });
        }
    </script>
@endsection
