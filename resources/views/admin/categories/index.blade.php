@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{route('admin.index')}}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <span>رسته ها</span>
    </h5>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <form action="{{ route('admin.categories.store') }}" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                id="form-add-new-record">
                <div class="col-sm-12">
                    <label class="form-label" for="name">نام رسته</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="name" class="form-control dt-full-name" name="name"
                            placeholder="نام رسته" aria-label="John Doe" aria-describedby="name2">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                </div>
            </form>
            <table class="dt-select-table categories table">
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
