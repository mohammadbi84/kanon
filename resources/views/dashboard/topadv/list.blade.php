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
            <a href="{{route('topadv.add')}}" class="btn btn-success">افزودن اطلاعیه</a>
            <br><br>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست اطلاعیه ها</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>متن</th>
                        <th>تاریخ شروع</th>
                        <th>تاریخ پایان</th>
                        <th>مدت زمان</th>

                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->text}}</td>
                        <td>{{$item['start_date']}}</td>
                        <td>{{$item['end_date']}}</td>
                        <td>{{$item->duration}}s</td>

                        <td class="text-center">
                          <div>
                            <a href="{{route('topadv.edit',['id'=>$item->id])}}" class="btn btn-primary">مشاهده و ویرایش</a>
                            <a href="{{route('topadv.delete',['id'=>$item->id])}}" class="btn btn-danger">حذف</a>
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
