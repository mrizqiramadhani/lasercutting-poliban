@extends('layouts.navbar-user')
@extends('layouts.footer')
@section('cart-user-classes', 'active')
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
                    <div id="articles-container" class="row">
                        <h1 class="text-center mb-5">Ini keranjang</h1>

                        <div class="row grid gap-5">
                            @if ($cart['status'] && count($cart['data']) > 0)
                            @foreach ($cart['data']->items() as $item)
                            @if ($item->deleted_at == null )
                                    <div class="col-lg-3 col-md-4 col-sm-6 p-0">
                                        <div class="card h-100 shadow-sm border-0"
                                            style="transition: box-shadow 0.3s ease-in-out; ">
                                            <img src="{{ !empty($item->product->photo) ? Storage::disk('public')->url($item->product->photo) : Storage::disk('public')->url('public/img/no-image.jpg') }}"
                                                class="card-img-top img-fluid" alt="{{ $item->product->name }}"
                                                style="height: 150px; object-fit: cover;" />
                                            <div class="card-body d-flex flex-column p-3">
                                                <h5 class="card-title">{{ $item->product->name  }}</h5>
                                                <p class="card-text">Rp
                                                    {{ number_format($item->product->price, 2, ',', '.') }}
                                                </p>
                                                <p class="card-text">{{ $item->product->description }}</p>
                                                <p class="card-text">{{ $item->product->stock }}</p>

                                                <div class="mt-auto">
                                                    <button type="button" class="btn btn-success btn-md"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#tambahtransaksimodal{{ $item->id }}">
                                                        Buy
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal{{ $item->id }}">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @include('user.tambah-transaksi', ['item' => $item])
                                    @include('user.hapus', ['item' => $item])
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


    </html>
