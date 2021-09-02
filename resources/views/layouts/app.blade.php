<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>Perinvest</title>

      <!-- Fonts -->
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <style>
          .table {
              border-radius: 15px;
          }
          table {
              text-align: center;
              vertical-align: middle;
          }
          .card {
              margin-left: 20px; margin-right: 15px; box-shadow: 0 15px 15px 0 rgba(0,0,0,0.2); transition: 0.8s;
          }
          .card:hover {
              box-shadow: 30px 30px 30px 20px rgba(0,0,0,0.2);
          }
      </style>
      <!-- Styles -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  </head>

  <body id="page-top">

    <div id="wrapper">
      @include('layouts.left-nav')

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

          <!-- Main Content -->
          <div id="content">
            @include('layouts.top-nav')

            @include('layouts.message')

            @yield('content')
          </div>

          @include('layouts.footer')
      </div>
      <!-- End of Content Wrapper -->

      @include('layouts.logout')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://datatables.yajrabox.com/js/handlebars.js"></script>
    <script>
        $(function (){
            $.extend(true, $.fn.dataTable.defaults, {

                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Hungarian.json"
                },
            });
        });
    </script>
    @yield('script')

  </body>
</html>
