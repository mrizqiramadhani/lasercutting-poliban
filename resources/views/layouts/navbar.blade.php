<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a href="{{ route('beranda') }}"><img src="{{ asset('img/logo.jpg') }}" alt="laser cutting poliban"
                style="width:75px" class="me-3"></a>
        <a class="navbar-brand" href="{{ route('beranda') }}">Laser Cutting Poliban</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0"></ul>
            <div class="d-flex justify-content-around navbar-nav" style="font-size: 20px">
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('beranda-classes')" aria-current="page"
                        href="{{ route('beranda') }}">Beranda</a>
                </li>
                {{-- <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('pesanan-classes')" aria-current="page"
                        href="#">Pesanan</a>
                </li> --}}
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('Kontak-classes')" aria-current="page"
                        href="{{ route('kontak') }}">Kontak</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('tentang-kami-classes')" aria-current="page"
                        href="{{ route('tentang-kami') }}">Tentang
                        kami</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('login-classes')" aria-current="page" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" href="#">@yield('login-logout')</a>
                </li>

            </div>
        </div>
    </div>
</nav>
