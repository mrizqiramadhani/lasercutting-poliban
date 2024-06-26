@extends('layouts.navbar-admin')
@section('user-classes', 'active')
@extends('layouts.footer')

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    {{-- link rel css --}}
    <link rel="stylesheet" href="{{ asset('css/beranda.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">
</head>

<body>

    <div class="container " style="margin-top: 10rem">
        <h1>Edit Profile Settings</h1>
        <img src="{{ !empty($user['data']->photo) ? Storage::disk('public')->url($user['data']->photo) : Storage::disk('public')->url('public/img/no-image.jpg') }}"
            class="rounded-circle img-fluid mb-5" alt="{{ $user['data']->name }}"
            style="width: 150px; height: 150px; object-fit: cover;">
        <form id="editProfileForm" action="{{ route('update.user') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $user['data']->id }}">
            <input type="hidden" name="role" value="{{ $user['data']->role->name }}">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="editName" name="name"
                    value="{{ $user['data']->name }}" required>

            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control " id="editEmail" name="email"
                    value="{{ $user['data']->email }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                    name="phone_number" value="{{ $user['data']->phone_number }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="editAddress" name="address"
                    value="{{ $user['data']->address }}" required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Profile Photo</label>
                <input type="file" class="form-control" id="editPhoto" accept="image/*" name="photo"
                    value="{{ $user['data']->photo }}">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>

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
<script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $('#editProfileForm').on('submit', function(event) {
            event.preventDefault();

            const form = this;
            const formData = new FormData(form);

            $.ajax({
                type: form.method,
                url: form.action,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Response:', response);

                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Profile updated successfully',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to update profile'
                        });
                    }
                },
                error: function(response) {
                    console.error('Error response:', response);
                    let errorMsg = 'An error occurred while updating profile';

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
                        title: 'Error',
                        text: errorMsg
                    });
                }
            });
        });
    });
</script>
