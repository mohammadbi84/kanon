@extends('dashboard.layout.master')

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="widget-content widget-content-area br-6">

        <div class="widget-header mb-3">
            <h6>{{ isset($item) ? 'ویرایش حداقل تحصیلات' : 'افزودن حداقل تحصیلات جدید' }}</h6>
        </div>

        <div class="col-md-6 offset-md-3">
            <form method="POST" action="{{ isset($item) ? route('mineducation.update', $item->id) : route('mineducation.store') }}">
                @csrf
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">نام</span>
                    </div>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $item->name ?? '') }}">
                </div>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($item) ? 'ویرایش' : 'ذخیره' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
