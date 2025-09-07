@extends('dashboard.layout.master')

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <form method="POST" action="{{ route('organ.update', $organ->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>نام آموزشگاه</label>
                <input type="text" name="name" class="form-control" value="{{ $organ->name }}">
            </div>

            <div class="form-group">
                <label>استان</label>
                <select name="state" class="form-control">
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ $organ->state == $state->id ? 'selected' : '' }}>{{ $state->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>شهر</label>
                <select name="city" class="form-control">
                    @foreach($state['cities'] ?? [] as $city)
                        <option value="{{ $city->id }}" {{ $organ->city == $city->id ? 'selected' : '' }}>{{ $city->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>شماره موبایل</label>
                <input type="text" name="mobile" class="form-control" value="{{ $organ->mobile }}">
            </div>

            {{-- سایر فیلدها مثل email، lat، lang و ... --}}

            <button type="submit" class="btn btn-primary mt-3">ذخیره تغییرات</button>
        </form>
    </div>
</div>
@endsection
