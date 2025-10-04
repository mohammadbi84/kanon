@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <form action="{{ route('admin.jobtype.store') }}" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                id="form-add-new-record">
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
            <table class="dt-select-table jobTypes table">
                <thead>
                    <tr>
                        {{-- filled with ajax --}}
                    </tr>
                </thead>
            </table>
            <div id="bulk-actions" class="">
                <button id="bulk-delete" class="btn btn-danger" disabled>حذف انتخابی‌ها</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
