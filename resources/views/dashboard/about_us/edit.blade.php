@extends('dashboard.layout.master')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
@endsection
@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h6>ویرایش درباره ما</h6>
                </div>
            </div>
        </div>
        <div class="col-md-8 offset-md-2">
            <form method="POST" action="{{ route('about.editpost', $aboutUs->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">توضیحات</span>
                    </div>
                    <textarea name="description" class="form-control" required>{{ $aboutUs->description }}</textarea>
                </div>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">عکس</span>
                    </div>
                    <input type="file" name="image" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">بروزرسانی</button>
            </form>
        </div>
    </div>
</div>
@endsection
