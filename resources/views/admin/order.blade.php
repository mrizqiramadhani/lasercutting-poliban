@extends('layouts.navbar-admin')
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
        <div class="container mt-5">
            <div class="row">
                <div class="col">
                    <h1 class="text-center mb-5">Selamat Datang Admin <span id="user-name-dropdown"></span></h1>
                    @if ($transaction['status'] && count($transaction['data']) > 0)
                        <ul class="list-group">
                            @foreach ($transaction['data']->items() as $trans)
                                <li
                                    class="list-group-item d-flex flex-column flex-md-row align-items-center align-items-md-center justify-content-between">
                                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-center">
                                        <img src="{{ Storage::disk('public')->url($trans->photo_receipt) }}"
                                            class="img-fluid me-md-3 mb-3 mb-md-0" alt="Receipt"
                                            style="max-width: 10rem; max-height: 10rem;">
                                        <div>
                                            <strong>Invoice:</strong> {{ $trans->Invoice }} <br>
                                            <strong>User:</strong> {{ $trans->users->name ?? '-' }} <br>
                                            <strong>Total:</strong> Rp {{ number_format($trans->total, 2, ',', '.') }} <br>
                                            <strong>Status Order:</strong> {{ $trans->status_order }} <br>
                                            <strong>Payment At:</strong> {{ $trans->payment_at }} <br>
                                        </div>
                                    </div>
                                    <div class="mt-3 mt-md-0">
                                        <button type="button" class="btn btn-primary edit-transaction"
                                            data-transaction-id="{{ $trans->id }}" data-bs-toggle="modal"
                                            data-bs-target="#updateModal{{ $trans->id }}">Update Status</button>
                                    </div>
                                </li>
                                @include('admin.update-transaksi', ['trans' => $trans])
                            @endforeach
                        </ul>
                    @else
                        <p>No transactions found.</p>
                    @endif
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
