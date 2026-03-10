@extends('site.layout.master')
@section('head')
    <title>تایید شماره موبایل</title>
    <!-- link slider -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/main-menu-full.css') }}">
@endsection
@section('content')
    <div class="container wrapper d-flex align-items-center justify-content-center" style="margin-top: 120px">
        <div class="row w-75 login-card bg-white">
            <!-- اسلایدر راست -->
            <div class="col-md-6 d-none d-md-block p-0">
                @include('auth.layouts.slider')
            </div>

            <!-- فرم ورود کد تایید -->
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <div class="text-end">
                    <a href="/login" class="btn btn-outline-secondary btn-sm">
                        بازگشت
                        <i class="bi bi-arrow-left me-1" style="position: relative;top: 2px;"></i>
                    </a>
                </div>
                <h4 class="mb-4">اعتبار سنجی</h4>
                <p class="text-muted mb-5">لطفا کد اعتبارسنجی ارسال شده به موبایل خود را در کادر زیر وارد نمایید.</p>
                <form action="{{ route('verifyCode') }}" method="post" id="verifyForm">
                    @csrf
                    <div class="d-flex justify-content-between mb-5" dir="ltr">
                        @for ($i = 1; $i <= 6; $i++)
                            <input type="text" class="form-control text-center mx-1 only-number"
                                {{ $i == 1 ? 'autofocus' : '' }} maxlength="1" name="code[]" id="code{{ $i }}"
                                style="width: 45px; height: 50px; font-size: 22px;" required>
                        @endfor
                    </div>
                    <input type="hidden" name="user" value="{{ $user }}">
                    <button type="submit" class="btn btn-primary w-100 mb-3">تایید</button>
                </form>
                <div class="text-end mt-0" style="position: relative;bottom: 16px;">
                    <small id="resend_div">
                        <div class="progress-timer-container ps-1">
                            <div class="progress-bar-text" id="progress-time-label">02:00</div>
                        </div>
                        <div id="resend-btn" class="text-muted mt-2 text-center" style="display: none;">
                            <button id="resend-code-btn" class="form_btn" data-user-id="{{ $user }}">ارسال
                                مجدد کد تایید</button>
                        </div>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const inputs = $("input[name='code[]']");

            inputs.on("input", function() {
                const index = inputs.index(this);
                let value = $(this).val();

                // فقط عدد قبول کن
                value = value.replace(/[^0-9]/g, '');
                this.value = value;

                // فقط اگر عدد معتبر وارد شد برو فیلد بعدی
                if (value.length === 1 && index < inputs.length - 1) {
                    inputs.eq(index + 1).focus();
                }

                // اگر آخرین فیلد پر شد، فرم رو ارسال کن
                if (index === inputs.length - 1 && value.length === 1) {
                    $("#verifyForm").submit();
                }
            });

            // رفتن به عقب با backspace
            inputs.on("keydown", function(e) {
                const index = inputs.index(this);
                if (e.key === "Backspace" && !$(this).val() && index > 0) {
                    inputs.eq(index - 1).focus();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let duration = 120; // 2 دقیقه
            const total = duration;
            const display = document.getElementById('progress-time-label');
            const progressBar = document.getElementById('progress-bar');
            const resendBtn = document.getElementById('resend-btn');
            const resendText = document.getElementById('resend-text');
            const progressContainer = document.querySelector('.progress-timer-container');

            const timer = setInterval(function() {
                const minutes = Math.floor(duration / 60);
                const seconds = duration % 60;
                display.textContent =
                    `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                const percent = (duration / total) * 100;
                progressBar.style.width = `${percent}%`;

                duration--;

                if (duration < 0) {
                    clearInterval(timer);
                    // حذف نوار و تایمر
                    progressContainer.remove();
                    resendText.remove();
                    resendBtn.style.display = 'block';
                }
            }, 1000);
        });
    </script>
    <script>
        document.querySelector('.login-btn').addEventListener('click', function(e) {
            e.preventDefault();
            return false;
        });
        $('.login-btn').css('pointer-events', 'none');
    </script>
    <script>
        $(document).ready(function() {
            // ارسال مجدد کد با AJAX
            $(document).on('click', '#resend-code-btn', function() {
                let userId = $(this).data('user-id');
                let btn = $(this);

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> در حال ارسال...');

                $.ajax({
                    url: '/resend-code/' + userId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // نمایش پیام موفقیت
                            toastr.success('کد جدید با موفقیت ارسال شد');

                            // ریست تایمر
                            resetResendTimer(300);

                            // غیرفعال کردن دکمه تا پایان تایمر
                            btn.hide();
                        } else {
                            toastr.error('خطا در ارسال کد: ' + response.message);
                            btn.prop('disabled', false).text('ارسال مجدد کد');
                        }
                    },
                    error: function(xhr) {
                        toastr.error('خطا در ارتباط با سرور');
                        btn.prop('disabled', false).text('ارسال مجدد کد');
                    }
                });
            });

            // تابع ریست تایمر
            function resetResendTimer(time) {
                let timeLeft = time; // 2 دقیقه = 120 ثانیه
                $('#resend-btn').hide();
                $('#progress-time-label').show();

                let timer = setInterval(function() {
                    let minutes = Math.floor(timeLeft / 60);
                    let seconds = timeLeft % 60;

                    $('#progress-time-label').text(
                        (minutes < 10 ? '0' + minutes : minutes) + ':' +
                        (seconds < 10 ? '0' + seconds : seconds)
                    );

                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        $('#resend-btn').show();
                        $('#progress-time-label').hide();
                    }

                    timeLeft--;
                }, 1000);
            }

            // شروع تایمر هنگام لود صفحه
            resetResendTimer(120);
        });
    </script>
@endsection
