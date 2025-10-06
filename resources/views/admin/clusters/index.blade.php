@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0 p-3">
            <div class="head-label p-3"></div>
            <form action="{{ route('admin.clusters.store') }}" method="post" class="add-new-record pt-0 row g-2 mt-3 px-3"
                id="form-add-new-record">
                @csrf

                {{-- فیلد نام خوشه --}}
                <div class="col-sm-12">
                    <label class="form-label" for="name">نام خوشه</label>
                    <div class="input-group input-group-merge">
                        <span id="name2" class="input-group-text">
                            <i class="bx bx-check-square"></i>
                        </span>
                        <input type="text" id="name" class="form-control dt-full-name" name="name"
                            placeholder="نام خوشه" required>
                    </div>
                </div>

                {{-- فیلد انتخاب رسته (دینامیک بر اساس پارامتر URL) --}}
                @php
                    $categoryId = request()->get('category_id');
                @endphp

                @if (!$categoryId)
                    {{-- اگر category_id در URL نبود --}}
                    <div class="col-sm-12 mt-3">
                        <label class="form-label" for="category_id">انتخاب رسته</label>
                        <select id="category_id" name="category_id" class="form-select select2" required>
                            <option value="" selected disabled>انتخاب کنید...</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
                </div>
            </form>

            <table class="dt-select-table clusters table">
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
