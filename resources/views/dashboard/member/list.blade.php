@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
    <style>
        .form-control{padding: 0}
    </style>
@endsection
@section('content')
{{--    add--}}
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 ">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>افزودن عضو جدید به {{$organ->name}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{route('member.addpost',['o_id'=>$organ->id])}}" method="post">
                    @CSRF
                    {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">نام</span>
                        </div>
                        <input type="text" class="form-control" name="name" aria-label="Username" value="{{old('name')}}" >

                    </div>

                    {!! $errors->first('family', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">فامیل</span>
                        </div>
                        <input type="text" class="form-control" name="family" aria-label="Username" value="{{old('family')}}">

                    </div>

                    {!! $errors->first('mobile', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">موبایل</span>
                        </div>
                        <input type="text" class="form-control" name="mobile" aria-label="Username" value="{{old('mobile')}}">

                    </div>


                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">سمت</span>
                        </div>
                        <select name="role" type="text" class="form-control"  aria-label="Username">
                            <option value="1">مدیر</option>
                            <option value="2" @if(old('role')==2) selected @endif>معاون</option>
                            <option value="3" @if(old('role')==3) selected @endif>کارمند</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-success ">ذخیره</button>
                </form>
            </div>


        </div>
    </div>


{{--list--}}
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>اعضای {{$organ->name}}</h6>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>نام</th>
                        <th>فامیل</th>
                        <th>موبایل</th>
                        <th>سمت</th>

                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->family}}</td>
                        <td>{{$item->mobile}}</td>
                        <td>{{$item->role_name}}</td>

                        <td class="text-center">
                            <a href="{{route('member.edit',['o_id'=>$organ->id,'id'=>$item->id])}}" class="btn btn-primary">مشاهده و ویرایش</a>
                            <a href="{{route('member.delete',['o_id'=>$organ->id,'id'=>$item->id])}}" class="btn btn-danger">حذف</a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection
