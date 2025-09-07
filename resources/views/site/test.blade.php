<!DOCTYPE html>
<html>
<head lang="fa">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="{{asset('/styles/includes/mdb/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('styles/includes/mdb/css/mdb.min.css')}}">


    <link rel="stylesheet" href="{{asset('styles/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}">


    <link rel="stylesheet" href="{{asset('styles/plugins/material-desing-icons/material-icons.css')}}">


    <link rel="stylesheet" href="{{asset('styles/includes/css/customize.css')}}">
    <link rel="stylesheet" href="{{asset('styles/includes/css/themes.css')}}">
    <link rel="stylesheet" href="{{asset('styles/includes/css/style.css')}}">

    @yield("css")

    {{--sweet alert--}}
    <script src="styles/sweetalert2@9.js"></script>
    <script src="styles/promise-polyfill.js"></script>

    <style>
        a.HOVER:hover {
            background-color: #24b24a;
        }
    </style>


</head>
<body style="background-color: gainsboro">
@yield('content')

<nav class="navbar navbar-dark top-nav" style="background-color: black">
    <div class="nav-icon">
        <p class="text-center white-text" style="line-height: 55px;">
            <a href="/">
                <img src="{{asset('/files/site/logo.svg')}}">
            </a>
        </p>
    </div>
    <div class="nav-list">
        <ul class="nav pull-right">
            <li class="nav-item active waves-effect waves-light">
                <a href="javascript:;" id="close-menu" class="nav-link"><i class="fa fa-bars"></i></a>
            </li>
        </ul>
        <ul class="nav pull-left tools_list">
            <div class="col-md-12 col-sm-12">
                @if(isset($user))
                    <p style="color: forestgreen;">
                        آقای {{$user->name}} {{$user->family}} خوش آمدید
                    </p>
                @endif
            </div>
        </ul>
    </div>
</nav>

<aside class="sidebar z-depth-1" style="background-color: black">
    <!-- <div class="profile btn-group">
         <img src="includes/img/user8-128x128.jpg" class="border-r-3 z-depth-1" />
     </div>-->
    <ul class="accordion" id="accordion" role="tablist" aria-multiselectable="false">
        <li class="HOVER header" style="background-color: green;color: white;">
            <a href="/" style="color: white">
                بازگشت به سایت تکنوفول
            </a>
        </li>
        @if (\Route::current()->getName() == 'register') {
        <li class="HOVER header" style="background-color: #24b24a;color: white;">
            <a class="HOVER" href="/home" style="color: white">
                صفحه ورود
            </a>
        </li>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user())

            <li class="HOVER header" style="background-color: #24b24a;color: white;">
                <a class="HOVER" href="/home" style="color: white">
                    بازگشت به پنل اصلی </a>
            </li>
