   {{-- login modal --}}
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="authentication-modalLabel">Login</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="login-form" class="space-y-4" action="{{ route('login.submit') }}" method="POST">
                       @csrf
                       <div class="mb-3">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" class="form-control" id="email" name="email"
                               placeholder="nama@gmail.com" required>
                       </div>
                       <div class="mb-3">
                           <label for="password" class="form-label">Password</label>
                           <input type="password" class="form-control" id="password" name="password"
                               placeholder="••••••••" required>
                       </div>
                       <div class="d-flex justify-content-between align-items-center mb-3">
                           <div class="form-check">
                               <input class="form-check-input" type="checkbox" value="" id="remember">
                               <label class="form-check-label" for="remember">Remember me</label>
                           </div>
                           <a href="#" class="text-sm text-decoration-none text-muted">Lost Password?</a>
                       </div>
                       <button type="submit" class="btn btn-primary w-100">Login</button>
                       <div class="text-center mt-3">
                           Belum punya akun? <a href="#" class="text-decoration-none text-muted"
                               data-bs-toggle="modal" data-bs-target="#exampleModal2">Buat Akun</a>
                       </div>
                   </form>
               </div>
           </div>

       </div>
   </div>
   {{-- end-modal login --}}

   {{-- modal register --}}
   <div class="modal fade" id="exampleModal2" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="authentication-modalLabel">Register</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="register-form" action="{{ route('register.submit') }}" method="POST">
                       @csrf
                       <div class="mb-3">
                           <label for="name" class="form-label">Nama</label>
                           <input type="text" class="form-control" id="name" name="name"
                               placeholder="Nama anda" required>
                       </div>
                       <div class="mb-3">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" class="form-control" id="email" name="email"
                               placeholder="nama@gmail.com" required>
                       </div>
                       <div class="mb-3">
                           <label for="password" class="form-label">Password</label>
                           <input type="password" class="form-control" id="password" name="password"
                               placeholder="••••••••" required>
                       </div>
                       <div class="mb-3">
                           <label for="confirm_password" class="form-label">Confirm Password</label>
                           <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                               placeholder="••••••••" required>
                       </div>
                       <button type="submit" class="btn btn-primary w-100">Register</button>
                   </form>
               </div>
           </div>
       </div>
   </div>
   {{-- end-modal register --}}


   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


   <script>
       $(document).ready(function() {
           $('#login-form').on('submit', function(e) {
               e.preventDefault();
               var formData = new FormData(this);

               $.ajax({
                   headers: {
                       //    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   type: 'POST',
                   url: $(this).attr('action'),
                   data: formData,
                   processData: false,
                   contentType: false,
                   success: function(response) {
                       console.log('Response:', response);

                       if (response.success) {
                           // Decode JWT token
                           try {
                               console.log(response.data.id)
                               sessionStorage.setItem('jwt_token', response.data.token);

                               sessionStorage.setItem('user_name', response.data.name);
                               sessionStorage.setItem('user_id', response.data.id);
                               // Check if role_id is present in decoded token data
                               if (response.data.role_name === 'admin') {
                                   Swal.fire({
                                       icon: 'success',
                                       title: 'Login Berhasil',
                                       text: 'Anda akan diarahkan ke halaman admin.',
                                       timer: 2000,
                                       showConfirmButton: false
                                   }).then(() => {
                                       console.log(response.data)
                                       window.location.href =
                                           '/admin'; // Redirect to admin dashboard
                                   });
                               } else {
                                   Swal.fire({
                                       icon: 'success',
                                       title: 'Login Berhasil',
                                       text: 'Anda akan diarahkan ke halaman pengguna.',
                                       timer: 2000,
                                       showConfirmButton: false
                                   }).then(() => {
                                       window.location.href =
                                           '/dashboard'; // Redirect to regular user dashboard
                                   });
                               }
                           } catch (error) {
                               console.error('Error decoding token:', error);
                               Swal.fire({
                                   icon: 'error',
                                   title: 'Login Gagal',
                                   text: 'Gagal mendekode token JWT'
                               });
                           }
                       } else {
                           Swal.fire({
                               icon: 'error',
                               title: 'Login Gagal',
                               text: response.error || 'An unknown error occurred'
                           });
                       }
                   },
                   error: function(response) {
                       console.error('Error response:', response);
                       let errors = response.responseJSON ? response.responseJSON.errors :
                           null;
                       let errorMsg = 'An unknown error occurred';

                       if (errors) {
                           errorMsg = '';
                           for (let error in errors) {
                               errorMsg += errors[error] + '\n';
                           }
                       } else if (response.responseText) {
                           errorMsg = response.responseText;
                       }

                       Swal.fire({
                           icon: 'error',
                           title: 'Login Gagal',
                           text: errorMsg
                       });
                   }
               });
           });

           $('#register-form').on('submit', function(e) {
               e.preventDefault();
               var formData = new FormData(this);
               $.ajax({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   type: 'POST',
                   url: $(this).attr('action'),
                   data: formData,
                   processData: false,
                   contentType: false,
                   success: function(response) {
                       Swal.fire({
                           icon: 'success',
                           title: 'Registrasi Berhasil',
                           text: 'Silakan login menggunakan akun Anda.'
                       }).then(() => {
                           $('#exampleModal2').modal('hide');
                           $('#exampleModal').modal('show');
                       });
                   },
                   error: function(response) {
                       console.error('Error response:', response);
                       let errors = response.responseJSON ? response.responseJSON.errors :
                           null;
                       let errorMsg = 'An unknown error occurred';
                       if (errors) {
                           errorMsg = '';
                           for (let error in errors) {
                               errorMsg += errors[error] + '\n';
                           }
                       } else if (response.responseText) {
                           errorMsg = response.responseText;
                       }
                       Swal.fire({
                           icon: 'error',
                           title: 'Registrasi Gagal',
                           text: errorMsg
                       });
                   }
               });
           });
       });
   </script>
