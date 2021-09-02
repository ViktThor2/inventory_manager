<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perinvests</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    @foreach ($css_files as $css_file)
        <link rel="stylesheet" href="{{ $css_file }}">
    @endforeach
</head>
<body>

<div id="wrapper">
@include('layouts.left-nav')

<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            @include('layouts.top-nav')

            @include('layouts.message')

            <div>
                {!! $output !!}
            </div>

        </div>

        @include('layouts.footer')
    </div>
    <!-- End of Content Wrapper -->

    @include('layouts.logout')
</div>

@foreach ($js_files as $js_file)
    <script src="{{ $js_file }}"></script>
@endforeach
<script>
    if (typeof $ !== 'undefined') {
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    }
</script>
</body>
</html>
