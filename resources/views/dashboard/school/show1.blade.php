@extends('dashboard.layout.master')
@section('head')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
<!-- END PAGE LEVEL STYLES -->
<style>
    .form-control {
        padding: 0
    }
</style>
@endsection
@section('content')



{{--list--}}
<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h6>آموزشگاه </h6>
                </div>
            </div>
        </div>



        <form action="/dashboard/admin_update/{{$organ->id}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">نام</span>
                        </div>
                        <input type="text" value="{{$organ->name}} " class="form-control" name="name"
                            aria-label="Username">

                    </div>
                </div>


                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                شماره شناسایی
                            </span>
                        </div>
                        <input type="text" value="{{$organ->number}} " class="form-control" name="number"
                            aria-label="Username">

                    </div>
                </div>



                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                شماره صدور
                            </span>
                        </div>
                        <input type="text" value=" {{$organ->sodor_num}}" class="form-control" name="sodor_num"
                            aria-label="Username">

                    </div>
                </div>



                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                تاریخ صدور
                            </span>
                        </div>
                        <input type="text" value="{{$organ->sodor_start}} " class="form-control" name="sodor_start"
                            aria-label="Username">

                    </div>
                </div>




                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                تاریخ پایان اعتبار
                            </span>
                        </div>
                        <input type="text" value="{{$organ->sodor_end}} " class="form-control" name="sodor_end"
                            aria-label="Username">

                    </div>
                </div>





                <div class="col-md">
                    <label for="">
                        تبصره 34
                    </label>
                    <input @if($organ->tabsare34) checked @endif type="checkbox" name="tabsare34" >
                </div>



                <div class="col-md">
                    <label for="">
                        ویژه برادران
                    </label>
                    <input @if($organ->baradaran==1) checked @endif type="checkbox" name="mardzan" >
                </div>


                <div class="col-md">
                    <label for="">
                        ویژه خواهران
                    </label>
                    <input @if($organ->khaharan==1) checked @endif type="checkbox" name="mardzan" >
                </div>








                <div class="col-md-6">
                    {!! $errors->first('sodor_end', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4 form-label-group in-border">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">حقیقی</span>
                        </div>
                        <input type="radio" id="haghighi" onclick="haghighi2()" checked class="form-check-input"
                            name="tabsare34" aria-label="Username">

                    </div>
                </div>

                <div class="col-md-6">
                    {!! $errors->first('sodor_end', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4 form-label-group in-border">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">حقوقی</span>
                        </div>
                        <input type="radio" id="hoghoghi" onclick="hoghoghi2()" class="form-check-input"
                            name="tabsare34" aria-label="Username">

                    </div>
                </div>







                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                نام مدیر
                            </span>
                        </div>
                        <input type="text" value=" {{$moases->name}}" class="form-control" name="modir_name"
                            aria-label="Username">

                    </div>
                </div>


                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                نام خانوادگی مدیر
                            </span>
                        </div>
                        <input type="text" value="{{$moases->family}} " class="form-control" name="modir_family"
                            aria-label="Username">

                    </div>
                </div>




                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                شماره ملی مدیر
                            </span>
                        </div>
                        <input type="text" value="{{$moases->national_code}} " class="form-control"
                            name="modir_national" aria-label="Username">

                    </div>
                </div>






                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                شماره شناسنامه مدیر
                            </span>
                        </div>
                        <input type="text" value="{{$moases->shenasname}} " class="form-control" name="modir_shenasname"
                            aria-label="Username">

                    </div>
                </div>


                <div class="col-md-6">
                    {!! $errors->first('modir_gender', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4 form-label-group in-border">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">جنسیت</span>
                        </div>
                        <select type="text" class="form-select" name="modir_gender" id="modir_gender"
                            aria-label="Username">
                            <option value="">----</option>
                            <option @if($moases->gender==1) selected @endif value="1">مرد</option>
                            <option @if($moases->gender==2) selected @endif value="2">زن</option>
                        </select>

                    </div>
                </div>





                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                نام پدر مدیر
                            </span>
                        </div>
                        <input type="text" value="{{$moases->father}}" class="form-control" name="modir_father"
                            aria-label="Username">

                    </div>
                </div>





                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                تاریخ تولد مدیر
                            </span>
                        </div>
                        <input type="text" value="{{$moases->birthday}}" class="form-control" name="modir_birthday"
                            aria-label="Username">

                    </div>
                </div>





                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                محل صدور شناسنامه مدیر
                            </span>
                        </div>
                        <input type="text" value="{{$moases->sadere}}" class="form-control" name="modir_sodor"
                            aria-label="Username">

                    </div>
                </div>








                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                نام شرکت
                            </span>
                        </div>
                        <input type="text" value="{{$organ->hoghoghi_name}}" class="form-control" name="hoghoghi_name"
                            aria-label="Username">

                    </div>
                </div>




                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                شماره ثبت
                            </span>
                        </div>
                        <input type="text" value="{{$organ->hoghoghi_sabt}}" class="form-control" name="hoghoghi_sabt"
                            aria-label="Username">

                    </div>
                </div>



                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                مدیر عامل
                            </span>
                        </div>
                        <input type="text" value="{{$organ->hoghoghi_modir}}" class="form-control" name="hoghoghi_modir"
                            aria-label="Username">

                    </div>
                </div>





                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                تاریخ ثبت
                            </span>
                        </div>
                        <input type="text" value="{{$organ->hoghoghi_tarikh}}" class="form-control"
                            name="hoghoghi_tarikh" aria-label="Username">

                    </div>
                </div>





                <div class="col-md-6">
                    {!! $errors->first('state', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4 form-label-group in-border">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">استان</span>
                        </div>
                        <select type="text" class="form-select" name="state" aria-label="Username"
                            value="{{old('state')}}" id="ostan" onchange="changeostan(this)">

                            <option value="{{$ostan->id}}">

                                {{$ostan->title}}
                            </option>
                            @foreach($states as $state)
                            <option value="{{$state->id}}">
                                {{$state->title}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-md-6">
                    {!! $errors->first('city', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4 form-label-group in-border">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">شهرستان</span>
                        </div>
                        <select type="text" class="form-select" name="city" id="city" aria-label="Username"
                            value="{{old('city')}}">
                            <option value="{{$city->id}}">

                                {{$city->title}}
                            </option>
                        </select>



                    </div>
                </div>

                <div class="col-md-12">
                    {!! $errors->first('address', '<p class="text-danger">:message</p>') !!}
                    <div class="input-group mb-4 form-label-group in-border">
                        <label for="">آدرس</label>


                        <textarea type="text" class="form-control" name="address" id="address" aria-label="Username"
                            value="{{old('address')}}">{{$organ->address}}</textarea>
                    </div>
                </div>







                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                کدپستی
                            </span>
                        </div>
                        <input type="text" value="{{$organ->postal}}" class="form-control" name="postal"
                            aria-label="Username">

                    </div>
                </div>






                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                تلفن
                            </span>
                        </div>
                        <input type="text" value="{{$organ->tel}}" class="form-control" name="tel"
                            aria-label="Username">

                    </div>
                </div>





                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                فکس
                            </span>
                        </div>
                        <input type="text" value="{{$organ->fax}}" class="form-control" name="fax"
                            aria-label="Username">

                    </div>
                </div>





                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                موبایل
                            </span>
                        </div>
                        <input type="text" value="{{$organ->mobile}}" class="form-control" name="mobile"
                            aria-label="Username">

                    </div>
                </div>



                <head>
                    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                </head>

                <div class="col-6">
                    <label>لوگو</label>
                    @if($organ->file_logo)
                    <img src="{{ asset($organ->file_logo) }}" alt="Logo" class="img-thumbnail mb-2" width="100">
                    @endif
                    <input type="file" class="form-control" name="file_logo">
                </div>

                <div class="col-6">
                    <label>فایل تأسیس</label>
                    @if($organ->file_tasis)
                    <img src="{{ asset($organ->file_tasis) }}" alt="Tasis" class="img-thumbnail mb-2" width="100">
                    @endif
                    <input type="file" class="form-control" name="file_tasis">
                </div>

                <div class="col-6">
                    <label>فایل مؤسس</label>
                    @if($organ->file_moases)
                    <img src="{{ asset($organ->file_moases) }}" alt="Moases" class="img-thumbnail mb-2" width="100">
                    @endif
                    <input type="file" class="form-control" name="file_moases">
                </div>





                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                سایت
                            </span>
                        </div>
                        <input type="text" value="{{$organ->site}}" class="form-control" name="site"
                            aria-label="Username">

                    </div>
                </div>




                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                ایمیل
                            </span>
                        </div>
                        <input type="text" value="{{$organ->email}}" class="form-control" name="email"
                            aria-label="Username">

                    </div>
                </div>



                @if(1)
                @foreach($socials as $social)

                <div class="col-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">
                                آدرس {{$social->name}}
                            </span>
                        </div>
                        <input type="text" value="{{$social->value}}" class="form-control" name="{{$social->id}}"
                            aria-label="Username">

                    </div>
                </div>


                @endforeach

                @endif





                @foreach($herfes as $herfe)
                <div class="col-md">
                    <label for="">
                        {{$herfe->name}}
                    </label>
                    <input type="checkbox" name="herfe[{{$herfe->id}}]" value="{{$herfe->id}}" @if($herfe->ok==1)
                    checked
                    @endif
                    >
                </div>
                @endforeach












                <div class="col-6">
                    <label>موقعیت جغرافیایی</label>
                    <div id="map" style="height: 400px; width: 100%;"></div>
                    <input type="hidden" id="lat" name="lat" value="{{ $organ->lat }}">
                    <input type="hidden" id="lang" name="lang" value="{{ $organ->lang }}">
                </div>
                <br>
                <div class="text-center">
                    <button class="btn btn-success">ویرایش</button>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var lat = parseFloat(document.getElementById('lat').value) || 35.6892;
                        var lng = parseFloat(document.getElementById('lang').value) || 51.3890;

                        var map = L.map('map').setView([lat, lng], 12);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 18,
                        }).addTo(map);

                        var marker = L.marker([lat, lng], { draggable: true }).addTo(map);

                        marker.on('dragend', function (e) {
                            var position = marker.getLatLng();
                            document.getElementById('lat').value = position.lat;
                            document.getElementById('lang').value = position.lng;
                        });
                    });
                </script>







            </div>
        </form>
    </div>
</div>


<script>
    function changeostan(elem) {
        id = elem.value
        states = {!! json_encode($states -> toArray())!!
    }
    for (i = 0;
        i < states.length;
        i++
    ) {
        if (id == states[i].id)
            cities = states[i].cities
    }
    options = ''
    for (j = 0; j < cities.length; j++) {
        options += '<option value="' + cities[j].id + '">' + cities[j].title + '</option>'
    }
    document.getElementById('city').innerHTML = options

    }
</script>
@endsection