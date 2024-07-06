@extends('layouts.navbar-user')
@extends('layouts.footer')
@extends('layouts.contact')
@extends('layouts.auth')
@section('tentang-kami-classes', 'active')
@section('login-logout', 'Login')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laser Cutting Poliban</title>

    {{-- link boostrap --}}
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    {{-- link rel bootsrap icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    {{-- link rel footer --}}
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/font-size/font-size.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/padding/padding.css">

    {{-- link rel icon title --}}
    <link rel="icon" href="{!! asset('img/logo.jpg') !!}" />

    {{-- link rel css --}}
    <link rel="stylesheet" href="{{ asset('css/beranda.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tentang-kami.css') }}">

</head>

<body>
    <div class="banner text-center text-white">
        <h1 class="display-5 fw-bold heading">Tentang Kami</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4 content">Kami adalah perusahaan yang mengkhususkan diri dalam layanan pemotongan laser
                berkualitas tinggi. Dengan teknologi terbaru dan tim profesional yang berpengalaman, kami siap memenuhi
                kebutuhan pemotongan laser Anda dengan hasil yang presisi dan memuaskan.</p>
        </div>
    </div>
    <div class="container marketing" style="margin-top: 75px">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">Layanan Pemotongan Laser Unggulan. <span class="text-muted">Menghasilkan
                        hasil terbaik.</span></h2>
                <p class="lead">Kami menyediakan layanan pemotongan laser untuk berbagai jenis material dengan presisi
                    tinggi dan hasil yang memuaskan. Percayakan kebutuhan pemotongan Anda kepada kami.</p>
            </div>
            <div class="col-md-5">
                <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                    height="500" src="{{ asset('img/img-real/tentangkami_1.jpg') }}" alt="Tentang kami" />
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading">Teknologi Terbaru. <span class="text-muted">Lihat sendiri
                        kualitasnya.</span></h2>
                <p class="lead">Dengan teknologi pemotongan laser terbaru, kami mampu memberikan hasil yang akurat dan
                    efisien. Kualitas adalah prioritas utama kami dalam setiap proyek yang kami kerjakan.</p>
            </div>
            <div class="col-md-5 order-md-1">
                <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                    height="500" src="{{ asset('img/img-real/tentangkami_3.jpg') }}" alt="Tentang kami" />
            </div>
        </div>
    </div>
    {{-- js bootstrap --}}
    <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
