<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کانون</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/img/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <style type="text/css">
        /* Template Name: portal-login-form */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-weight: 300;
        }

        body {
            font-family: 'Lato', sans-serif;
            color: #555555;
            font-weight: 300;
            background-color: white;
        }

        body ::-webkit-input-placeholder {
            font-family: 'Lato', sans-serif;
            color: #555555;
            font-weight: 300;
        }

        body :-moz-placeholder {
            font-family: 'Lato', sans-serif;
            color: #555555;
            opacity: 1;
            font-weight: 300;
        }

        body ::-moz-placeholder {
            font-family: 'Lato', sans-serif;
            color: #555555;
            opacity: 1;
            font-weight: 300;
        }

        body :-ms-input-placeholder {
            font-family: 'Lato', sans-serif;
            color: #555555;
            font-weight: 300;
        }

        .wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            min-height: 750px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 0 10%;
            padding-top: 50px;
        }

        .container {
            box-shadow: 10px 0px 30px 5px rgba(0, 0, 0, 0.27);
            background: #fff;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            flex-direction: row-reverse;
            padding: 0;
            width: 90%;
            height: auto;
        }

        .login-left {
            width: 50%;
            z-index: 1;
            position: relative;
            height: 625px;
        }

        .login-left h2 {
            font-weight: 700;
            font-size: 34px;
        }

        .login-left h3 {
            font-size: 1.2em;
            margin: 1em 0;
            line-height: 28px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .login-left p {
            font-size: 14px;
            margin: 1em 0;
            line-height: 28px;
            font-weight: 400;
        }

        .login-left a {
            color: #555555;
            text-decoration: none;
            padding-right: 5px;
        }

        .login-form {
            width: 50%;
            display: flex;
            flex-wrap: wrap;
            padding: 50px;
        }

        .form-title {
            font-size: 25px;
            font-weight: 900;
            text-align: center;
            width: 100%;
            padding-bottom: 25px;
        }

        .forgot-link {
            width: 100%;
            text-align: right;
            padding-top: 10px;
        }

        .login-form a {
            color: #555555;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
        }

        .form-group {
            width: 100%;
            height: 80px;
            margin-bottom: 15px;
        }

        .input-group {
            padding: 0 10px;
            border: 1px solid #ddd;
            height: 50px;
            width: 100%;
        }

        .input-group span.fa {
            font-size: 16px;
            vertical-align: middle;
            float: left;
            text-align: center;
            width: 6%;
            padding: 15px 0;
            color: #007bff;
        }

        .btn {
            cursor: pointer;
            transition: color .15s ease-in-out, background-color .15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-lg {
            padding: .5rem 1rem;
            font-size: 1.25rem;
            border-radius: .3rem;
        }

        .btn-block {
            width: 100%;
        }

        .form-control {
            display: block;
            width: 100%;
            height: calc(1.5em + .75rem + 10px);
            padding: .375rem .75rem;
            font-size: 1rem;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form-control::placeholder {
            color: #6c757d;
            opacity: 1;
        }

        label {
            display: inline-block;
            margin-bottom: .5rem;
            font-weight: 700;
            width: 100%;
        }

        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            font-size: 15px;
            color: #333;
            padding: 14px 10px;
            width: 93%;
            border: none;
            outline: none;
            background: transparent;
        }

        .copyright {
            font-size: 15px;
            text-align: center;
            line-height: 24px;
            color: white;
        }

        .carousel {
            height: 100%;
        }

        .copyright a {
            color: #50a3a2;
            font-size: 16px;
            text-decoration: none;
        }

        .copyright a:hover {
            color: #000;
        }

        .copyright strong {
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 1280px) {
            .login-form {
                padding: 0 50px;
            }

            .login-left {
                height: 100%;
            }

            .container {
                width: 100%;
            }
        }

        @media (max-width: 992px) {
            .login-form {
                width: 100%;
                padding: 0 50px;
            }

            .login-left {
                display: none;
            }
        }

        @media (max-width: 767px) {
            .login-form {
                width: 100%;
                padding: 0 30px;
            }

            .login-left {
                display: none;
            }

            .wrapper {
                padding: 10px;
            }

            .copyright {
                padding-bottom: 30px;
            }
        }

        @media (max-width: 360px) {
            .login-form {
                padding: 0 20px;
            }
        }

        input:-webkit-autofill,
        textarea:-webkit-autofill,
        select:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px white inset !important;
            box-shadow: 0 0 0px 1000px white inset !important;
            -webkit-text-fill-color: #333 !important;
            height: calc(1.5em + .75rem + 10px) !important;
        }
    </style>
    <!-- سایر استایل‌های مربوط به vue-slider و trust-wallet-one-tap (در صورت نیاز) حذف یا همانطور باقی می‌مانند -->
</head>

<body>
    <!-- المان کانال (در صورت نیاز) -->
    <div id="in-page-channel-node-id" data-channel-name="in_page_channel_ORYz8d"></div>

    <div class="wrapper">
        <div class="container">
            <p class="signup-link">
                @if (session()->has('msg'))
                    <div class="text-danger">
                        {{ session()->get('msg') }}
                    </div>
                @endif
            </p>
            <form action="" method="POST" class="login-form">
                @csrf
                <span class="form-title">ورود</span>
                <div class="form-group">
                    <label>موبایل</label>
                    <div class="input-group">
                        <span class="fa fa-envelope" aria-hidden="true"></span>
                        <input type="tel" name="mobile" class="form-control" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label>رمز عبور</label>
                    <div class="input-group">
                        <span class="fa fa-lock" aria-hidden="true"></span>
                        <input type="password" name="password" class="form-control" required="">
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg" value="ورود">
                    <br>
                    <div class="mb-4 text-center">
                        <a href="{{route('loginCode')}}" class="text-center">پیگیری ثبت نام</a>
                    </div>
                    <center>
                        <a href="/" class="text-center">بازگشت به کانون</a>
                    </center>
                </div>
            </form>
            <div class="login-left">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="/1.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="/2.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="/3.jpg" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">قبلی</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">بعدی</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- اسکریپت‌های جاوااسکریپت در انتهای بدنه -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script>
        $('.carousel').carousel();
    </script>

    <div class="troywell-caa"></div>
    <div class="troywell-avia"></div>
</body>

</html>
