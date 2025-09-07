@extends('dashboard.layout.master')
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6 ">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6> صنف {{$organ->id}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">


                <div class="card component-card_1">
                    <div class="card-body">
                        <div class="icon-svg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-droplet">
                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
                            </svg>
                        </div>
                        <h5 class="card-title"> تعداد مدارس -{{$schools->count()}}
                            <a href="{{route('pay.all',['id'=>$organ->id])}}" class="btn btn-primary float-right">پرداخت حق عضویت همه</a>
                        </h5>

                        <p class="card-text">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="default-ordering" class="table table-hover" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="text-center">نام</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schools as $item)
                                    <tr>
                                        <td
                                            @if($item->status) style="background-color: green;color: whitesmoke"
                                            @else style="background-color: yellow;"
                                            @endif
                                            class="text-center">{{$item->name}}
                                            @if(!$item->status)
                                                <a class="btn btn-primary" href="{{route('pay',['id'=>$item->id])}}">پرداخت حق اشتراک</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>

                            </table>
                        </div>


                        </p>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>

@endsection
