<!doctype html>
<html lang="fa" dir="rtl">
@include('site.layout.head')

<body>
    <script src="{{ asset('site/assets/js/sweetalert.js') }}"></script>
    @if (Session::has('success'))
        <script>
            Swal.fire({
                // position: "top-end",
                icon: "success",
                text: "{{ Session::get('success') }}",
                showConfirmButton: false,
                width: 400,
                timer: 3000,
                timerProgressBar: true,
                heightAuto: false
            });
        </script>
    @endif
    @if (Session::has('fail'))
        <script>
            Swal.fire({
                // position: "top-end",
                icon: "error",
                text: "{{ Session::get('fail') }}",
                showConfirmButton: false,
                width: 400,
                timer: 3000,
                timerProgressBar: true,
                heightAuto: false
            });
        </script>
    @endif
    @include('site.layout.navbar')

    @yield('content')

    @include('site.layout.footer')
    @yield('script')

    @livewireScripts
</body>

</html>
