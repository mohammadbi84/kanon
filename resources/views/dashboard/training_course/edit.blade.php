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
                        <h6>ویرایش استاندارد آموزشی {{$course->name}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
            <form action="{{route('course.editpost',['id'=>$course->id])}}" method="post">
                @CSRF
                {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">عنوان</span>
                    </div>
                    <input type="text" class="form-control" name="name" aria-label="Username" value="{{$course->name}}">
                </div>

                {!! $errors->first('description', '<p class="text-danger" >:message</p>') !!}
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">توضیحات</span>
                    </div>
                    <textarea name="description" id="" cols="30" rows="10" class="form-control" >{{$course->description}}</textarea>
                </div>

                {!! $errors->first('price', '<p class="text-danger" >:message</p>') !!}
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">مبلغ</span>
                    </div>
                    <input type="text" class="form-control" name="price" aria-label="Username" value="{{$course->price}}">
                </div>

                <button type="submit" class="btn btn-success ">بروزرسانی</button>

            </form>
            </div>


        </div>
    </div>

@endsection
