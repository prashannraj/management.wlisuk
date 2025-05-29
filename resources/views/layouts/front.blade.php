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
  <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/colors.css')}}" type="text/css">
</head>

<body class="bg-default">
  <!-- Main content -->
  <div class="main-content">
      @yield('header')
      <!-- Page content -->
      @yield('main-content')
      </div>
  </div>
  <!-- Main content -->
  <!-- Scripts -->
  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  @stack('scripts')
  <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/js/argon.js?v=1.2.0') }}"></script>
  <script>
        document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('title');
        if (titleInput) {
            titleInput.addEventListener('change', function() {
                const otherTitleInput = document.getElementById('other_title');
                if (this.value === 'Other') {
                    otherTitleInput.style.display = 'block';
                } else {
                    otherTitleInput.style.display = 'none';
                }
            });
        }
    });




    $(document).ready(function() {
        $('#authorise').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue == 'yes') {
                $('#yes_authorise').show();
            } else {
                $('#yes_authorise').hide();
            }
        });
    });
</script>
  <!-- End scripts -->
</body>

</html>
