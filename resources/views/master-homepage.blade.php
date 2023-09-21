<!DOCTYPE html>
<html lang="en">

<head>
    @include('client.Shared.head')
    @yield('css')
</head>

<body>

    @include('client.Shared.menu')
    <div class="col-md-12" style="margin-bottom: 100px"></div>
    {{-- <br>
    <br> --}}
    @yield('title')
    @yield('content')

    @include('client.Shared.bottom')


    @include('client.Shared.foot')

</body>
@yield('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</html>
