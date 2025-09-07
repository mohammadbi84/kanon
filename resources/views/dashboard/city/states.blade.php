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


           <form method="post" action="{{route('state.change')}}">
               @CSRF
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>استان</th>

                        <th>وضعیت</th>

                        <th class="text-center">شهرها</th>
                    </tr>
                    @foreach($items as $ff)
                    <tr>
                    <td> {{$ff->title}} </td>
                        <td>
                            
                <input type="checkbox" @if($ff->active==1) checked @endif name={{$ff->id}}>
                        </td>
                        <td><a class="btn btn-info btn-block" href="/dashboard/city/city?id={{$ff->id}}">
                            شهرها
                            </a></td>
                    </tr>
                    @endforeach
                    
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan='3'>
                                <button type="submit" class="btn btn-warning btn-block">save</button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
            </form>
        </div>
    </div>

@endsection
