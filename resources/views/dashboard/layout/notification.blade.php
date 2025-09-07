<div>
    <script src="{{asset('dashboard/assets/js/scrollspyNav.js')}}"></script>
    <script src="{{asset('dashboard/plugins/sweetalerts/sweetalert2.min.js')}}"></script>



@if ( Session::has('error') )

        <script>
            const toast = swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 6000,
                padding: '2em'
            });
            toast({
                type: 'error',
                title: '{!! Session::get('error') !!}',
                padding: '2em',
            })
        </script>

    @endif


        @if ( Session::has('success') )

        <script>
            const toast = swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 6000,
                padding: '2em'
            });
            toast({
                type: 'success',
                title: '{!! Session::get('success') !!}',
                padding: '2em',
            })
        </script>

    @endif
</div>
