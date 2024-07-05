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
                        href="{{ route('beranda.user') }}">Beranda</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('cart-classes')" aria-current="page" href=#
                        onclick="navigateToCart()">Keranjang</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('order-classes')" aria-current="page" href=#
                        onclick="navigateToTransaction()">Pesanan</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('Kontak-classes')" aria-current="page"
                        href="{{ route('kontak-user') }}">Kontak</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link btn btn-secondary @yield('tentang-kami-classes')" aria-current="page"
                        href="{{ route('tentang-kami-user') }}">Tentang
                        kami</a>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link dropdown-toggle btn btn-secondary @yield('user-classes')" href="#"
                        id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span id="user-name-dropdown"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li> <a class="dropdown-item @yield('user-classes')" href="#"
                                onclick="navigateToProfileSettings()">
                                Profile Settings
                            </a>
                        </li>
                        <li>
                            <button type="submit" class="dropdown-item" onclick="logout()">Logout</button>
                        </li>
                </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Memuat jQuery -->

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
        var url = "{{ route('profile.setting.user', ':id') }}";
        url = url.replace(':id', id);
        window.location.href = url;
    }
</script>

<script>
    function navigateToCart() {
        var id = sessionStorage.getItem('user_id');
        if (!id) {
            alert('ID not found in sessionStorage.');
            return;
        }
        var url = "{{ route('get.cart') }}?user_id=" + id;
        window.location.href = url;
    }
</script>

<script>
    function navigateToTransaction() {
        var id = sessionStorage.getItem('user_id');
        if (!id) {
            alert('ID not found in sessionStorage.');
            return;
        }
        var url = "{{ route('show.transaction') }}?user_id=" + id;
        window.location.href = url;
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userName = sessionStorage.getItem('user_name');
        if (userName) {
            document.getElementById('user-name-dropdown').innerText = userName;
        } else {
            console.log('User name not found in sessionStorage');
            Swal.fire('Error', 'User name not found in sessionStorage', 'error');
        }
    });
</script>
