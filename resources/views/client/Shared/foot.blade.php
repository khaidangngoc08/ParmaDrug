@jquery
@toastr_js
@toastr_render
    <!-- JS -->

<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="/assets_homepage/js/jquery/jquery-2.2.4.min.js "></script>
<!-- Popper js -->
<script src="/assets_homepage/js/popper.min.js "></script>
<!-- Bootstrap js -->
<script src="/assets_homepage/js/bootstrap.min.js "></script>
<!-- Plugins js -->
<script src="/assets_homepage/js/plugins.js "></script>
<!-- Classy Nav js -->
<script src="/assets_homepage/js/classy-nav.min.js "></script>
<!-- Active js -->
<script src="/assets_homepage/js/active.js "></script>
<script src="/assets_login/vendor/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/assets_login/js/main.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    @if(count($errors) > 0)
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
