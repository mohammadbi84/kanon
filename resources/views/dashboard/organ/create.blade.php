@extends('dashboard.layout.master')

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <form method="POST" action="{{ route('admin.organ.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>نام آموزشگاه</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>استان</label>
                <select name="state" class="form-control">
                    @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>شهر</label>
                <select name="city" class="form-control"></select>
            </div>

            <div class="form-group">
                <label>شماره موبایل</label>
                <input type="text" name="mobile" class="form-control">
            </div>

            {{-- سایر فیلدها مثل email، lat، lang و ... --}}

            <button type="submit" class="btn btn-success mt-3">ذخیره آموزشگاه</button>
        </form>
    </div>
</div>
@endsection
