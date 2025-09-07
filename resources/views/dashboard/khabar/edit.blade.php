@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 ">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>ویرایش خبر {{$khabar->title}} </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('khabar.editpost', $khabar->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">عنوان خبر</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $khabar->title }}"
                            required>
                    </div>
                    {!! $errors->first('short', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">خلاصه خبر</span>
                        </div>
                        <textarea name="short" id="short" class="form-control" aria-label="Username">{{ $khabar->short }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="text">متن خبر</label>
                        <textarea class="form-control cke_1" id="text" name="text"
                            id="editor"> {{ $khabar->text }}</textarea>
                    </div>


                    <div class="form-group">
                        <label for="publish_date">تاریخ و ساعت انتشار</label>
                        <input type="text" class="form-control" id="publish_date" name="publish_date"
                            value="{{ $khabar->publish_date }}">
                    </div>

                    <div class="form-group">
                        <label for="archive_date">تاریخ و ساعت پایان انتشار (آرشیو)</label>
                        <input type="text" class="form-control" id="archive_date" name="archive_date"
                            value="{{ $khabar->archive_date }}">
                    </div>

                    {!! $errors->first('media', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">اپلود ویدیوی جدید</span>
                        </div>
                        <input type="file" class="form-control" name="media" aria-label="Username">
                    </div>

                    {!! $errors->first('cover', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">اپلود کاور جدید</span>
                        </div>
                        <input type="file" class="form-control" name="cover" aria-label="Username">
                    </div>

                    <div class="form-group">
                        <label for="media">فیلم یا گالری عکس</label>
                        {{-- <input type="file" class="form-control" id="media" name="media[]" multiple> --}}

                        <div class="mt-3">
                            @php
                                $mediaFiles = json_decode($khabar->media, true) ?? [];
                            @endphp

                            @foreach ($mediaFiles as $file)
                                @if (pathinfo($file, PATHINFO_EXTENSION) == 'mp4')
                                    <video width="200" controls>
                                        <source src="{{ asset($file) }}" type="video/mp4">
                                        مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                                    </video>
                                    <br>
                                @else
                                    <img src="{{ asset($file) }}" alt="گالری خبر" width="100" class="m-1">
                                @endif
                            @endforeach
                        </div>
                    </div>



                    <button type="submit" class="btn btn-primary">ویرایش خبر</button>
                </form>

                <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace('editor');
                    document.addEventListener("DOMContentLoaded", function () {
                        let editorElement = document.querySelector(".cke_1");
                        if (editorElement) {
                            editorElement.classList.add("w-100");
                        }
                    });
                </script>

            </div>


        </div>
    </div>

@endsection
