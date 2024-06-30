@extends('layouts.navbar-admin')
@extends('layouts.footer')
@section('beranda-classes', 'active')
@section('logout')
    @extends('admin.pesan')
    @extends('admin.tambah')
    {{-- @extends('admin.edit')
    @extends('admin.hapus') --}}


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
        {{-- <link rel="stylesheet" href="{{ asset('css/transaction.css') }}"> --}}
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
                <div class="d-flex justify-content-between">
                    <h1 class="text-start mb-5">Selamat Datang Admin lopyu</h1>
                    <div>
                        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                            data-bs-target="#tambahmodal"><span class="bi bi-plus-circle-fill"></span>&nbsp;Tambah
                            Barang</button>
                    </div>
                </div>

                <div class="container marketing mt-5">
                    <div id="articles-container" class="row">
                        <div class="row">

                            <div class="row grid gap-5">
                                @if ($products['status'] && count($products['data']) > 0)
                                    @foreach ($products['data']->items() as $item)
                                        <div class="col-lg-3 col-md-4 col-sm-6 p-0">
                                            <div class="card h-100 shadow-sm border-0"
                                                style="transition: box-shadow 0.3s ease-in-out; ">
                                                <img src="{{ !empty($item->photo) ? Storage::disk('public')->url($item->photo) : Storage::disk('public')->url('public/img/no-image.jpg') }}"
                                                    class="card-img-top img-fluid" alt="{{ $item->name }}"
                                                    style="height: 150px; object-fit: cover;">
                                                <div class="card-body d-flex flex-column p-3">
                                                    <h5 class="card-title">{{ $item->name }}</h5>
                                                    <p class="card-text">Rp {{ number_format($item->price, 2, ',', '.') }}
                                                    </p>
                                                    <p class="card-text">{{ $item->description }}</p>
                                                    <p class="card-text">Stok: {{ $item->stock }}</p>
                                                    <div class="mt-auto">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            <i class="bi bi-pen"></i> Edit
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
                                        @include('admin.edit', ['item' => $item])
                                        @include('admin.hapus', ['item' => $item])
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
