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


{{--list--}}
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست آگهی ها </h6>
                        <br><br>
                        <a href="{{route('Advertisement.add')}}" class="btn btn-success">افزودن آگهی جدید</a>
                    </div>
                </div>
            </div>


            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr class="text-center">
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>وضعیت آگهی</th>

                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($khabars as $key=>$item)
                    
                    <tr class="text-center">
                        <td>{{$key+1}}</td>
                        <td>{{$item->title}}</td>
                        <td class="{{$item->StatusClass()}}">{{$item->status()}}</td>

                        <td>
                            <a href="{{route('Advertisement.edit',['id'=>$item->id])}}" class="btn btn-primary">مشاهده و ویرایش</a>
                            <a href="{{route('Advertisement.delete',['id'=>$item->id])}}" class="btn btn-danger">حذف</a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection
