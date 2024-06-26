@extends('layouts.navbar-user')
@extends('layouts.footer')
@section('order-classes', 'active')
@section('logout')

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
        <link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
        <link rel="stylesheet" href="{{ asset('css/beranda.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/beranda.css') }}">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body>
        <div class="container" style="margin-top: 150px">
            <div class="container mt-3">
                <div class="container marketing mt-5">
                    <div id="transactions-container" class="row">
                        <div class="row">
                            <h1 class="text-center mb-5">Selamat Datang User imuets</h1>
                            @if ($transaction['status'] && count($transaction['data']) > 0)
                                <ul class="list-group">
                                    @foreach ($transaction['data']->items() as $trans)
                                        <li class="list-group-item d-flex justify-content-start align-items-center">
                                            <div class="me-3">
                                                <img src="{{ !empty($trans->photo_receipt) ? Storage::disk('public')->url($trans->photo_receipt) : Storage::disk('public')->url('../assets/img/no_image.jpg') }}"
                                                    class="img-fluid" alt=""
                                                    style="max-width: 5rem; max-height: 5rem;">
                                            </div>
                                            <div>
                                                <strong>Invoice:</strong> {{ $trans->Invoice }} <br>
                                                <strong>User:</strong> {{ $trans->users->name ?? '-' }} <br>
                                                <strong>Total:</strong> Rp {{ number_format($trans->total, 2, ',', '.') }}
                                                <br>
                                                <strong>Status Order:</strong> {{ $trans->status_order }} <br>
                                                <strong>Payment At:</strong> {{ $trans->payment_at }} <br>
                                            </div>
                                            <div class="ms-auto">
                                                <button type="button" class="btn btn-primary edit-transaction"
                                                    data-transaction-id="{{ $trans->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#Track{{ $trans->id }}">Track Order</button>
                                            </div>
                                        </li>
                                        @include('user.track-transaksi', ['trans' => $trans])
                                    @endforeach
                                </ul>
                            @else
                                <p>No transactions found.</p>
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


    </html>
