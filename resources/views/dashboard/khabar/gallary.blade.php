@extends('dashboard.layout.master')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL STYLES -->

    <!-- Persian Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">

    <style>
        /* Custom styles for Persian Datepicker (Optional - for better appearance) */
        .datepicker-container {
            font-family: 'Vazir', sans-serif;
            /* Or any other Persian font */
        }

        .datepicker-plot-area {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            padding: 10px;
            /* width: 280px; */
            /* Adjust as needed */
        }

        /* ... (Other styles from your original code, if any) ... */

        .cke_1 {
            /*  For CKEditor */
            width: 100%;
        }

        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>گالری تصاویر خبر {{$khabar->title}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('khabar.add-image', ['id' => $khabar->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    {!! $errors->first('media', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">آپلود تصویر</span>
                        </div>
                        <input type="file" class="form-control" name="image" aria-label="Username">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                    </div>
                </form>
            </div>
            <div class="row p-3">
                @foreach ($images as $image)
                    <div class="col-md-4 mt-2">
                        <img src="{{ asset($image->image_path) }}" class="img-fluid" alt="Responsive image">
                        <a href="{{ route('khabar.delete-image', ['id' => $image->id]) }}" class="btn btn-danger mx-auto">حذف
                            عکس</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- jQuery (Load *before* Persian Datepicker) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Persian Date and Persian Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

    <!-- CKEditor (If you're using it) -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
@endsection
