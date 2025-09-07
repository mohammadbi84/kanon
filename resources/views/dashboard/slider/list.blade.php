@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>افزودن اسلایدر جدید</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('slider.addpost') }}" method="post" enctype="multipart/form-data">
                    @CSRF
                    {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">نام</span>
                        </div>
                        <input type="text" class="form-control" name="name" aria-label="Username">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-btn">
                            <a id="image" data-input="imageInput" data-preview="imageHolder" class="btn btn-primary h-100 pt-2">
                                <i class="fa fa-picture-o"></i> عکس اسلایدر
                            </a>
                        </span>
                        <input id="imageInput" class="form-control" type="text" name="image">
                    </div>
                    <div id="imageHolder" class="mb-4" style="margin-top:15px;max-height:100px;"></div>
                    <div class="input-group mb-2">
                        <span class="input-group-btn">
                            <a id="video" data-input="videoInput" data-preview="videoHolder" class="btn btn-primary h-100 pt-2">
                                <i class="fa fa-picture-o"></i> ویدیو اسلایدر
                            </a>
                        </span>
                        <input id="videoInput" class="form-control" type="text" name="video">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon10">زمان نمایش به ثانیه</span>
                        </div>
                        <input type="number" class="form-control" name="show_time" >
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon10">اولویت نمایش</span>
                        </div>
                        <input type="number" class="form-control" name="order" >
                    </div>
                    <div id="videoHolder" class="mb-4" style="margin-top:15px;max-height:100px;"></div>


                    <button type="submit" class="btn btn-success ">ذخیره</button>

                </form>
            </div>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست اسلایدر ها</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>زمان پخش</th>
                            <th>اولویت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                            <tr class="{{ $item->id == 14 ? 'border border-3 border-danger' : '' }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->show_time }}</td>
                                <td>{{ $item->order }}</td>
                                <td class="text-center">
                                    <div>
                                        <a href="{{ route('slider.edit', ['id' => $item->id]) }}"
                                            class="btn btn-primary">مشاهده و
                                            ویرایش</a>
                                        @if ($item->id != 14)
                                            @if ($item->type == 0)
                                                <a href="{{ route('slider.release', ['id' => $item->id, 'type' => 1]) }}"
                                                    class="btn btn-danger">عدم انتشار</a>
                                            @else
                                                <a href="{{ route('slider.release', ['id' => $item->id, 'type' => 0]) }}"
                                                    class="btn btn-success">انتشار</a>
                                            @endif
                                            <a href="{{ route('slider.delete', ['id' => $item->id]) }}"
                                                class="btn btn-danger">حذف</a>
                                        @endif
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
@section('script')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        // در کد JS خود این را اضافه کنید:
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#image').filemanager('file');
        $('#video').filemanager('file');
    </script>
@endsection
