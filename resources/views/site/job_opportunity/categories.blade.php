@extends('site.layout.master')
@section('head')
    <title>فرصت های شغلی</title>
    <style>
        body{
            background: #f2f2f2 !important;
        }
        .item-col {
            background: #fff;
            /* background: #111f4c; */
            display: flex;
            flex-direction: column;
        }

        .count-span {
            background: #e699263e;
            color: #e69926;
        }
    </style>
@endsection
@section('content')
    @php
        $chunks = $groups->chunk(ceil($groups->count() / 3)); // تقسیم به 3 قسمت
    @endphp
    <div class="container wrapper mb-5" style="padding-top: 120px !important">
        <h3 class="text-center">عنوان اصلی وسط صفحه</h3>
        <p class="text-center text-muted mb-4">متن فرعی زیر عنوان اصلی به صورت وسط چین و جاستیفای با رنگ کمرنگ تر از اصلی</p>
        <div class="row gap-3">
            @foreach ($chunks as $chunk)
                <div class="col item-col rounded-3 p-3 gap-2">
                    @foreach ($chunk as $group)
                        <a href="#" class="text-decoration-none text-reset">
                            <div class="border rounded-3 d-flex justify-content-between px-3 py-2" style="background: #f8f9fc">
                                <div class="text">{{ $group->name }}</div>
                                <div>
                                    <span class="badge count-span">{{ $group->organs->count() ?? 0 }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
@endsection
