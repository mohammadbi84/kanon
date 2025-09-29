@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>شناسه</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>تاریخ</th>
                        <th>حقوق</th>
                        <th>وضعیت</th>
                        <th>عمل</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal to add new record -->
    <div class="offcanvas offcanvas-end" id="add-new-record">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="exampleModalLabel">رکورد جدید</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                <div class="col-sm-12">
                    <label class="form-label" for="basicFullname">نام کامل</label>
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" id="basicFullname" class="form-control dt-full-name" name="basicFullname"
                            placeholder="جان اسنو" aria-label="John Doe" aria-describedby="basicFullname2">
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label" for="basicPost">مطلب</label>
                    <div class="input-group input-group-merge">
                        <span id="basicPost2" class="input-group-text"><i class="bx bxs-briefcase"></i></span>
                        <input type="text" id="basicPost" name="basicPost" class="form-control dt-post"
                            placeholder="توسعه دهنده وب" aria-label="Web Developer" aria-describedby="basicPost2">
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label" for="basicEmail">ایمیل</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                        <input type="text" id="basicEmail" name="basicEmail" class="form-control dt-email text-start"
                            placeholder="john.doe@example.com" aria-label="john.doe@example.com" dir="ltr">
                    </div>
                    <div class="form-text">می‌توانید از حروف، اعداد و نقطه استفاده کنید</div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label" for="basicDate">تاریخ عضویت</label>
                    <div class="input-group input-group-merge">
                        <span id="basicDate2" class="input-group-text"><i class="bx bx-calendar"></i></span>
                        <input type="text" class="form-control dt-date" id="basicDate" name="basicDate"
                            aria-describedby="basicDate2" placeholder="MM/DD/YYYY" aria-label="MM/DD/YYYY">
                    </div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label" for="basicSalary">حقوق</label>
                    <div class="input-group input-group-merge">
                        <span id="basicSalary2" class="input-group-text">تومان</span>
                        <input type="number" id="basicSalary" name="basicSalary" class="form-control dt-salary"
                            placeholder="12000" aria-label="12000" aria-describedby="basicSalary2">
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">انصراف</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
