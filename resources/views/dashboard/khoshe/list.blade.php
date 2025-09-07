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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/dashboard/home">خانه</a></li>
                  <li class="breadcrumb-item"><a href="#">مدریت استاندارد ها</a></li>
                  <li class="breadcrumb-item active" aria-current="page">خوشه ها</li>
                </ol>
              </nav>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>افزودن خوشه جدید</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <form action="{{route('khoshe.addpost')}}" method="post">
                    @CSRF
                    {!! $errors->first('name', '<p class="text-danger" >:message</p>') !!}
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">نام</span>
                        </div>
                        <input type="text" class="form-control" name="name" aria-label="Username">

                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon5">رسته</span>
                        </div>
                        <select name="type" class="js-example-basic-single form-control" style="flex-grow: 1;" aria-label="Username">
                            @foreach($standards as $standard)
                                <option value="{{$standard->id}}">{{$standard->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <button type="submit" class="btn btn-success ">ذخیره</button>

                </form>
            </div>

            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>لیست خوشه ها</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4 mt-4">
                <form id="bulk-delete-form" method="POST" action="{{ route('khoshe.bulk-delete') }}">
                    @csrf
                    <table id="default-ordering" class="table table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th> <!-- چک‌باکس انتخاب همه -->
                            <th>ردیف</th>
                            <th>عنوان خوشه</th>
                            <th>رسته</th>
                            <th>تعداد رشته</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $item)
                        <tr>
                            <td><input type="checkbox" name="selected_items[]" value="{{ $item->id }}"></td>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item['standard'] }}</td>
                            <td>{{ $item['group'] }}</td>
                            <td class="text-center">
                                <div>
                                    <a href="{{ route('khoshe.edit', ['id' => $item->id]) }}" class="btn btn-primary">مشاهده و ویرایش</a>
                                    <a href="{{ route('khoshe.delete', ['id' => $item->id]) }}" class="btn btn-danger">حذف</a>
                                    <a href="{{ route('group.list', ['id' => $item->id]) }}" class="btn btn-info">رشته ها</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-danger mt-2">حذف انتخاب‌شده‌ها</button>
                </form>

                <script>
                    document.getElementById('select-all').addEventListener('change', function (e) {
                        let checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
                        checkboxes.forEach(cb => cb.checked = e.target.checked);
                    });
                </script>

            </div>
        </div>
    </div>

@endsection
