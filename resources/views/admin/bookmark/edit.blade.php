@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('admin.bookmark.update', ['id' => $bookmark->id]) }}" method="post"
            class="add-new-record row g-2 p-5" id="form-add-new-record">
            @csrf
            @method('PUT')
            {{-- عنوان --}}
            <div class="col-sm-12">
                <label class="form-label" for="title">عنوان بوکمارک</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-font"></i></span>
                    <input type="text" id="title" name="title" value="{{ $bookmark->title }}" class="form-control"
                        placeholder="عنوان بوکمارک" required>
                </div>
            </div>

            {{-- متن --}}
            <div class="col-sm-12">
                <label class="form-label" for="body">متن بوکمارک</label>
                <textarea id="body" name="body" class="form-control" rows="2" placeholder="متن بوکمارک">{{ $bookmark->body }}</textarea>
            </div>

            {{-- تاریخ شروع و پایان --}}
            <div class="col-sm-3">
                <label class="form-label" for="start_at">تاریخ شروع</label>
                <input type="date" id="start_at" name="start_at" value="{{ $bookmark->start_at }}"
                    class="form-control">
            </div>

            <div class="col-sm-3">
                <label class="form-label" for="end_at">تاریخ پایان</label>
                <input type="date" id="end_at" name="end_at" value="{{ $bookmark->end_at }}" class="form-control">
            </div>

            <div class="col-sm-3">
                <label class="form-label" for="sort">ترتیب نمایش</label>
                <input type="number" id="sort" name="sort" value="{{ $bookmark->sort }}" readonly
                    class="form-control">
            </div>

            {{-- وضعیت --}}
            <div class="col-sm-3">
                <label class="form-label" for="active">وضعیت</label>
                <select id="active" name="active" class="form-select">
                    <option value="1" {{ $bookmark->active == 1 ? 'selected' : '' }}>فعال</option>
                    <option value="0" {{ $bookmark->active == 1 ? '' : 'selected' }}>غیرفعال</option>
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
        $('#end_at').flatpickr({
            monthSelectorType: 'static',
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d',
            disableMobile: true
        });
        $('#start_at').flatpickr({
            monthSelectorType: 'static',
            locale: 'fa',
            altInput: true,
            altFormat: 'Y/m/d',
            disableMobile: true
        });
    </script>
@endsection
