@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded my-4 mb-2"
                                src="{{ asset($academy->logo ?? 'site/public/svgs/user.svg') }}" height="110" width="110"
                                alt="User avatar">
                            <div class="user-info text-center">
                                <h5 class="mb-2">{{ $academy->name }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-0 mt-0">
                        <div class="d-flex align-items-center me-4 mt-3 gap-3">
                            <span class="badge bg-label-primary p-2 rounded mt-1"><i class="bx bx-heart bx-sm"></i></span>
                            <div>
                                <h5 class="mb-0">1.23k</h5>
                                <span>لایک</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3 gap-3">
                            <span class="badge bg-label-primary p-2 rounded mt-1"><i class="bx bx-news bx-sm"></i></span>
                            <div>
                                <h5 class="mb-0">568</h5>
                                <span>آگهی پخش شده</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4 secondary-font">جزئیات</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">شماره شناسایی :</span>
                                <span>{{ $academy->id_number }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">موسس :</span>
                                <span>{{ $academy->manager->name . ' ' . $academy->manager->family }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">وضعیت :</span>
                                @switch($academy->status)
                                    @case('approved')
                                        <span class="badge bg-label-success">فعال</span>
                                    @break

                                    @case('rejected')
                                        <span class="badge bg-label-danger">رد شده</span>
                                    @break

                                    @case('suspended')
                                        <span class="badge bg-label-warning">معلق</span>
                                    @break

                                    @default
                                        <span class="badge bg-label-warning">در انتظار تایید</span>
                                @endswitch
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">تلفن :</span>
                                <span>{{ $academy->phone }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">محل آموزشگاه :</span>
                                <span>استان {{ $academy->state->title }} - شهر {{ $academy->city->title }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">آدرس :</span>
                                <span>{{ $academy->address }}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center pt-3">
                            <a href="#" class="btn btn-primary me-3">ویرایش</a>
                            <a href="#" class="btn btn-label-danger suspend-user">تعلیق</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card -->
            <!-- Plan Card -->
            {{-- <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-label-primary">استاندارد</span>
                        <div class="d-flex justify-content-center align-items-center">
                            <sup class="h5 pricing-currency mt-3 mt-sm-4 mb-0 me-1 text-primary">هزار تومان</sup>
                            <h1 class="display-3 fw-normal mb-0 text-primary">99</h1>
                            <sub class="fs-6 pricing-duration mt-auto mb-4">/ ماهانه</sub>
                        </div>
                    </div>
                    <ul class="ps-3 g-2 mb-3 lh-1-85">
                        <li class="mb-2">10 کاربر</li>
                        <li class="mb-2">تا 10 گیگابایت فضا</li>
                        <li>پشتیبانی پایه</li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">روز</h6>
                        <h6 class="mb-0">65% تمام شده</h6>
                    </div>
                    <div class="progress mb-3" style="height: 8px">
                        <div class="progress-bar" role="progressbar" style="width: 35%" aria-valuenow="65" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                    <span>4 روز باقی مانده</span>
                    <div class="d-grid w-100 mt-3 pt-2">
                        <button class="btn btn-primary" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">
                            ارتقای پلن
                        </button>
                    </div>
                </div>
            </div> --}}
            <!-- /Plan Card -->
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Pills -->
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active my-1 my-md-0" href="javascript:void(0);"><i
                            class="bx bx-user me-1"></i>حساب</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bx bx-lock-alt me-1"></i>امنیت <small class="text-danger mx-2">(به زودی)</small></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bx bx-detail me-1"></i>تراکنش ها <small class="text-danger mx-2">(به زودی)</small></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bx bx-user me-1"></i>اعضای آموزشگاه <small class="text-danger mx-2">(به زودی)</small></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bx bx-info-circle me-1"></i>اطلاعات بیشتر <small class="text-danger mx-2">(به زودی)</small></a>
                </li>
            </ul>
            <!--/ User Pills -->

            <!-- Project table -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">لیست آگهی های آموزشگاه</h5>
                </div>
                <div class="table-responsive mb-3">
                    <table class="table datatable-project border-top">
                        <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>عنوان اگهی</th>
                                <th>موقعیت آگهی</th>
                                <th>وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($academy->advertisements as $advertisement)
                                <tr>
                                    <td>{{$advertisement->id}}</td>
                                    <td>{{$advertisement->title}}</td>
                                    <td>{{$advertisement->position->name}}</td>
                                    <td>{{$advertisement->status}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Project table -->
        </div>
        <!--/ User Content -->
    </div>

    <!-- Add New Credit Card Modal -->
    <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4 mt-0 mt-md-n2">
                        <h3 class="secondary-font">ارتقای پلن</h3>
                        <p>بهترین پلن برای کاربر را انتخاب کنید.</p>
                    </div>
                    <form id="upgradePlanForm" class="row g-3" onsubmit="return false">
                        <div class="col-sm-9">
                            <label class="form-label" for="choosePlan">انتخاب پلن</label>
                            <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                                <option selected>انتخاب پلن</option>
                                <option value="standard">استاندارد - 99,000 تومان ماهانه</option>
                                <option value="exclusive">اختصاصی - 249,000 تومان ماهانه</option>
                                <option value="Enterprise">سازمانی - 499,000 تومان ماهانه</option>
                            </select>
                        </div>
                        <div class="col-sm-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">ارتقا</button>
                        </div>
                    </form>
                </div>
                <hr class="mx-md-n5 mx-n3">
                <div class="modal-body">
                    <h6 class="mb-0">پلن کنونی کاربر پلن استاندارد است</h6>
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-md-n2">
                        <div class="d-flex justify-content-center align-items-center me-2 mt-2">
                            <sup class="h5 pricing-currency fw-normal pt-2 mt-4 mb-0 me-1 text-primary">هزار تومان</sup>
                            <h1 class="fw-normal display-1 mb-0 text-primary">99</h1>
                            <sub class="h5 pricing-duration mt-auto mb-3">/ ماهانه</sub>
                        </div>
                        <button class="btn btn-label-danger cancel-subscription mt-3">لغو اشتراک</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add New Credit Card Modal -->
@endsection
@section('script')
    <script>
        var dt_project_table = $('.datatable-project');

        // Project datatable
        // --------------------------------------------------------------------
        if (dt_project_table.length) {
            var dt_project = dt_project_table.DataTable({
                order: [
                    [1, 'desc']
                ],
                dom: '<"d-flex justify-content-between align-items-center flex-column flex-sm-row mx-4 row"' +
                    '>t' +
                    '<"d-flex justify-content-between mx-4 row"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                language: {
                    sLengthMenu: 'نمایش _MENU_',
                    // search: '',
                },
                // For responsive popup
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'جزئیات پروژه';
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !==
                                    '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ?
                                    '<tr data-dt-row="' +
                                    col.rowIndex +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                }
            });
        }
    </script>
@endsection
