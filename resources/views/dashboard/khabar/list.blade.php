@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL STYLES -->
    <style>
        .form-control {
            padding: 0
        }
    </style>
@endsection
@section('content')
    {{-- list --}}
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست اخبار </h6>
                        <br>
                        <br>
                        <a href="{{ route('khabar.add') }}" class="btn btn-success">افزودن خبر جدید</a>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-4 mt-4">
                <form id="bulk-delete-form" method="POST" action="{{ route('khabar.bulk-delete') }}">
                    @csrf
                    <table id="default-ordering" class="table table-hover" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th><input type="checkbox" id="select-all"></th> <!-- چک‌باکس انتخاب همه -->
                                <th>ردیف</th>
                                <th>عنوان خبر</th>
                                <th> خلاصه خبر</th>
                                <th>متن کامل خبر</th>
                                <th>نویسنده خبر</th>
                                <th>تاریخ و ساعت ایجاد</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($khabars as $key => $item)
                                <tr class="text-center">
                                    <td><input type="checkbox" name="selected_items[]" value="{{ $item->id }}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{!! $item->short ?? Str::limit(strip_tags($item->text), 50) !!}</td>
                                    <td>{!! Str::limit(strip_tags($item->text)) !!}</td>
                                    <td>
                                        {{ isset($item['author']) && $item['author']->name && $item['author']->family
                                            ? $item['author']->name . ' ' . $item['author']->family
                                            : $item['author']->mobile ?? '-' }}
                                    </td>
                                    <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($item->created_at)->format('H:i Y/m/d') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('khabar.edit', ['id' => $item->id]) }}"
                                            class="btn btn-primary">مشاهده
                                            و ویرایش</a>
                                        <a href="{{ route('khabar.gallary', ['id' => $item->id]) }}"
                                            class="btn btn-info">گالری تصاویر</a>
                                        <a href="{{ route('khabar.delete', ['id' => $item->id]) }}"
                                            class="btn btn-danger">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-danger mt-2">حذف انتخاب‌شده‌ها</button>
                </form>

                <script>
                    document.getElementById('select-all').addEventListener('change', function(e) {
                        let checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
                        checkboxes.forEach(cb => cb.checked = e.target.checked);
                    });
                </script>

            </div>
        </div>
    </div>
@endsection
