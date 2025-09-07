@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 ">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>
                            ویرایش قانون
                            <h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <form action="{{route('policy.change')}}" method="post">
                    @CSRF
                    <div class="row">
                        <div class="col-md-4">
                            {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">
                                        قانون
                                    </span>
                                </div>
                                <textarea class="form-control" name="ghanon">{{$ghanon}}</textarea>
                                 
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
