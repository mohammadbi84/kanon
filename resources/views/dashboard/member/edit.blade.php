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
                        <h6>ویرایش کارمند {{$user->name}} {{$user->family}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{route('member.editpost',['o_id'=>$organ->id,'id'=>$user->id])}}" method="post">
                    @CSRF
                    {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">نام</span>
                        </div>
                        <input type="text" class="form-control" disabled aria-label="Username" value="{{$user->name}}" >

                    </div>

                    {!! $errors->first('family', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">فامیل</span>
                        </div>
                        <input type="text" class="form-control" disabled aria-label="Username" value="{{$user->family}}">

                    </div>

                    {!! $errors->first('mobile', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">موبایل</span>
                        </div>
                        <input type="text" class="form-control" disabled aria-label="Username" value="{{$user->mobile}}">

                    </div>


                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">سمت</span>
                        </div>
                        <select name="role" type="text" class="form-control"  aria-label="Username">
                            <option value="1">مدیر</option>
                            <option value="2" @if($role==2) selected @endif>معاون</option>
                            <option value="3" @if($role==3) selected @endif>کارمند</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-success ">ذخیره</button>
                </form>
            </div>


        </div>
    </div>

@endsection
