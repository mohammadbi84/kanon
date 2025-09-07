@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    {{--    add--}}
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 ">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>افزودن آموزشگاه جدید به {{$organ->name}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{route('school.addpost',['o_id'=>$organ->id])}}" method="post">
                    @CSRF
                    <div class="row">
                        <div class="col-md-6">
                            {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">نام</span>
                                </div>
                                <input type="text" class="form-control" name="name" aria-label="Username" value="{{old('name')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('number', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">شماره شناسایی</span>
                                </div>
                                <input type="text" class="form-control" name="number" aria-label="Username" value="{{old('name')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('sodor', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">شماره صدور</span>
                                </div>
                                <input type="text" class="form-control" name="sodor" aria-label="Username" value="{{old('name')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('sodor_start', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">شروع صدور</span>
                                </div>
                                <input type="text" class="form-control" name="sodor_start" aria-label="Username" value="{{old('name')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('sodor_end', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">پایان صدور</span>
                                </div>
                                <input type="text" class="form-control" name="sodor_end" aria-label="Username" value="{{old('name')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('address', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">آدرس</span>
                                </div>
                                <textarea  class="form-control" name="address" aria-label="Username">{{old('name')}}</textarea>

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('tel', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">شماره تماس</span>
                                </div>
                                <input type="text" class="form-control" name="tel" aria-label="Username" value="{{old('tel')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('fax', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">فکس</span>
                                </div>
                                <input type="text" class="form-control" name="fax" aria-label="Username" value="{{old('fax')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('mobile', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">موبایل</span>
                                </div>
                                <input type="text" class="form-control" name="mobile" aria-label="Username" value="{{old('mobile')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('email', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">EMAIL</span>
                                </div>
                                <input type="text" class="form-control" name="email" aria-label="Username" value="{{old('email')}}" >

                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! $errors->first('site', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">SITE</span>
                                </div>
                                <input type="text" class="form-control" name="site" aria-label="Username" value="{{old('site')}}" >

                            </div>
                        </div>

                        
                    </div>


                    <button type="submit" class="btn btn-success ">ذخیره</button>
                </form>
            </div>


        </div>
    </div>


@endsection
