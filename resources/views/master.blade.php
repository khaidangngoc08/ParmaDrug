<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    @include('partials.head-css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  @include('partials.header')

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/home" class="brand-link">
      <img src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    @php
        // $admin = Auth::guard('useradmin')->user();
        $user =  Auth::guard('users')->user();
    @endphp
    @if(env('APP_ROLE') == false)
        @include('partials.menu')
    @elseif($user->is_master )
        @include('partials.menu')
    @elseif($user->is_admin == 0)
        @include('partials.menu_admin')
    @else
        @include('partials.menu_user')
    @endif
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">
                @yield('title')
            </h1>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">

        @yield('content')

      </div>
    </div>

  </div>

  @include('partials.bottom')
  @include('partials.footer')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  @yield('js')
</div>
</body>
</html>
