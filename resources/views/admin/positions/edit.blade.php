@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('admin.positions.update', ['position' => $position]) }}" method="post"
            class="add-new-record row g-2 p-5" id="form-add-new-record">
            @csrf
            @method("PUT")
            <div class="col-sm-12 mb-3">
                <label class="form-label" for="name">عنوان صفحه</label>
                <div class="input-group input-group-merge">
                    <span id="name2" class="input-group-text"><i class="bx bx-check-square"></i></span>
                    <input type="text" id="name" class="form-control dt-full-name" name="name"
                        placeholder="عنوان صفحه" value="{{ $position->name }}" aria-describedby="name2">
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label" for="max_slots">حداکثر آگهی</label>
                <div class="input-group input-group-merge">
                    <input type="number" id="max_slots" class="form-control dt-full-name" name="max_slots"
                        placeholder="حداکثر آگهی" value="{{ $position->max_slots }}" aria-describedby="max_slots2">
                </div>
                <small id="max_slots2" class="form-text text-muted">درصورت نداشتن سقف خالی گذاشته شود</small>
            </div>
            <div class="col-sm-12 mt-3">
                <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ذخیره تغییرات</button>
                <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary me-sm-3 me-1">انصراف</a>
            </div>
        </form>
    </div>
@endsection
@section('script')
@endsection
