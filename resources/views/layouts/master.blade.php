<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title></title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/img/brand/favicon.png') }}">

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
  @stack('styles')

  <link rel="stylesheet" href="{{ asset('assets/css/argon.css')}}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/colors.css')}}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}" type="text/css">


</head>

<body>
  @include('layouts.inc.sidebar-nav')
  <!-- Main content -->
  @hasSection("v2_master")
    @yield('v2_master')
  @else
  <div class="main-content" id="panel">
    @include('layouts.inc.top-nav')
    @yield('header')
    <!-- Page content -->
    <div class="container-fluid mt--5">
      @yield('main-content')
      @yield('content')
    </div>
  </div>

  @endif

  @stack('modals')
  <!-- Main content -->
  <!-- Scripts -->
  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.serializejson.js') }}"></script>
  <script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
  <script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>
  <script>
    function initiateTinymce(selector) {
      if (tinymce) {
        tinymce.init({
          selector: selector,
          plugins: 'link',
          default_link_target: '_blank'
        });
      }
    }
  </script>
  @stack('scripts')
  <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/js/argon.js?v=1.2.0') }}"></script>
  @include('layouts.inc.notification')
</body>

</html>
