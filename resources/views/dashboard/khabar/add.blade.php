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
                        <h6>افزودن خبر جدید</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('khabar.addpost') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {!! $errors->first('title', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">عنوان خبر</span>
                        </div>
                        <input type="text" class="form-control" name="title" aria-label="Username"
                            value="{{ old('title') }}">
                    </div>
                    {!! $errors->first('short', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">خلاصه خبر</span>
                        </div>
                        <textarea name="short" id="short" class="form-control" aria-label="Username">{{ old('short') }}</textarea>
                    </div>

                    {!! $errors->first('text', '<p class="text-danger">:message</p>') !!}

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">متن خبر</span>
                        </div>
                        <textarea class="form-control w-100" name="text" id="editor" aria-label="Username">{{ old('text') }}</textarea>
                    </div>

                    {!! $errors->first('publish_at', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">تاریخ و ساعت انتشار</span>
                        </div>
                        <input type="text" id="publish_at" class="form-control" name="publish_at" aria-label="Username"
                            value="{{ old('publish_at') }}">
                    </div>
                    <div id="publish_at_error" class="error-message"></div>

                    {!! $errors->first('archive_at', '<p class="text-danger">:message</p>') !!}

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">تاریخ و ساعت پایان انتشار</span>
                        </div>
                        <input type="text" id="archive_at" class="form-control" name="archive_at" aria-label="Username"
                            value="{{ old('archive_at') }}">

                    </div>
                    <div id="archive_at_error" class="error-message"></div>

                    {!! $errors->first('media', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">اپلود ویدیو</span>
                        </div>
                        <input type="file" class="form-control" name="media" aria-label="Username">

                    </div>

                    {!! $errors->first('cover', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">اپلود کاور</span>
                        </div>
                        <input type="file" class="form-control" name="cover" aria-label="Username">
                    </div>

                    <button type="submit" class="btn btn-success">ذخیره</button>
                </form>
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
    <script>
        $(document).ready(function() {

            // CKEditor Initialization (If you're using it)
            CKEDITOR.replace('editor');
            // Make CKEditor 100% width (Optional, for better responsiveness)
            document.addEventListener("DOMContentLoaded", function() {
                let editorElement = document.querySelector(".cke_1");
                if (editorElement) {
                    editorElement.classList.add("w-100");
                }
            });

            // Initialize publish_at datepicker
            $("#publish_at").pDatepicker({
                format: 'YYYY/MM/DD HH:mm:ss',
                timePicker: {
                    enabled: true,
                    second: {
                        enabled: false, // Disable seconds (unless you need them)
                    }
                },
                initialValue: false,
                onSelect: function(unix) {
                    // Optional: Handle publish_at selection if needed
                    $("#publish_at_error").text(""); // Clear any previous error
                }
            });

            // Initialize archive_at datepicker
            $("#archive_at").pDatepicker({
                format: 'YYYY/MM/DD HH:mm:ss',
                timePicker: {
                    enabled: true,
                    second: {
                        enabled: false, // Disable seconds
                    }
                },
                initialValue: false,
                minDate: $("#publish_at").val() ? new persianDate(parseInt($("#publish_at").val()))
                .valueOf() : null, // Set initial minDate
                onSelect: function(unix) {
                    // Optional: Handle archive_at selection
                    $("#archive_at_error").text("");
                }
            });

            // Update minDate of archive_at when publish_at changes
            $("#publish_at").on('change', function() {
                let publishAtTimestamp = $(this).val(); // Get the timestamp string
                if (publishAtTimestamp) {
                    let minDate = new persianDate(parseInt(publishAtTimestamp))
                .valueOf(); // Convert to Unix timestamp (milliseconds)
                    $("#archive_at").pDatepicker("option", "minDate",
                    minDate); // Update archive_at's minDate
                } else {
                    $("#archive_at").pDatepicker("option", "minDate",
                    null); // No restriction if publish_at is empty
                }
            });

            // Clear error messages on focus
            $("#publish_at").on("focus", function() {
                $("#publish_at_error").text("");
            });
            $("#archive_at").on("focus", function() {
                $("#archive_at_error").text("");
            });

            //Close the datepickers if clicked outside
            $(document).on("click", function(event) {
                if (!$(event.target).is("#publish_at, #archive_at") && !$(event.target).closest(
                        ".datepicker-plot-area").length) {
                    $("#publish_at").pDatepicker("hide");
                    $("#archive_at").pDatepicker("hide");
                }
            });
        });
    </script>
@endsection
