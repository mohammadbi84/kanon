@extends('panel.layout.master')
@section('head')
    <title>حساب کاربری</title>
    <style>
        body {
            background-color: #f5f6f9;
            font-family: sans-serif;
        }

        .card-box {
            border-radius: 20px;
            padding: 25px;
            background: white;
            height: 100%;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 15px;
        }

        .rounded-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #3b82f6;
        }

        .badge-style {
            background: #f1f5f9;
            font-size: 0.8rem;
            padding: 3px 10px;
            border-radius: 10px;
        }

        .text-light-blue {
            color: #3b82f6;
        }
    </style>
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container mb-5 py-5" style="margin-top: 70px">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="row p-4 rounded-3 shadow bg-white border">
                    <!-- آیکون ها -->
                    <div class="col-md-9">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="card-box text-center bg-light">
                                    <img src="https://i.ibb.co/zP0sZp2/avatar.png" alt="avatar"
                                        class="rounded-avatar mb-2">
                                    <div class="fw-bold mt-3">آموزشگاه فاضل</div>
                                    <div class="text-muted small mt-1">09927501130</div>
                                    <button class="btn btn-primary btn-sm mt-3">تکمیل پروفایل</button>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row h-100 flex-wrap align-content-around">
                                    <div class="col-12">
                                        <div class="card-box bg-light rounded-4">
                                            <div>
                                                <div class="fw-bold my-3">موجودی شما</div>
                                                <small class="text-muted"> 0 تومان</small>
                                            </div>
                                            <div class="text-center">
                                                <button
                                                    class="btn btn-light bg-white border px-3 p-2 rounded-pill btn-sm mt-4 mx-auto">
                                                    <i class="fas fa-plus"></i> افزایش موجودی
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-box d-flex align-items-center justify-content-between rounded-4"
                                                style="background-color: #ECFFEC;">
                                                <div class="icon-box bg-success bg-opacity-25 text-success">
                                                    <i class="fa-solid fa-dollar-sign"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">تراکنش ها</div>
                                                    <div class="fw-bold text-success">0</div>
                                                </div>
                                                <i class="bi bi-chevron-left text-success"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row h-100">
                                    <div class="col-12 mb-2">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-box d-flex align-items-center justify-content-between rounded-4"
                                                style="background-color: #FFF9D9;">
                                                <div class="icon-box bg-warning bg-opacity-25 text-warning">
                                                    <i class="bi bi-camera-video-fill"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">تبلیغات</div>
                                                    <div class="fw-bold text-warning">0</div>
                                                </div>
                                                <i class="bi bi-chevron-left text-warning"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-box d-flex align-items-center justify-content-between rounded-4"
                                                style="background-color: #E4F9FF;">
                                                <div class="icon-box bg-primary bg-opacity-25">
                                                    <i class="bi bi-file-earmark-text-fill" style="color: #0D6EFD"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">آگهی ها</div>
                                                    <div class="fw-bold" style="color: #0D6EFD">0</div>
                                                </div>
                                                <i class="bi bi-chevron-left text-primary"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12">
                                        <a href="#" class="text-decoration-none">
                                            <div class="card-box d-flex align-items-center justify-content-between rounded-4"
                                                style="background-color: #FEF2F2;">
                                                <div class="icon-box bg-danger bg-opacity-25 text-danger">
                                                    <i class="bi bi-heart-fill"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">لایک ها</div>
                                                    <div class="fw-bold text-danger">0</div>
                                                </div>
                                                <i class="bi bi-chevron-left text-danger"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- اشتراک -->
                    <div class="col-md-3">
                        <div class="card-box text-white text-center align-content-center" style="background: #1654CD;">
                            <h5 class="fw-bold mb-4 text-warning">شما اشتراک ندارید!</h5>
                            <p class="mb-4 p-1 rounded-pill text-center" style="background-color: #2563EB;">با خرید
                                اشتراک تا ۷۸٪
                                تخفیف نسبت به خرید تکی دریافت کنید</p>
                            <button class="btn btn-light text-primary rounded-pill">خرید اشتراک</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="row mt-4 p-2 px-0">
                    <div class="col-md-4 pe-0">
                        <div class="border rounded-3 bg-white shadow p-3">
                            <p>متن تستی</p>
                        </div>
                    </div>
                    <div class="col-md-8 ps-0">
                        <div class="border rounded-3 bg-white shadow p-3 m-0 h-100">
                            <h4>آگهی های اخیر</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>

        </div>

    </div>
@endsection
@section('script')
@endsection
