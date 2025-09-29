@extends('admin.layout.master')
@section('head')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">آمار وب‌سایت</h5>
                    <div class="dropdown primary-font">
                        <button class="btn p-0" type="button" id="analyticsOptions" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="analyticsOptions">
                            <a class="dropdown-item" href="javascript:void(0);">انتخاب همه</a>
                            <a class="dropdown-item" href="javascript:void(0);">تازه سازی</a>
                            <a class="dropdown-item" href="javascript:void(0);">اشتراک گذاری</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-2">
                    <div class="d-flex justify-content-around align-items-center flex-wrap mb-4">
                        <div class="user-analytics text-center me-2">
                            <i class="bx bx-user me-1"></i>
                            <span>کاربران</span>
                            <div class="d-flex align-items-center mt-2">
                                <div class="chart-report" data-color="success" data-series="35"></div>
                                <h3 class="mb-0">61K</h3>
                            </div>
                        </div>
                        <div class="sessions-analytics text-center me-2">
                            <i class="bx bx-pie-chart-alt me-1"></i>
                            <span>جلسات</span>
                            <div class="d-flex align-items-center mt-2">
                                <div class="chart-report" data-color="warning" data-series="76"></div>
                                <h3 class="mb-0">92K</h3>
                            </div>
                        </div>
                        <div class="bounce-rate-analytics text-center">
                            <i class="bx bx-trending-up me-1"></i>
                            <span>نرخ نوسان</span>
                            <div class="d-flex align-items-center mt-2">
                                <div class="chart-report" data-color="danger" data-series="65"></div>
                                <h3 class="mb-0">72.6%</h3>
                            </div>
                        </div>
                    </div>
                    <div id="analyticsBarChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('admin/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection
