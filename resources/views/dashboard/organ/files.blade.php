@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">


            <div class="row">
                <div class="col-md-4">
                    <h5>موسس</h5>
                    <img width="100%" src="{{asset($organ->file_moases)}}" alt="">
                </div>

                <div class="col-md-4">
                    <h5>تاسیس</h5>
                    <img width="100%" src="{{asset($organ->file_tasis)}}" alt="">
                </div>


                <div class="col-md-4">
                    <h5>لوگو</h5>
                    <img width="100%" src="{{asset($organ->file_logo)}}" alt="">
                </div>
            </div>
            <hr>
            <div class="widget-header">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form action="{{route('organ.files.post')}}"  method="post" enctype="multipart/form-data">
                            @CSRF
                            {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">file</span>
                                </div>
                                <input type="file" class="form-control" name="file" aria-label="Username">

                            </div>

                            <button type="submit" class="btn btn-success ">ذخیره</button>

                        </form>
                    </div>

                </div>

            </div>
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>عکس</th>

                        <th class="text-center">عملیات</th>
                    </tr>
                    @foreach($files as $ff)
                    <tr>
                    <td><img src="{{asset($ff->file)}}" height="150px" alt=""> </td>
                        <td>

                        </td>
                    </tr>
                    @endforeach
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection
