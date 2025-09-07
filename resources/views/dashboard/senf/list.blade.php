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
                    @foreach($senfs as $key=>$senf)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$senf->name}}</td>

                        <td class="text-center">
                          <div>
                            <a href="{{route('senf.edit',['id'=>$senf->id])}}" class="btn btn-primary">مشاهده و ویرایش</a>
                            <a href="{{route('senf.delete',['id'=>$senf->id])}}" class="btn btn-danger">حذف</a>
                          </div>
                            <div class="mt-2">
                            <a href="{{route('member.list',['o_id'=>$senf->id])}}" class="btn btn-outline-info">اعضا</a>
                            <a href="{{route('school.list',['o_id'=>$senf->id])}}" class="btn btn-outline-success">اموزشگاه ها</a>
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
