@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <!-- Popular Articles -->
    <div class="help-center-popular-articles py-5 pt-0">
        <div class="container-xl">
            <h4 class="text-center pb-3 secondary-font">انتخاب موقعیت آگهی</h4>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="row mb-3">
                        @foreach ($positions as $position)
                            <div class="col-md-4 mb-4">
                                <div class="card border shadow-none">
                                    <div class="card-body text-center">
                                        <h4>
                                            {{ $position->name }}
                                        </h4>
                                        <div class="text-start">
                                            <p class="text-warning">
                                                <span
                                                    class="badge bg-label-warning me-1">{{ $position->advertisements()->where('status', 'pending_review')->count() }}</span>
                                                <a href="{{ route('admin.positions.advertisements', ['position' => $position, 'status' => 'pending_review']) }}"
                                                    class="text-warning">
                                                    آگهی در انتظار تایید
                                                </a>
                                            </p>
                                            <p class="text-success">
                                                <span
                                                    class="badge bg-label-success me-1">{{ $position->advertisements()->where('status', ['approved', 'active'])->count() }}</span>
                                                <a href="{{ route('admin.positions.advertisements', ['position' => $position, 'status' => 'approved']) }}"
                                                    class="text-success">
                                                    آگهی تایید شده
                                                </a>
                                            </p>
                                        </div>
                                        <a class="btn btn-label-primary w-100"
                                            href="{{ route('admin.positions.advertisements', ['position' => $position]) }}">مشاهده
                                            همه آگهی ها</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Popular Articles -->
@endsection
@section('script')
@endsection
