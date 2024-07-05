@extends('layouts.navbar')
@extends('layouts.footer')
@extends('layouts.auth')
@extends('layouts.contact')
@section('beranda-classes', 'active')
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
    <link rel="stylesheet" href={{ asset('css/beranda.css') }}>

</head>


<body>

    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/beranda_1.jpg') }}" alt="laser cutting poliban" width="100%" height="100%"
                    style="filter: brightness(30%)">
                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>Laser Cutting Poliban</h1>
                        <p>Laser Cutting Poliban adalah penyedia jasa laser cutting dan laser marking</p>
                        <p><a class="btn btn-lg btn-primary" href="#">Ayo Pesan!</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/beranda_3.jpg') }}" alt="laser cutting poliban" width="1800px" height="800px"
                    style="filter: brightness(30%)">
                <div class="carousel-caption">
                    <h1>Laser Cutting Poliban</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto fugiat animi ut quos
                        quam laboriosam? Expedita, architecto eligendi! Incidunt, saepe est laborum eligendi
                        deleniti voluptatem a perspiciatis repellat atque dolorum.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/beranda_2.jpg') }}" alt="laser cutting poliban" width="100%" height="100%"
                    style="filter: brightness(30%)">
                <div class="container">
                    <div class="carousel-caption text-end">
                        <h1>One more for good measure.</h1>
                        <p>Some representative placeholder content for the third slide of this carousel.</p>
                        <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <!-- Marketing messaging and featurettes
        ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
    <style>
        .card:hover {
            box-shadow: 10px 8px 10px rgba(0, 0, 0, 0.2) !important;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .product-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }

        .product-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            height: 150px;
            object-fit: cover;
        }

        .product-card .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .product-card .mt-auto {
            margin-top: auto;
        }

        /* Media queries for responsive design */
        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container marketing">


        <div class="row">
            <div class="d-flex justify-content-center" style="margin-bottom: 70px">
                <h1>Barang yang tersedia!</h1>
            </div>

            <div class="container">
                <div class="row product-grid">
                    @if ($products['status'] && count($products['data']) > 0)
                        @foreach (array_slice($products['data']->items(), 0, 100) as $item)
                            <div class="col p-0">
                                <div class="card h-100 shadow-sm border-0 product-card">
                                    <img src="{{ !empty($item->photo) ? Storage::disk('public')->url($item->photo) : Storage::disk('public')->url('public/img/no-image.jpg') }}"
                                        class="card-img-top img-fluid" alt="{{ $item->name }}">
                                    <div class="card-body d-flex flex-column p-3">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text">Rp {{ number_format($item->price, 2, ',', '.') }}</p>
                                        <p class="card-text">{{ $item->description }}</p>
                                        <p class="card-text">Stok: {{ $item->stock }}</p>
                                        <div class="mt-auto">
                                            <button type="button" class="btn btn-success btn-md"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="bi bi-cart-plus"></i> Beli Sekarang!
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No products found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->


    <hr class="featurette-divider">
    <div class="d-flex justify-content-center" style="margin-bottom: 70px">
        <h1>Kenapa memilih kami?</h1>
    </div>
    <div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card text-center bg-dark shadow-lg" style="border-radius: 20px;">
                    <img src="{{ asset('img/team.jpg') }}" class="mt-5 mb-3" alt="team_terbaik"
                        style="width: 100px;display: block; margin: 0 auto;">
                    <div class="card-body">
                        <h5 class="card-title text-white mb-2">Tim Terbaik</h5>
                        <p class="card-text text-white">Tim yang yang bekerja cepat dan dapat di andalkan</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center bg-dark shadow-lg" style="border-radius: 20px;">
                    <img src="{{ asset('img/price.jpg') }}" class="mt-5 mb-3" alt="team_terbaik"
                        style="width: 100px;display: block; margin: 0 auto;">
                    <div class="card-body">
                        <h5 class="card-title text-white mb-2">Harga Terjangkau</h5>
                        <p class="card-text text-white">Harga yang pas di dompet untuk semua kalangan</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center bg-dark shadow-lg" style="border-radius: 20px;">
                    <img src="{{ asset('img/clock.jpg') }}" class="mt-5 mb-3" alt="team_terbaik"
                        style="width: 100px;display: block; margin: 0 auto;">
                    <div class="card-body">
                        <h5 class="card-title text-white mb-2">Tepat Waktu</h5>
                        <p class="card-text text-white">Selalu berpatokan dengan waktu yang telah ditentukan
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center bg-dark shadow-lg" style="border-radius: 20px;">
                    <img src="{{ asset('img/quality.jpg') }}" class="mt-5 mb-3" alt="team_terbaik"
                        style="width: 100px;display: block; margin: 0 auto;">
                    <div class="card-body">
                        <h5 class="card-title text-white mb-2">Kualitas Ganas</h5>
                        <p class="card-text text-white">Berkualitas tanpa batas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div><!-- /.container -->



    {{-- js bootstrap --}}
    <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
