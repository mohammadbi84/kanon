@extends('dashboard.layout.master')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
@endsection
@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h6>لیست درباره ما</h6>
                    <br><br>
                    <a href="{{ route('about.add') }}" class="btn btn-success">افزودن جدید</a>
                </div>
            </div>
        </div>
        <div class="table-responsive mb-4 mt-4">
            <table id="default-ordering" class="table table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>شناسه</th>
                        <th>توضیحات</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aboutUs as $key => $item)
                        <tr class="text-center">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <a href="{{ route('about.edit', $item->id) }}" class="btn btn-primary">ویرایش</a>
                                <a href="{{ route('about.delete', $item->id) }}" class="btn btn-danger">حذف</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
