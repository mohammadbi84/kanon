@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('admin.popups.update', ['id' => $popup->id]) }}" method="post"
            class="add-new-record row g-2 p-5" id="form-add-new-record">
            @csrf
            @method('PUT')
            {{-- عنوان --}}
            <div class="col-sm-12">
                <label class="form-label" for="title">عنوان پاپ‌آپ</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-font"></i></span>
                    <input type="text" id="title" name="title" value="{{ $popup->title }}" class="form-control"
                        placeholder="عنوان پاپ‌آپ" required>
                </div>
            </div>

            {{-- متن --}}
            <div class="col-sm-12">
                <label class="form-label" for="text">متن پاپ‌آپ</label>
                <textarea id="text" name="text" class="form-control" rows="2" placeholder="متن پاپ‌آپ">{{ $popup->text }}</textarea>
            </div>

            {{-- تاریخ شروع و پایان --}}
            <div class="col-sm-3">
                <label class="form-label" for="start_date">تاریخ شروع</label>
                <input type="date" id="start_date" name="start_date" value="{{ $popup->start_date }}"
                    class="form-control">
            </div>

            <div class="col-sm-3">
                <label class="form-label" for="end_date">تاریخ پایان</label>
                <input type="date" id="end_date" name="end_date" value="{{ $popup->end_date }}" class="form-control">
            </div>

            <div class="col-sm-3">
                <label class="form-label" for="sort">ترتیب نمایش</label>
                <input type="number" id="sort" name="sort" value="{{ $popup->sort }}" readonly
                    class="form-control">
            </div>

            {{-- وضعیت --}}
            <div class="col-sm-3">
                <label class="form-label" for="status">وضعیت</label>
                <select id="status" name="status" class="form-select">
                    <option value="1" {{ $popup->status == 1 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ $popup->status == 1 ? '' : 'selected' }}>غیرفعال</option>
                </select>
            </div>

            <div class="col-sm-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">ثبت</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $('#end_date').flatpickr({
            monthSelectorType: 'static',
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d',
            disableMobile: true
        });
        $('#start_date').flatpickr({
            monthSelectorType: 'static',
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d',
            disableMobile: true
        });
    </script>
@endsection
