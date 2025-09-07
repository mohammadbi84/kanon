@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/dashboard/home">خانه</a></li>
                  <li class="breadcrumb-item"><a href="#">مدریت استاندارد ها</a></li>
                  <li class="breadcrumb-item active" aria-current="page">رشته ها</li>
                </ol>
              </nav>
              
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>افزودن گروه(رشته) جدید</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{route('group.addpost1')}}" method="post">
                    @CSRF
                    {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">نام</span>
                        </div>
                        <input type="text" class="form-control" name="name" aria-label="Username">
                    </div>
                        {!! $errors->first('khoshe', '<p class="text-danger" >:message</p>') !!}
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon5">خوشه</span>
                            </div>
                            <select name="khoshe" class="js-example-basic-single form-control" style="flex-grow: 1;" id="">
                                @foreach($khoshes as $khoshe)
                                    <option value="{{$khoshe->id}}">{{$khoshe->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    <button type="submit" class="btn btn-success ">ذخیره</button>

                </form>
            </div>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست گروه ها</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>نام</th>

                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->name}}</td>

                        <td class="text-center">
                          <div>
                            <a href="{{route('group.edit',['id'=>$item->id])}}" class="btn btn-primary">مشاهده و ویرایش</a>
                            <a href="{{route('group.delete',['id'=>$item->id])}}" class="btn btn-danger">حذف</a>
                            <a href="{{route('herfe.list',['id'=>$item->id])}}" class="btn btn-info">حرفه</a>
                            <a href="{{route('sanad.list',['id'=>$item->id])}}" class="btn btn-info">سند حرفه</a>
                          </div>

                        </td>
                    </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection
