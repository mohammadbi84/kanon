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
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>حرفه های اموزشگاه</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{route('organ.herfes.post')}}" method="post">
                    @CSRF
                    <div class="row">
                    @foreach($herfes as $herfe)
                    <div class="col-md-3">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">{{$herfe->name}}
                                <input
                                    @if($herfe['set']==1) checked @endif
                                    type="checkbox" class="form-check" value="{{$herfe->id}}" name="herfe[{{$herfe->id}}]" aria-label="Username">

                            </span>

                        </div>

                    </div>
                    </div>
                    @endforeach
                    </div>
                    <button type="submit" class="btn btn-success ">ذخیره</button>

                </form>
            </div>


        </div>
    </div>

@endsection
