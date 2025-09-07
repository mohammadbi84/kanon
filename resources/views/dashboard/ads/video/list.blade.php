@extends('dashboard.layout.master')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <a href="{{route('videoads.add')}}" class="btn btn-success">افزودن ویدیو تبلیغاتی</a>
            <br><br>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست ویدیوهای تبلیغاتی</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>ویدیو</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                <video width="80" height="50" controls>
                                    <source src="/{{$item->video}}" type="video/mp4">
                                </video>
                            </td>
                            <td class="text-center">
                                <div>
                                    <a href="{{route('videoads.edit', ['id' => $item->id])}}" class="btn btn-primary">ویرایش</a>
                                    <a href="{{route('videoads.delete', ['id' => $item->id])}}" class="btn btn-danger">حذف</a>
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
