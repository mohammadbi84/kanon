@extends('dashboard.layout.master')
@section('content')


    <form action="/a">
        <input type="text" name="name" id="" value="{{old('name')}}">
        {!! $errors->first('name', '<span class="">:message</span>') !!}
        <input type="text" name="family" id="" value="{{old('family')}}">
        {!! $errors->first('family', '<span class="">:message</span>') !!}
        <button>save</button>
    </form>
    @if(session()->has('success'))
        <div class="">
            {{ session()->get('success') }}
        </div>
    @endif
@endsection
