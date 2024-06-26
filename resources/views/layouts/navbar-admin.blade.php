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
                        href="{{ route('admin.beranda-admin') }}">Beranda</a>
                </li>
                {{-- <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('pesanan-classes')" aria-current="page"
                        href="#">Pesanan</a>
                </li> --}}
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('order-classes')" aria-current="page"
                        href="{{ route('get.transaction') }}">Pesanan</a>
                </li>
                {{-- <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('Kontak-classes')" aria-current="page"
                        href="{{ route('kontak') }}">User</a>
                </li> --}}
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('Kontak-classes')" aria-current="page"
                        href="{{ route('kontak-admin') }}">Kontak</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('tentang-kami-classes')" aria-current="page"
                        href="{{ route('tentang-kami-admin') }}">Tentang
                        kami</a>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle btn btn-secondary @yield('user-classes')" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li> <a class="dropdown-item @yield('user-classes')" href="#"
                                onclick="navigateToProfileSettings()">
                                Profile Settings
                            </a>
                        </li>
                </li>
                <li>
                    <button type="submit" class="dropdown-item" onclick="logout()">Logout</button>
                </li>
                </ul>
                </li>
            </div>
        </div>
    </div>
</nav>

<script>
    function logout() {
        sessionStorage.clear();

        window.location.href = '/';
    }
</script>

<script>
    function navigateToProfileSettings() {
        var id = sessionStorage.getItem('user_id');
        if (!id) {
            alert('ID not found in sessionStorage.');
            return;
        }
        var url = "{{ route('profile.setting.admin', ':id') }}";
        url = url.replace(':id', id);
        window.location.href = url;
    }
</script>
