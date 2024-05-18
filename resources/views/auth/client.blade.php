<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Tiny Dashboard - A Bootstrap Dashboard Template</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset('css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-dark.css') }}" id="darkTheme" >
    <link rel="stylesheet" href="{{ asset('css/app-light.css') }}" id="lightTheme" disabled>
</head>
<body class="dark ">
<div class="wrapper vh-100">
    <div class="row align-items-center h-100">
        <form action="{{ url('auth/clientlog') }}" method="POST" class="col-lg-3 col-md-4 col-10 mx-auto text-center">
            @csrf
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
              <g>
                  <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                  <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                  <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
              </g>
            </svg>
            </a>
            <h1 class="h6 mb-3">Login</h1>
            <div class="form-group">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input name="password" type="number" id="inputEmail"  class="form-control @error('password') is-invalid @enderror form-control-lg" placeholder="Ajouter votre contact"  autofocus="">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="checkbox mb-3">
                <label><a href="{{ url('auth/inscription') }}">Inscription</a> </label>
            </div>
            <div class="checkbox mb-3">
                <label><a href="{{ url('/auth') }}">Login Admin</a> </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Let me in</button>
            <p class="mt-5 mb-3 text-muted">© 2020</p>
        </form>
    </div>
</div>

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag()
    {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
</script>
</body>
</html>
