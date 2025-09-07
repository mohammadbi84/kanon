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
                        <h6>ویرایش خوشه {{$item->name}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
            <form action="{{route('khoshe.edit',['id'=>$item->id])}}" method="post">
                @CSRF
                {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">نام</span>
                    </div>
                    <input type="text" value="{{$item->name}}" class="form-control" name="name" aria-label="Username">

                </div>

                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon5">استاندارد</span>
                    </div>
                    <select name="type" type="text" class="form-control"  aria-label="Username">
                        @foreach($standards as $standard)
                            <option @if($item->standard_id ==$standard->id) selected @endif value="{{$standard->id}}">{{$standard->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success ">ذخیره</button>

            </form>
            </div>


        </div>
    </div>

@endsection
