@extends('layouts.navbar-user')
@extends('layouts.footer')
@extends('layouts.contact')
@section('beranda-classes', 'active')
@section('logout')
    {{-- @extends('admin.pesan') --}}
    {{-- @extends('user.tambah-transaksi') --}}

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Laser Cutting Poliban</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- link boostrap --}}
        <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
        <link rel="stylesheet" href="{{ asset('css/admin/beranda.css') }}">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <style>
        .card:hover {
            box-shadow: 10px 8px 10px rgba(0, 0, 0, 0.2) !important;
        }
    </style>

    <body>
        <div class="container" style="margin-top: 150px">
            <div class="container mt-3">

                <div class="container marketing mt-5">
                    <div>
                        <div>
                            <h1 class="text-start mb-5">Selamat Datang <span id="user-name"></span></h1>
                            <div class="row grid gap-5">
                                @if ($products['status'] && count($products['data']) > 0)
                                    @foreach ($products['data']->items() as $item)
                                        @if ($item->deleted_at == null)
                                            <div class="col-lg-3 col-md-4 col-sm-6 p-0">
                                                <div class="card  shadow-sm border-0"
                                                    style="transition: box-shadow 0.3s ease-in-out; ">
                                                    <img src="{{ !empty($item->photo) ? Storage::disk('public')->url($item->photo) : Storage::disk('public')->url('public/img/no-image.jpg') }}"
                                                        class="card-img-top img-fluid" alt="{{ $item->name }}"
                                                        style="height: 150px; object-fit: cover;">
                                                    <div class="card-body d-flex flex-column p-3">
                                                        <h5 class="card-title">{{ $item->name }}</h5>
                                                        <p class="card-text">Rp
                                                            {{ number_format($item->price, 2, ',', '.') }}
                                                        </p>
                                                        <p class="card-text">{{ $item->description }}</p>
                                                        <p class="card-text">Stok: {{ $item->stock }}</p>
                                                        <div class="mt-auto">
                                                            <button type="button"
                                                                class="btn btn-warning btn-md add-to-cart"
                                                                data-product-id="{{ $item->id }}">
                                                                <i class="bi bi-cart-plus"></i> Add to Cart
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p>No products found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    {{-- js bootstrap --}}
    <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const userId = sessionStorage.getItem('user_id');
                    const userName = sessionStorage.getItem('user_name');

                    if (userName) {
                        document.getElementById('user-name').innerText = userName;
                    } else {
                        Swal.fire('Error', 'User name not found in sessionStorage', 'error');
                    }
                    console.log('Product ID:', productId);
                    console.log('User ID:', userId);

                    if (!userId) {
                        Swal.fire('Error', 'User ID not found in sessionStorage', 'error');
                        return;
                    }

                    const payload = {
                        product_id: productId,
                        user_id: userId
                    };

                    console.log('Payload:', payload);

                    fetch("{{ route('create.cart') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.status) {
                                Swal.fire('Success', 'Product added to cart successfully',
                                    'success');
                            } else {
                                Swal.fire('Error', data.message ||
                                    'Failed to add product to cart', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'An error occurred', 'error');
                        });
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + sessionStorage.getItem(
                        'jwt_token')
                }
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + sessionStorage.getItem(
                        'jwt_token')
                }
            });
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userName = sessionStorage.getItem('user_name');
            if (userName) {
                document.getElementById('user-name').innerText = userName;
            } else {
                console.log('User name not found in sessionStorage');
                Swal.fire('Error', 'User name not found in sessionStorage', 'error');
            }


        });
    </script>

    </html>
