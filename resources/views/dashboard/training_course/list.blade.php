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
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست استاندارد های اموزشی</h6>
                        <br><br>
                        <a href="{{route('course.add')}}" class="btn btn-success">افزودن استاندارد آموزشی جدید</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr class="text-center">
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>متن</th>
                        <th>استاد</th>
                        <th>تاریخ</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $key=>$course)
                    <tr  class="text-center">
                        <td>{{$key+1}}</td>
                        <td>{{$course->name}}</td>
                        <td>{{$course->description}}</td>
                        <td>{{$course->teacher}}</td>
                        <td>{{$course['time']}}</td>

                        <td>
                            <a href="{{route('course.edit',['id'=>$course->id])}}" class="btn btn-primary">مشاهده و ویرایش</a>
                            <a href="{{route('course.delete',['id'=>$course->id])}}" class="btn btn-danger">حذف</a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection
