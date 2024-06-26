<!-- Modal -->
<div class="modal fade" id="tambahmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambah-product-form" action="{{ route('create.product') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama barang</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nama barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto barang</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok barang</label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            placeholder="Stok barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">harga</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Harga"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Deskripsi barang"
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" style="color: white">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/dist/jwt-decode.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tambah-product-form').on('submit', function(e) {
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
                    console.log('Response:', response);

                    // Check if response contains the 'data' field to determine success
                    if (response.data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            $('#tambahmodal').modal('hide');
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
