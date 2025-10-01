@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <form action="{{route('admin.jobtype.store')}}" method="post" class="add-new-record pt-0 row g-2 mt-3" id="form-add-new-record">
                <div class="col-sm-12">
                    <label class="form-label" for="name">نام نوع شغل</label>
                    <div class="input-group input-group-merge">
                        <span id="name2" class="input-group-text"><i class="bx bx-briefcase-alt-2"></i></span>
                        <input type="text" id="name" class="form-control dt-full-name" name="name"
                            placeholder="نام نوع شغل" aria-label="John Doe" aria-describedby="name2">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                </div>
            </form>
            <table class="datatables-basic jobTypes table">
                <thead>
                    <tr>
                        {{-- filled with ajax --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal to add new record -->
    {{-- <div class="offcanvas offcanvas-end" id="add-new-record">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="exampleModalLabel">نوع شغل جدید</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form action="{{route('admin.jobtype.store')}}" method="post" class="add-new-record pt-0 row g-2" id="form-add-new-record">
                <div class="col-sm-12">
                    <label class="form-label" for="name">نام نوع شغل</label>
                    <div class="input-group input-group-merge">
                        <span id="name2" class="input-group-text"><i class="bx bx-briefcase-alt-2"></i></span>
                        <input type="text" id="name" class="form-control dt-full-name" name="name"
                            placeholder="نام نوع شغل" aria-label="John Doe" aria-describedby="name2">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">انصراف</button>
                </div>
            </form>
        </div>
    </div> --}}
@endsection
@section('script')
@endsection
