@extends('dashboard.layout.master')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/plugins/table/datatable/dt-global_style.css')}}">
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            {{-- (Breadcrumbs, title, etc. - same as before) --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard/home">خانه</a></li>
                    <li class="breadcrumb-item"><a href="#">مدریت استاندارد ها</a></li>
                    <li class="breadcrumb-item"><a href="#">پیکر بندی</a></li>
                    <li class="breadcrumb-item active" aria-current="page">نرخ شهریه</li>
                </ol>
            </nav>
            <br>
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h6>مدیریت نرخ شهریه</h6>
                        <br>
                        {{--<a href="{{ route('tuition_herfe.create') }}" class="btn btn-primary">افزودن نرخ جدید</a>--}}
                        <br> <br>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive mb-4 mt-4">
                <form action="{{ route('tuition_herfe.showYear', ['year' => $year]) }}" method="GET" class="text-center mb-4">
                    <input type="hidden" name="year" value="{{ $year }}">
                    <select name="type" class="form-control d-inline-block" style="width: auto;" onchange="this.form.submit()">
                        <option value="" {{ request('type') == '' ? 'selected' : '' }}>نمایش همه</option>
                        <option value="herfe" {{ request('type') == 'herfe' ? 'selected' : '' }}>حرفه‌ها</option>
                        <option value="sanad" {{ request('type') == 'sanad' ? 'selected' : '' }}>سند حرفه‌ها</option>
                    </select>
                </form>
                <br>
                <form id="tuitionForm" action="{{ route('tuition_herfe.updateAll') }}" method="POST">
                    @csrf
                    <style>
                        .edited-input {
                            background-color: #fff3cd !important; /* زرد ملایم */
                        }
                    
                        .edited-row td {
                            background-color: #fff3cd !important;
                        }
                    
                        .server-updated-row td {
                            background-color: #d4edda !important; /* سبز ملایم */
                        }
                    </style>
<table id="default-ordering" class="table table-hover" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>ردیف</th>
            <th>نام (عنوان)</th>
            <th>کد استاندارد</th>
            <th>جمع کل ساعت</th>
            <th>نوع</th>
            <th>رشته</th>
            <th>مبلغ حضوری (ریال)</th>
            <th>مبلغ مجازی (ریال)</th>
            <th>مبلغ الکترونیکی (ریال)</th>
        </tr>
    </thead>
    <tbody>
        <input name="year" value="{{ $year }}" style="display: none;">

        @foreach ($combinedData as $key => $tuition)
            @php
                $isUpdated = $tuition->in_person_fee || $tuition->online_fee || $tuition->electronic_fee;
            @endphp
            @if($tuition->type === 'herfe')
                <tr class="text-center {{ $isUpdated ? 'server-updated-row' : '' }}">
                    <td>{{ $key + 1 }}</td>
                    <input type="hidden" name="tuition_ids[]" value="herfe_{{ $tuition->herfe_id }}">
                    <input type="hidden" name="herfe_id[herfe_{{ $tuition->herfe_id }}]" value="{{ $tuition->herfe_id }}">
                    <td>{{ $tuition->herfe_name }}</td>
                    <td>{{ $tuition->herfe_code }}</td>
                    <td>{{ $tuition->total_time }}</td>
                    <td>حرفه</td>
                    <td>{{ $tuition->group_name }}</td>
                    <td>
                        <input type="text"
                            name="in_person_fee[herfe_{{ $tuition->herfe_id }}][{{ $tuition->herfe_id }}]"
                            value="{{ old('in_person_fee.herfe_' . $tuition->herfe_id . '.' . $tuition->herfe_id, $tuition->in_person_fee) }}"
                            class="form-control price-input">
                    </td>
                    <td>
                        <input type="text"
                            name="online_fee[herfe_{{ $tuition->herfe_id }}][{{ $tuition->herfe_id }}]"
                            value="{{ old('online_fee.herfe_' . $tuition->herfe_id . '.' . $tuition->herfe_id, $tuition->online_fee) }}"
                            class="form-control price-input">
                    </td>
                    <td>
                        <input type="text"
                            name="electronic_fee[herfe_{{ $tuition->herfe_id }}][{{ $tuition->herfe_id }}]"
                            value="{{ old('electronic_fee.herfe_' . $tuition->herfe_id . '.' . $tuition->herfe_id, $tuition->electronic_fee) }}"
                            class="form-control price-input">
                    </td>
                </tr>
            @elseif($tuition->type === 'sanad')
                <tr class="text-center {{ $isUpdated ? 'server-updated-row' : '' }}">
                    <td>{{ $key + 1 }}</td>
                    <input type="hidden" name="tuition_ids[]" value="sanad_{{ $tuition->sanad_id }}">
                    <input type="hidden" name="sanad_id[sanad_{{ $tuition->sanad_id }}]" value="{{ $tuition->sanad_id }}">
                    <td>{{ $tuition->sanad_title }}</td>
                    <td>--</td>
                    <td>--</td>
                    <td>سند حرفه</td>
                    <td>{{ $tuition->group_name }}</td>
                    <td>
                        <input type="text"
                            name="in_person_fee[sanad_{{ $tuition->sanad_id }}][{{ $tuition->sanad_id }}]"
                            value="{{ old('in_person_fee.sanad_' . $tuition->sanad_id . '.' . $tuition->sanad_id, $tuition->in_person_fee) }}"
                            class="form-control price-input">
                    </td>
                    <td>
                        <input type="text"
                            name="online_fee[sanad_{{ $tuition->sanad_id }}][{{ $tuition->sanad_id }}]"
                            value="{{ old('online_fee.sanad_' . $tuition->sanad_id . '.' . $tuition->sanad_id, $tuition->online_fee) }}"
                            class="form-control price-input">
                    </td>
                    <td>
                        <input type="text"
                            name="electronic_fee[sanad_{{ $tuition->sanad_id }}][{{ $tuition->sanad_id }}]"
                            value="{{ old('electronic_fee.sanad_' . $tuition->sanad_id . '.' . $tuition->sanad_id, $tuition->electronic_fee) }}"
                            class="form-control price-input">
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9">
                <button type="submit" class="btn btn-success">بروزرسانی قیمت‌ها</button>
            </td>
        </tr>
    </tfoot>
</table>
<script>
    document.querySelectorAll('.price-input').forEach(input => {
        input.addEventListener('input', function () {
            this.classList.add('edited-input');
            const row = this.closest('tr');
            row.classList.add('edited-row');
        });
    });
</script>
                    
                </form>
            </div>
        </div>
    </div>
    
@endsection