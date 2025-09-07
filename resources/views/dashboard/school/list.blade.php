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

            <div class="col-md-8 offset-md-2">
                <a href="{{route('school.add',['o_id'=>$organ->id])}}" class="btn btn-success btn-block">
                    <h6>افزودن آموزشگاه جدید به {{$organ->name}}</h6>
                </a>
            </div>


        </div>
    </div>


{{--list--}}
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>آموزشگاه های {{$organ->name}}</h6>
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
                    @foreach($schools as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->name}}</td>

                        <td class="text-center">
                            <a href="{{route('school.edit',['o_id'=>$organ->id,'id'=>$item->id])}}" class="btn btn-primary">مشاهده و ویرایش</a>
                            <a href="{{route('school.delete',['o_id'=>$organ->id,'id'=>$item->id])}}" class="btn btn-danger">حذف</a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection
