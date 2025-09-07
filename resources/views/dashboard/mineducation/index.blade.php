@extends('dashboard.layout.master')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
@endsection

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="widget-content widget-content-area br-6">

    
        <div class="widget-header mt-5 mb-3">
            <a href="{{ route('mineducation.create') }}" class="btn btn-success mb-3">افزودن جدید</a>

            <h6>لیست حداقل تحصیلات ورودی</h6>
        </div>

        <div class="table-responsive">
            <table id="default-ordering" class="table table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $key => $item)
                        <tr class="text-center">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('mineducation.edit', $item->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                                <a href="{{ route('mineducation.delete', $item->id) }}" class="btn btn-danger btn-sm">حذف</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
