<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="favicon.ico">
    <title>@yield('title') | Admin</title>
    <link rel="stylesheet" href="{{ asset('css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-dark.css') }}" id="darkTheme" >
    <link rel="stylesheet" href="{{ asset('css/app-light.css') }}" id="lightTheme" disabled>

</head>
<body class="vertical  dark  ">
<style>
    a{
        color: whitesmoke;
    }
</style>
<div class="wrapper">
    <nav class="topnav navbar navbar-light">
        <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
            <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <form class="form-inline mr-auto searchform text-muted">
            <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" placeholder="Type something..." >
            <button type="submit" class="btn mb-2 btn-outline-light">Find</button>
        </form>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="dark">
                    <i class="fe fe-sun fe-16"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted my-2" href="{{ route('logout') }}">
                    <span>Déconnexion</span>
                </a>
            </li>

        </ul>
    </nav>
    <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
        <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
            <i class="fe fe-x"><span class="sr-only"></span></i>
        </a>
        <nav class="vertnav navbar navbar-light">
            <!-- nav bar -->
            <div class="w-100 mb-4 d-flex">
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="#">
                    <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                <g>
                    <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                    <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                    <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                </g>
              </svg>
                </a>
            </div>
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>Modele</span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">


                <li class="nav-item dropdown">
                    <a href="#client" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-pie-chart fe-16"></i>
                        <span class="ml-3 item-text">Demand</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="client">
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="{{ url('client/demand') }}"><span class="ml-1 item-text">Creer Devis</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pl-3" href="{{ url('client/liste') }}"><span class="ml-1 item-text">Liste Devis</span></a>
                        </li>
                    </ul>
                </li>

            </ul>

        </nav>
    </aside>
    <main role="main" class="main-content">
        @yield('content')
    </main> <!-- main -->
</div> <!-- .wrapper -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/simplebar.min.js') }}"></script>
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="{{ asset('js/apps.js') }}"></script>
<script src="{{ asset('js/tinycolor-min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>

</body>
</html>
