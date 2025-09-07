@extends('dashboard.layout.master')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/dt-global_style.css') }}">
    <style>
        .form-control { padding: 0 }
    </style>
@endsection

@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h6>آموزشگاه ها</h6>
                </div>
            </div>
        </div>

        <div class="table-responsive mb-4 mt-4">
            <table id="default-ordering" class="table table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>شناسه</th>
                        <th>نام</th>
                        <th>عملیات</th>
                        <th>وضعیت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schools as $key => $item)
                    <tr class="text-center">
                        <td>{{$key + 1}}</td>
                        <td>{{$item->name}}</td>
                        <td>
                            
                            <a @if ($item->status==null || $item->status=='0' || $item->status=='1' || $item->status=='4') href="/dashboard/asnaf/schools-show/{{$item->id}}" @else href='#' @endif  class="btn btn-primary">نمایش</a>
                            @if ($item->status=='0' || $item->status==null)
                            <a  href="/dashboard/asnaf/school-active/{{$item->id}}"  class="btn btn-success">تایید</a>
                              @endif
                              
                              @if ($item->status=='0' || $item->status==null)
                            <a  href="/dashboard/asnaf/school-delete/{{$item->id}}"   class="btn btn-danger">رد کردن</a>
                            @endif
                            
                            @if ($item->status == '0')
                            <a href="#"  onclick="openModal({{ $item->id }})"  class="btn btn-warning">
                                ارجاع به آموزشگاه
                            </a>
                            @endif
                        </td>
                        <td class="{{$item->ClassStatusText()}}">{{$item->StatusText()}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="messageModalLabel">ارسال پیام به آموزشگاه</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                        </div>
                        <div class="modal-body">
                            <form id="sendMessageForm" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="messageContent" class="form-label">پیام</label>
                                    <textarea name="message" id="messageContent" class="form-control" rows="4" placeholder="پیام خود را وارد کنید"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary" form="sendMessageForm">ارسال</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openModal(organId) {
                    const form = document.getElementById("sendMessageForm");
                    form.action = `/dashboard/asnaf/schools-warning/${organId}`;
                    const modal = new bootstrap.Modal(document.getElementById('messageModal'));
                    modal.show();
                }
            </script>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
