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
                        <h6>ویرایش آگهی {{ $khabar->title }} </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('Advertisement.editpost', ['id' => $khabar->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @CSRF
                    {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">عنوان</span>
                        </div>
                        <input type="text" name="title" class="form-control" aria-label="Username"
                            value="{{ $khabar->title }}">

                    </div>
                    {!! $errors->first('title', '<p class="text-danger" >:message</p>') !!}



                    <div class="input-group mb-2">
                        <span class="input-group-btn">
                            <a id="image" data-input="imageInput" data-preview="imageHolder"
                                class="btn btn-primary h-100 pt-2">
                                <i class="fa fa-picture-o"></i> عکس اسلایدر
                            </a>
                        </span>
                        <input id="imageInput" class="form-control" type="text" name="image"
                            value="{{ $khabar->image }}">

                        </div>
                        {!! $errors->first('image', '<p class="text-danger" >:message</p>') !!}
                    <div id="imageHolder" class="mb-4" style="margin-top:15px;max-height:100px;"></div>


                    {!! $errors->first('text', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">متن</span>
                        </div>
                        <textarea class="form-control" name="text" aria-label="Username">{{ $khabar->text }}</textarea>

                    </div>


                    {!! $errors->first('price', '<p class="text-danger" >:message</p>') !!}

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">مبلغ</span>
                        </div>
                        <input type="text" class="form-control" name="price" aria-label="Username"
                            value="{{ $khabar->price }}">
                    </div>

                    <div class="input-group mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Advertisement" id="flexRadioDefault1"
                                value="0" @if ($khabar->status == 0) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault1">
                                داغ ترین
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Advertisement" id="flexRadioDefault2"
                                value="1" @if ($khabar->status == 1) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault2">
                                نردبان شده
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="Advertisement" id="flexRadioDefault2"
                                @if ($khabar->status == null) checked @endif>
                            <label class="form-check-label" for="flexRadioDefault2">
                                معمولی
                            </label>
                        </div>
                    </div>



                    <button type="submit" class="btn btn-success ">بروزرسانی</button>
                </form>
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
    </script>
@endsection
