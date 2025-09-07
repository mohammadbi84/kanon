@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 ">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>پیکربندی پاپ‌آپ<h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <form action="{{ route('popup.update') }}" method="post">
                    @CSRF
                    <div class="row">
                        <div class="col-md-4">
                            {!! $errors->first('status', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">
                                        وضعیت نمایش
                                    </span>
                                </div>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $popup->status == 1 ? 'selected' : '' }}>انتشار</option>
                                    <option value="2" {{ $popup->status == 2 ? 'selected' : '' }}>عدم انتشار</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            {!! $errors->first('text', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">
                                        عنوان پاپ‌آپ
                                    </span>
                                </div>
                                <input type="text" value="{{ $popup->title }}" class="form-control" name="title"
                                    aria-label="Username">
                            </div>
                        </div>
                        <div class="col-md-12">
                            {!! $errors->first('text', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">
                                        متن پاپ‌آپ
                                    </span>
                                </div>
                                <textarea class="form-control" name="text">{{ $popup->text }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block ">ذخیره</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
@endsection
