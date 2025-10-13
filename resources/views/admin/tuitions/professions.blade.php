@extends('admin.layout.master')

@section('content')
    <div class="card p-3">
        <h4 class="mb-3">مدیریت مبالغ حرفه‌ها برای شهریه: {{ $tuition->title }}</h4>

        <div class="table-responsive">
            <table class="table align-middle table-striped text-center" id="professions-table">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>نام حرفه</th>
                        <th>مبلغ حضوری</th>
                        <th>مبلغ مجازی</th>
                        <th>مبلغ الکترونیکی</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($professions as $profession)
                        @php
                            $pivot = $profession->tuitions()->where('tuition_id', $tuition->id)->first()->pivot ?? null;
                        @endphp
                        <tr data-id="{{ $profession->id }}">
                            <td>{{ $profession->id }}</td>
                            <td>{{ $profession->name }}</td>
                            <td><input type="text" class="form-control amount-input amount_in_person"
                                    value="{{ number_format($pivot->price_in_person ?? 0) }}"></td>
                            <td><input type="text" class="form-control amount-input amount_online"
                                    value="{{ number_format($pivot->price_online ?? 0) }}"></td>
                            <td><input type="text" class="form-control amount-input amount_virtual"
                                    value="{{ number_format($pivot->price_virtual ?? 0) }}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <button id="save-all" class="btn btn-primary px-4">ذخیره همه</button>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // --- فرمت سه‌رقمی برای اعداد ---
        $(document).on('input', '.amount-input', function() {
            let value = $(this).val().replace(/,/g, '');
            if (!isNaN(value) && value !== '') {
                $(this).val(Number(value).toLocaleString('en-US'));
            } else {
                $(this).val('');
            }
        });

        // --- دکمه ذخیره کلی ---
        $('#save-all').on('click', function() {
            let data = [];

            $('#professions-table tbody tr').each(function() {
                let row = $(this);
                data.push({
                    profession_id: row.data('id'),
                    amount_in_person: row.find('.amount_in_person').val().replace(/,/g, ''),
                    amount_online: row.find('.amount_online').val().replace(/,/g, ''),
                    amount_virtual: row.find('.amount_virtual').val().replace(/,/g, '')
                });
            });

            $.ajax({
                url: "{{ route('admin.tuitions.professions.update', $tuition->id) }}",
                method: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    data: data
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ذخیره شد!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا!',
                            text: 'مشکلی در ذخیره اطلاعات پیش آمد.',
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطای سرور!',
                        text: 'در ذخیره اطلاعات خطایی رخ داد.',
                    });
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
