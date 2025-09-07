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
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">

            <form action="{{ route('tuition_herfe.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mt-3">
                        {!! $errors->first('year', '<p class="text-danger">:message</p>') !!}
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon5">سال</span>
                            </div>
                            <input type="text" id="year" class="form-control" name="year" aria-label="Username"
                                value="{{ old('year') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        {!! $errors->first('title', '<p class="text-danger">:message</p>') !!}
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon5">عنوان</span>
                            </div>
                            <input type="text" id="title" class="form-control" name="title" aria-label="Username"
                                value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        {!! $errors->first('startDate', '<p class="text-danger">:message</p>') !!}
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon5">تاریخ شروع اعتبار</span>
                            </div>
                            <input type="text" id="startDate" class="form-control" name="startDate" aria-label="Username"
                                value="{{ old('startDate') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        {!! $errors->first('endDate', '<p class="text-danger">:message</p>') !!}
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon5">تاریخ پایان اعتبار</span>
                            </div>
                            <input type="text" id="endDate" class="form-control" name="endDate" aria-label="Username"
                                value="{{ old('endDate') }}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        {!! $errors->first('endDate', '<p class="text-danger">:message</p>') !!}
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon5">شهرستان ها</span>
                            </div>
                            <select name="city_id" id="city_id" class="form-control">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>




                <button type="submit" class="btn btn-success">اضافه کردن</button>
            </form>
        </div>
    </div>



    <!-- jQuery (Load *before* Persian Datepicker) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Persian Date and Persian Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize publish_at datepicker
            $("#startDate").pDatepicker({
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false,
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
            $("#endDate").pDatepicker({
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false,
                    second: {
                        enabled: false, // Disable seconds
                    }
                },
                initialValue: false,
                minDate: $("#endDate").val() ? new persianDate(parseInt($("#endDate").val()))
                    .valueOf() : null, // Set initial minDate
                onSelect: function(unix) {
                    // Optional: Handle archive_at selection
                    $("#archive_at_error").text("");
                }
            });

            // Update minDate of archive_at when publish_at changes
            $("#startDate").on('change', function() {
                let publishAtTimestamp = $(this).val(); // Get the timestamp string
                if (publishAtTimestamp) {
                    let minDate = new persianDate(parseInt(publishAtTimestamp))
                        .valueOf(); // Convert to Unix timestamp (milliseconds)
                    $("#endDate").pDatepicker("option", "minDate",
                        minDate); // Update archive_at's minDate
                } else {
                    $("#endDate").pDatepicker("option", "minDate",
                        null); // No restriction if publish_at is empty
                }
            });

            // Clear error messages on focus
            $("#startDate").on("focus", function() {
                $("#publish_at_error").text("");
            });
            $("#endDate").on("focus", function() {
                $("#archive_at_error").text("");
            });

            //Close the datepickers if clicked outside
            $(document).on("click", function(event) {
                if (!$(event.target).is("#startDate, #endDate") && !$(event.target).closest(
                        ".datepicker-plot-area").length) {
                    $("#startDate").pDatepicker("hide");
                    $("#endDate").pDatepicker("hide");
                }
            });
        });
    </script>
@endsection
