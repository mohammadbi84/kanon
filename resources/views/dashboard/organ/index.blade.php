@extends('dashboard.layout.master')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/dashboard/plugins/table/datatable/dt-global_style.css') }}">
    <style>
        .modal-lg {
            max-width: 90%;
        }

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .detail-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .detail-value {
            margin-bottom: 15px;
        }

        .detail-section {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <a href="#" class="btn btn-success">افزودن آموزشگاه</a>
            <br><br>

            <div class="widget-header">
                <h6>لیست آموزشگاه‌ها</h6>
            </div>

            <div class="table-responsive mb-4 mt-4">
                <table id="default-ordering" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام آموزشگاه</th>
                            <th>شماره شناسایی</th>
                            <th>استان</th>
                            {{-- <th>شهر</th> --}}
                            <th>نام موسس</th>
                            <th>موبایل</th>
                            <th>وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($organs as $key => $organ)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $organ->name }}</td>
                                <td>{{ $organ->number }}</td>
                                {{-- <td>{{ $organ->state ? $organ->stateRelation->title : '-' }}</td> --}}
                                <td>{{ $organ->city ? $organ->cityRelation->title : '-' }}</td>
                                <td>{{ $organ->moases ? $organ->moases->name . ' ' . $organ->moases->family : '-' }}</td>
                                <td>{{ $organ->mobile }}</td>
                                <td class="{{ $organ->ClassStatusText() }}">{{ $organ->StatusText() }}</td>
                                <td class="text-center">

                                    <a class="btn btn-secondary" type="button" data-toggle="modal"
                                        data-target="#detailsModal{{ $organ->id }}">
                                        جزئیات
                                    </a>
                                    <a href="{{ route('organ.edit', $organ->id) }}"
                                        class="btn btn-primary btn-sm">ویرایش</a>
                                    <form method="POST" action="{{ route('organ.destroy', $organ->id) }}"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('آیا از حذف مطمئن هستید؟')"
                                            class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal for Details -->
                            <div class="modal fade" id="detailsModal{{ $organ->id }}"
                                aria-labelledby="detailsModal{{ $organ->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailsModalLabel{{ $organ->id }}">جزئیات
                                                آموزشگاه: {{ $organ->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="detail-section">
                                                <h6>اطلاعات پایه</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="detail-label">نام آموزشگاه:</div>
                                                        <div class="detail-value">{{ $organ->name }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">نوع:</div>
                                                        <div class="detail-value">
                                                            {{ $organ->type == 1 ? 'صنف' : 'آموزشگاه' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">وضعیت:</div>
                                                        <div class="detail-value">{{ $organ->StatusText() }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">متن ارجاع:</div>
                                                        <div class="detail-value">{{ $organ->ReferenceText ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">شناسه سازمان والد:</div>
                                                        <div class="detail-value">{{ $organ->organ_id ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">شماره شناسایی:</div>
                                                        <div class="detail-value">{{ $organ->number }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">شماره صدور:</div>
                                                        <div class="detail-value">{{ $organ->sodor_num }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">تاریخ شروع صدور:</div>
                                                        <div class="detail-value">{{ $organ->sodor_start }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">تاریخ پایان صدور:</div>
                                                        <div class="detail-value">{{ $organ->sodor_end }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">تبصره 34:</div>
                                                        <div class="detail-value">
                                                            {{ $organ->tabsare34 == 1 ? 'دارد' : 'ندارد' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">برادران:</div>
                                                        <div class="detail-value">
                                                            {{ $organ->baradaran == 1 ? 'دارد' : 'ندارد' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">خواهران:</div>
                                                        <div class="detail-value">
                                                            {{ $organ->khaharan == 1 ? 'دارد' : 'ندارد' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">ایجاد شده در:</div>
                                                        <div class="detail-value">{{ $organ->created_at }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">به‌روزرسانی شده در:</div>
                                                        <div class="detail-value">{{ $organ->updated_at }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="detail-section">
                                                <h6>اطلاعات تماس</h6>
                                                <div class="row">
                                                    {{-- <div class="col-md-6">
                                                        <div class="detail-label">استان:</div>
                                                        <div class="detail-value">{{ $organ->state ? $organ->stateRelation->title : '-' }}</div>
                                                    </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="detail-label">شهر:</div>
                                                        <div class="detail-value">
                                                            {{ $organ->city ? $organ->cityRelation->title : '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">آدرس:</div>
                                                        <div class="detail-value">{{ $organ->address ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">کدپستی:</div>
                                                        <div class="detail-value">{{ $organ->postal }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">تلفن:</div>
                                                        <div class="detail-value">{{ $organ->tel }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">فکس:</div>
                                                        <div class="detail-value">{{ $organ->fax ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">موبایل:</div>
                                                        <div class="detail-value">{{ $organ->mobile }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">ایمیل:</div>
                                                        <div class="detail-value">{{ $organ->email ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">سایت:</div>
                                                        <div class="detail-value">{{ $organ->site ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="detail-section">
                                                <h6>موقعیت جغرافیایی</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="detail-label">عرض جغرافیایی:</div>
                                                        <div class="detail-value">{{ $organ->lat }}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="detail-label">طول جغرافیایی:</div>
                                                        <div class="detail-value">{{ $organ->lang }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="detail-section">
                                                <h6>اطلاعات موسس</h6>
                                                @if ($organ->moases)
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="detail-label">نام:</div>
                                                            <div class="detail-value">{{ $organ->moases->name ?? '-' }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-label">نام خانوادگی:</div>
                                                            <div class="detail-value">{{ $organ->moases->family ?? '-' }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-label">کدملی:</div>
                                                            <div class="detail-value">
                                                                {{ $organ->moases->national_code ?? '-' }}</div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-label">شماره شناسنامه:</div>
                                                            <div class="detail-value">
                                                                {{ $organ->moases->shenasname ?? '-' }}</div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-label">جنسیت:</div>
                                                            <div class="detail-value">
                                                                {{ $organ->moases->gender == 1 ? 'مرد' : ($organ->moases->gender == 2 ? 'زن' : '-') }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-label">نام پدر:</div>
                                                            <div class="detail-value">{{ $organ->moases->father ?? '-' }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-label">تاریخ تولد:</div>
                                                            <div class="detail-value">
                                                                {{ $organ->moases->birthday ?? '-' }}</div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-label">محل صدور:</div>
                                                            <div class="detail-value">{{ $organ->moases->sadere ?? '-' }}
                                                            </div>
                                                        </div>
                                                        @if ($organ->moases->sherkat_name)
                                                            <div class="col-md-6">
                                                                <div class="detail-label">نام شرکت:</div>
                                                                <div class="detail-value">
                                                                    {{ $organ->moases->sherkat_name }}</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="detail-label">شماره ثبت:</div>
                                                                <div class="detail-value">
                                                                    {{ $organ->moases->sherkat_sab }}</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="detail-label">مدیرعامل:</div>
                                                                <div class="detail-value">
                                                                    {{ $organ->moases->sherkat_modir }}</div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="detail-label">تاریخ ثبت:</div>
                                                                <div class="detail-value">
                                                                    {{ $organ->moases->sherkat_tarikh }}</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="detail-value">اطلاعات موسس ثبت نشده است.</div>
                                                @endif
                                            </div>

                                            <div class="detail-section">
                                                <h6>حرفه‌ها</h6>
                                                <div class="detail-value">
                                                    @if ($organ->herfes->isNotEmpty())
                                                        <ul>
                                                            @foreach ($organ->herfes as $herfe)
                                                                <li>{{ $herfe->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        حرفه‌ای ثبت نشده است.
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="detail-section">
                                                <h6>فایل‌ها</h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="detail-label">تصویر موسس:</div>
                                                        <div class="detail-value">
                                                            @if ($organ->file_moases)
                                                                <a href="{{ asset($organ->file_moases) }}"
                                                                    target="_blank">مشاهده فایل</a>
                                                            @else
                                                                فایل ثبت نشده است.
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="detail-label">پروانه تاسیس:</div>
                                                        <div class="detail-value">
                                                            @if ($organ->file_tasis)
                                                                <a href="{{ asset($organ->file_tasis) }}"
                                                                    target="_blank">مشاهده فایل</a>
                                                            @else
                                                                فایل ثبت نشده است.
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="detail-label">لوگو:</div>
                                                        <div class="detail-value">
                                                            @if ($organ->file_logo)
                                                                <a href="{{ asset($organ->file_logo) }}"
                                                                    target="_blank">مشاهده فایل</a>
                                                            @else
                                                                فایل ثبت نشده است.
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('organ.status', ['organ' => $organ]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-danger mx-2" name="status"
                                                    value="2">رد سازمان</button>
                                                <button type="submit" class="btn btn-success mx-2" name="status"
                                                    value="1">تایید سازمان</button>
                                            </form>
                                            <button type="button" class="btn btn-danger mx-2"
                                                data-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/dashboard/plugins/table/datatable/datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#default-ordering').DataTable({
                "ordering": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Persian.json"
                }
            });
        });
    </script>
@endsection
