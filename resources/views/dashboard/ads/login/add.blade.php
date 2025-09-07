@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>افزودن تبلیغات صفحه ورود</h6>
                    </div>
                </div>
            </div><br>  
            <form action="{{route('adslogin.addpost')}}" method="post" enctype="multipart/form-data">
                @CSRF               

                {!! $errors->first('image', '<p class="text-danger" >:message</p>') !!}
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">عکس </span>
                    </div>
                    <input type="file" class="form-control" name="image" aria-label="Username">

                </div>

                <button type="submit" class="btn btn-success ">ذخیره</button>

            </form>
        </div>
    </div>

@endsection