@if(Laratrust::hasRole("admin") )
                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/category/list" style="color: white">
                        لیست دسته بندی ها

                    </a>
                </li>
                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/category/create" style="color: white">
                        افزودن دسته بندی
                    </a>
                </li>
                <hr>
                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/device/list" style="color: white">
                        لیست دستگاه ها

                    </a>
                </li>
                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/device/create" style="color: white">
                        افزودن دستگاه
                    </a>
                </li>
                <hr>

                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/download/list" style="color: white">
                        لیست دانلود ها

                    </a>
                </li>
                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/download/create" style="color: white">
                        افزودن دانلود
                    </a>
                </li>
                <hr>

                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/site-news/list" style="color: white">
                        لیست خبر ها

                    </a>
                </li>
                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/site-news/create" style="color: white">
                        افزودن خبر
                    </a>
                </li>
                <hr>
                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/site-category/list" style="color: white">
                        لیست دسته بندی سایت

                    </a>
                </li>
                <li class="HOVER header" style="background-color: #24b24a;color: white;">
                    <a class="HOVER" href="/site-category/create" style="color: white">
                        افزودن دسته بندی سایت
                    </a>
                </li>
                <hr>

            @endif
   @if(Laratrust::hasRole("admin") && 0)
       <li class="sidebar-link">
           <a class="waves-effect" href="javascript:;" style="color: white">
               دسته بندی ها
               <span class="fa fa-angle-down"></span>
           </a>
           <ul class="collapse">
               <li class="waves-effect"><a class="HOVER" href="/category/list" style="color: white">
                       لیست
                   </a></li>
               <li class="waves-effect"><a class="HOVER" href="/category/create" style="color: white">
                       افزودن
                   </a></li>
           </ul>
       </li>

   @endif

   @if(Laratrust::hasRole("admin") && 0)
       <li class="sidebar-link">
           <a class="waves-effect" href="javascript:;" style="color: white">
               دستگاه ها
               <span class="fa fa-angle-down"></span>
           </a>
           <ul class="collapse">
               <li class="waves-effect"><a class="HOVER" href="/device/list" style="color: white">
                       لیست</a></li>
               <li class="waves-effect"><a class="HOVER" href="/device/create" style="color: white">
                       افزودن</a></li>
           </ul>
       </li>
   @endif
   @if(Laratrust::hasRole("admin") && 0)
       <li class="sidebar-link">
           <a class="waves-effect" href="javascript:;" style="color: white">
               دانلودها
               <span class="fa fa-angle-down"></span>
           </a>
           <ul class="collapse">
               <li class="waves-effect">
                   <a class="HOVER" href="/download/list" style="color: white">لیست</a>
               </li>
               <li class="waves-effect">
                   <a class="HOVER" href="/download/create" style="color: white">افزودن</a>
               </li>
           </ul>
       </li>
   @endif
   @if(Laratrust::hasRole("admin"))
       <li class="sidebar-link ">
           <a href="/setting" class="HOVER header waves-effect " style="background-color: #24b24a;color: white">
               تنظیمات اطلاعیه و ارتباطات
           </a>
       </li>
   @endif
   @if(Laratrust::hasRole("admin") && 0)
       <li class="sidebar-link ">
           <a class="HOVER waves-effect " style="color: white">
               اخبار
               <span class="fa fa-angle-down"></span>
           </a>
           <ul class="collapse">
               <li class="waves-effect">
                   <a class="HOVER" href="/site-news/list" style="color: white">لیست</a>
               </li>
               <li class="waves-effect">
                   <a class="HOVER" href="/site-news/create" style="color: white">افزودن</a>
               </li>
           </ul>
       </li>
   @endif
   @if(Laratrust::hasRole("admin")&&0)
       <li class="sidebar-link ">
           <a class="HOVER waves-effect " style="color: white">
               دسته بندی سایت
               <span class="fa fa-angle-down"></span>
           </a>
           <ul class="collapse">
               <li class="waves-effect">
                   <a class="HOVER" href="/site-category/list" style="color: white">لیست</a>
               </li>
               <li class="waves-effect">
                   <a class="HOVER " href="/site-category/create" style="color: white">افزودن</a>
               </li>
           </ul>
       </li>
   @endif

   @if(Laratrust::hasRole("user"))
       <li class="sidebar-link ">
           <a href="/profile" class="HOVER header waves-effect " style="background-color: #24b24acolor: white">
               پروفایل
           </a>
       </li>
   @endif
   @if(Laratrust::hasRole("user"))
       <li class="sidebar-link ">
           <a href="/prebuy" class="HOVER header waves-effect " style="background-color: #24b24a;color: white">
               پیش خرید
           </a>
       </li>
   @endif
   @if(Laratrust::hasRole("user"))
       <li class="sidebar-link ">
           <a href="/introduce" class="HOVER header waves-effect " style="background-color: #24b24a;color: white">
               معرفی دوستان برای پیش خرید
           </a>
       </li>
   @endif
   @if(Laratrust::hasRole("admin"))
       <li class="sidebar-link ">
           <a href="/introduce" class="HOVER header waves-effect " style="background-color: #24b24a;color: white">
               معرفی شدگان
           </a>
       </li>
   @endif
   <li class="sidebar-link ">
       <a href="/logout" class="HOVER waves-effect " style="color: red">
           خروج از حساب کاربری
       </a>
   </li>
@endif
</ul>
</aside>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script href="https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>


<script type="text/javascript" src="{{asset('styles/includes/mdb/js/tether.min.js')}}"></script>

<script type="text/javascript" src="{{asset('styles/includes/mdb/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('styles/includes/mdb/js/mdb.min.js')}}"></script>

<script type="text/javascript" src="{{asset('styles/includes/js/admin.js')}}"></script>


@yield("js")

</body>
@yield("after_js")
</html>
