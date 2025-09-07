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
            <a href="{{route('adslogin.add')}}" class="btn btn-success">افزودن  تبلیغات صفحه ورود</a>
            <br><br>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست تبلیغات صفحه ورود</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>عکس</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><img src="/{{$item->image}}" alt="" width="50px" height="50px"></td>
                        <td class="text-center">
                          <div>
                            <a href="{{route('adslogin.edit',['id'=>$item->id])}}" class="btn btn-primary">مشاهده و ویرایش</a>
                            <a href="{{route('adslogin.delete',['id'=>$item->id])}}" class="btn btn-danger">حذف</a>
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
