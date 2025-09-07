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
                        <h6>ویرایش تخفیف {{$off->name}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
            <form action="{{route('off.editpost',['id'=>$off->id])}}" method="post">
                @CSRF
                {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">نام</span>
                    </div>
                    <input type="text" value="{{$off->name}}" class="form-control" name="name" aria-label="Username">

                </div>

                {!! $errors->first('value', '<p class="text-danger" >:message</p>') !!}
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">مقدار</span>
                    </div>
                    <input type="text" class="form-control" value="{{$off->value}}" name="value" aria-label="Username">

                </div>

                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">سمت</span>
                    </div>
                    <select name="type" type="text" class="form-control"  aria-label="Username">
                        <option value="1">%</option>
                        <option value="2" @if($off->type==2) selected @endif>مبلغ</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success ">ذخیره</button>

            </form>
            </div>


        </div>
    </div>

@endsection
