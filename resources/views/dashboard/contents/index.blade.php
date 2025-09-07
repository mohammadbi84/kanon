@extends('dashboard.layout.master')
@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">

            <a href="{{ route('contents.create') }}" class="btn btn-success">افزودن زیرمجموعه</a>
            @if ($title)
            <form action="{{ route('contents.destroyTitle') }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">حذف تیتر اصلی</button>
            </form>

            @endif
            <br><br>
            <div class="col-md-8 offset-md-2">
                <form action="{{ route('contents.storeTitle') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">عنوان تیتر اصلی</label>
                        <input type="text" class="form-control" name="title" id="title" @if ($title) value="{{ $title->title }}" @endif required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">ذخیره تیتر اصلی</button>
                </form>
            </div>
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست مزایا گواهینامه ها</h6>

                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                @if ($title)

                
                    <h3>زیرمجموعه‌ها:</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>عنوان زیرمجموعه</th>
                                <th>متن زیرمجموعه</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($title->children as $child)
                                <tr>
                                    <td>{{ $child->content['title'] ?? '—' }}</td>
                                    <td>{{ $child->content['text'] ?? '—' }}</td>
                                    <td>
                                        <a href="{{ route('contents.edit', $child->id) }}" class="btn btn-primary">ویرایش</a>
                                        <form action="{{ route('contents.destroy', $child->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>تیتر اصلی هنوز اضافه نشده است.</p>
                @endif

            </div>
        </div>
    </div>

@endsection