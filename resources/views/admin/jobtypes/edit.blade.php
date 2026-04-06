@extends('admin.layout.master')
@section('head')
@endsection
@section('content')
    <h5 class="breadcrumb-wrapper mb-4">
        <a href="{{ route('admin.index') }}" class="text-muted">داشبورد</a> <span class="text-muted">/</span>
        <a href="{{ route('admin.jobtype.index') }}" class="text-muted">نوع شغل</a> <span class="text-muted">/</span>
        <span class="">{{ $job->name }}</span>
        <span class="text-muted">/ ویرایش</span>
    </h5>
    <div class="card">
        <form action="{{ route('admin.jobtype.update', ['id' => $job->id]) }}" method="post" class="add-new-record row g-2 p-5"
            id="form-add-new-record">
            @csrf
            <div class="col-sm-12">
                <label class="form-label" for="name">نام نوع شغل</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="name" class="form-control dt-full-name" name="name"
                        value="{{ old('name', $job->name) }}" placeholder="نام نوع شغل" aria-label="John Doe"
                        aria-describedby="name2">
                </div>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-12 mt-3">
                <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">ثبت</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
@endsection
