<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Chérif Ramzi Farès TAPSOBA">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title',  config('app.name') )</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.jpg') }}" type="image/png" />

    <!-- CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('/dist/adminlte/css/adminlte.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('/dist/bootstrap//dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/bootstrap-icons/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/jquery-ui//dist/themes/base/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/jquery-steps/demo/css/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/tom-select/tom-select.bootstrap5.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">

    <!-- Styles personnalisés -->
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Header -->
    {{-- <header class="bg-success text-white py-3">
        <div class="container text-center">
            <p class="mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Pour toutes informations complémentaires, contactez :
                <a href="tel:+22654268330" class="text-white text-decoration-none">
                    <i class="fas fa-phone"></i> (226) 54268330
                </a>
                <a href="https://wa.me/22670268330" class="text-white text-decoration-none" target="_blank">
                    <i class="fab fa-whatsapp"></i> (226) 70268330
                </a>
                <a href="mailto:ramzi.tapsoba@gmail.com" class="text-white text-decoration-none">
                    <i class="fas fa-envelope"></i> ramzi.tapsoba@gmail.com
                </a>
            </p>
        </div>
    </header> --}}

    <!-- Layout -->
    <div class="container-fluid">
        <div class="row d-flex">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded">
                <div class="container-fluid">
                    <!-- Button to toggle sidebar -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <a href="{{ url('/') }}" class="brand-link">
                                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="img-fluid col-3" >
                                </a>
                        <ul class="navbar-nav ms-auto">
                            @auth
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link">Accueil</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Profil</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a></li>
                                </ul>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Inscription</a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Sidebar -->
            <aside class="main-sidebar custom-sidebar elevation-2 d-none d-md-block col-md-2 vh-100 bg-success">
                <div class="sidebar h-100">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="true">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-search me-2"></i> Trouver une filière
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('universites.index') }}" class="nav-link">
                                        <i class="fas fa-university me-2"></i> Universités
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ufrs.index') }}" class="nav-link">
                                        <i class="fas fa-graduation-cap me-2"></i> UFR
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('departements.index') }}" class="nav-link">
                                        <i class="fas fa-building me-2"></i> Départements
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('filieres.index') }}" class="nav-link">
                                        <i class="fas fa-book-open me-2"></i> Filières
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('niveaux.index') }}" class="nav-link">
                                        <i class="fas fa-layer-group me-2"></i> Niveaux
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('diplomes.index') }}" class="nav-link">
                                        <i class="fas fa-certificate me-2"></i> Diplômes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('logout') }}" class="nav-link"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                    </a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto col-lg-10 h-100">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-success text-white py-3 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }}
                <a href="https://ramzit.net/" class="text-white text-decoration-none">
                    Ramzi TAPSOBA
                </a>. Tous droits réservés.
            </p>
        </div>
    </footer>

    <!-- Scripts -->
     <script src="{{ asset('/dist/jquery//dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/bootstrap//dist/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('/dist/adminlte/js/adminlte.js') }}"></script>

    <script src="{{ asset('/dist/datatables.net/js/dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/datatables.net-buttons/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('/dist/datatables.net-buttons/js/buttons.html5.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/datatables.net-buttons/js/buttons.print.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('/dist/jszip//dist/jszip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/pdfmake/build/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/pdfmake/build/vfs_fonts.js') }}" type="text/javascript"></script>

    <script src="{{ asset('/dist/jquery-ui//dist/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/jquery-steps/build/jquery.steps.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/sweetalert2/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/chart.js/chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/dist/tom-select/tom-select.complete.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('/js/scripts.js') }}" type="text/javascript"></script>


    <!-- Scripts personnalisées de chaque vue -->
    @stack('scripts')

    <!-- Script pour gérer l'affichage/masquage de la sidebar -->
    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function () {
            document.querySelector('.main-sidebar').classList.toggle('d-none');
        });
    </script>
</body>

</html>
