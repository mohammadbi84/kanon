@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 ">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>ویرایش اسلایدر {{ $item->name }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('slider.editpost', ['id' => $item->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @CSRF
                    {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">نام</span>
                        </div>
                        <input type="text" value="{{ $item->name }}" class="form-control" name="name"
                            aria-label="Username">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-btn">
                            <a id="image" data-input="imageInput" data-preview="imageHolder"
                                class="btn btn-primary h-100 pt-2">
                                <i class="fa fa-picture-o"></i> عکس اسلایدر
                            </a>
                        </span>
                        <input id="imageInput" class="form-control" type="text" name="image"
                            value="{{ $item->image }}">
                    </div>
                    <div id="imageHolder" class="mb-4" style="margin-top:15px;max-height:100px;"></div>

                    <div class="input-group mb-2">
                        <span class="input-group-btn">
                            <a id="video" data-input="videoInput" data-preview="videoHolder"
                                class="btn btn-primary h-100 pt-2">
                                <i class="fa fa-picture-o"></i> ویدیو اسلایدر
                            </a>
                        </span>
                        <input id="videoInput" class="form-control" type="text" name="video"
                            value="{{ $item->video }}">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon10">زمان نمایش به ثانیه</span>
                        </div>
                        <input type="number" class="form-control" name="show_time" value="{{ $item->show_time }}">

                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon10">اولویت نمایش</span>
                        </div>
                        <input type="number" class="form-control" name="order" value="{{ $item->order }}">
                    </div>
                    <div id="videoHolder" class="mb-4" style="margin-top:15px;max-height:100px;"></div>
                    <button type="submit" class="btn btn-success ">ذخیره</button>

                </form>
            </div>
            <div class="row mt-5 border rounded-4">
                <div class="col-6 p-3 text-center">
                    <h6>عکس اسلایدر</h6>
                    @if ($item->image)
                        <img src="{{ asset($item->image) }}" alt="image" class="w-100">
                        {{-- <a href="{{ route('slider.deleteMedia', ['id' => $item->id, 'type' => 1]) }}"
                            class="btn btn-danger mt-2">حذف عکس</a> --}}
                    @else
                        <p class="text-danger">
                            عکسی برای نمایش وجود ندارد
                        </p>
                    @endif
                </div>
                <div class="col-6 p-3 text-center">
                    <h6>ویدیو اسلایدر</h6>
                    @if ($item->video)
                        <video class="img-fluid rounded w-100" controls>
                            <source src="{{ asset($item->video) }}" type="video/mp4">
                            مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                        </video>
                        {{-- <a href="{{ route('slider.deleteMedia', ['id' => $item->id, 'type' => 2]) }}"
                            class="btn btn-danger mt-2">حذف ویدیو</a> --}}
                    @else
                        <p class="text-danger">
                            ویدیویی برای نمایش وجود ندارد
                        </p>
                    @endif
                </div>
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
