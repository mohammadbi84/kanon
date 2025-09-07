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


           <form method="post" action="{{route('city.change')}}">
               @CSRF
               <input hidden value="{{$id}}" name="city">
            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>استان</th>

                        <th>وضعیت</th>

                     </tr>
                    @foreach($items as $ff)
                    <tr>
                    <td> {{$ff->title}} </td>
                        <td>
                            
                <input type="checkbox" @if($ff->active==1) checked @endif name={{$ff->id}}>
                        </td>
                      
                    </tr>
                    @endforeach
                    
                    </thead>
                    <tbody>
                        <tr>
                             <td colspan='2'>
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
