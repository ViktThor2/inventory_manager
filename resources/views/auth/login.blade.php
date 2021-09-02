<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Perinvest</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body class="antialiased" style="background-image: url({{ asset('img/background.jpg') }});  background-repeat: no-repeat;
    background-size: cover;">

<div class="relative flex items-top justify-center min-h-screen ">

    <div class="container">
        <div class="row justify-content-center mt-4">
            <img src="{{ asset('img/perinvest_logo2.svg') }}" class="mt-5" width="50%" >
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
{{--
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1181" height="131" viewBox="0 0 1181 131">
                    <image id="Réteg_1" data-name="Réteg 1" width="70%" height="30%" xlink:href="data:img/png;base64,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"/>

                </svg>
--}}
               <div class="d-flex justify-content-center mt-5">
               </div>
                <div class="card">
                    <div class="card-header">Bejelentkezés</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email cím</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Jelszó</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            Emlékezz rám
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Bejelentkezés
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Elfelejtette jelszavát?
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
</body>
</html>
