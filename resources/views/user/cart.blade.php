@extends('layouts.navbar-user')
@extends('layouts.footer')
@extends('layouts.contact')
@section('cart-classes', 'active')
@section('logout')


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Laser Cutting Poliban</title>

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

    </head>

    <body>
        <div class="container" style="margin-top: 150px">
            <div class="container mt-3">
                <div class="container marketing mt-5">
                    <div id="articles-container">
                        <h1 class="text-start mb-5">Keranjang <span id="user-name-dropdown"></span></h1>
                        <div class="row justify-content-start gx-5">
                            @if ($cart['status'] && count($cart['data']) > 0)
                                @foreach ($cart['data']->items() as $item)
                                    @if ($item->deleted_at == null)
                                        <div class="col-12 mb-4">
                                            <div class="card h-100">
                                                <div class="row g-0 align-items-center">
                                                    <!-- Image Column -->
                                                    <div class="col-md-3">
                                                        <img src="{{ !empty($item->product->photo) ? Storage::disk('public')->url($item->product->photo) : Storage::disk('public')->url('public/img/no-image.jpg') }}"
                                                            class="img-fluid rounded-start" alt="{{ $item->product->name }}"
                                                            style="object-fit: cover; width: 100%; height: 250px;">
                                                    </div>
                                                    <!-- Text Column -->
                                                    <div class="col-md-9">
                                                        <div
                                                            class="card-body d-flex flex-column justify-content-between h-100">
                                                            <div class="mb-3">
                                                                <h5 class="card-title mb-1">{{ $item->product->name }}</h5>
                                                                <p class="card-text text-muted">
                                                                    {{ $item->product->description }}</p>
                                                                <p class="card-text text-muted mb-2">Stok:
                                                                    {{ $item->product->stock }}</p>
                                                                <p class="card-text text-success fw-bold">Rp
                                                                    {{ number_format($item->product->price, 2, ',', '.') }}
                                                                </p>
                                                            </div>
                                                            <div
                                                                class="d-flex justify-content-end align-items-center mt-auto">
                                                                <!-- Add Transaction Button -->
                                                                <button type="button" class="btn btn-success btn-md me-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#tambahtransaksimodal{{ $item->id }}">
                                                                    Buy
                                                                </button>
                                                                <!-- Delete Button -->
                                                                <button type="button" class="btn btn-outline-danger btn-md"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapusModal{{ $item->id }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor"
                                                                        style="width: 20px; height: 20px;">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Include Modals for Add Transaction and Delete -->
                                            @include('user.tambah-transaksi', ['item' => $item])
                                            @include('user.hapus', ['item' => $item])
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p>No products found.</p>
                            @endif
                        </div>


                        {{-- ccss --}}
                        {{-- <div class="container">
                                <h1 class="mb-5 text-center text-2xl font-bold">Cart Items</h1>
                                <div class="row justify-content-center gx-5">
                                    <div class="col-lg-8">
                                        <div class="card mb-3">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                                                        class="img-fluid rounded-start" alt="product-image">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body d-flex flex-column justify-content-between">
                                                        <div>
                                                            <h5 class="card-title">Nike Air Max 2019</h5>
                                                            <p class="card-text text-muted">36EU - 4US</p>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 me-3">259.000 ₭</p>
                                                                <button class="btn btn-outline-danger btn-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor"
                                                                        style="width: 20px; height: 20px;">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        {{-- sadsd --}}

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
                    'Authorization': 'Bearer ' + sessionStorage.getItem('jwt_token')
                }
            });

            $('.tambah-transaksi-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var cartData = [];

                // Collect the cart data
                cartData.push({
                    id: $(this).find('input[name="cart_id"]').val(),
                    stock: $(this).find('input[name="stock"]').val()
                });

                // Append the cart data as a JSON string
                formData.append('cart', JSON.stringify(cartData));

                console.log('sdadas', cartData)
                // Append photo receipt data
                var photo_receipt = $(this).find('input[name="photo_receipt"]')[0].files[0];
                if (photo_receipt) {
                    formData.append('photo_receipt', photo_receipt);
                }

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Response:', response);

                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('.modal').modal('hide');
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Terjadi kesalahan'
                            });
                        }
                    },
                    error: function(response) {
                        console.error('Error response:', response);
                        let errorMsg = 'Terjadi kesalahan';

                        if (response.responseJSON && response.responseJSON.errors) {
                            errorMsg = '';
                            $.each(response.responseJSON.errors, function(key, value) {
                                errorMsg += value + '\n';
                            });
                        } else if (response.responseText) {
                            errorMsg = response.responseText;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: errorMsg
                        });
                    }
                });
            });
        });
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

    </html>
