<div class="modal fade" id="hapusModal{{ $item->id }}" tabindex="-1" aria-labelledby="popup-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popup-modal-label">Hapus Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Apakah kamu yakin ingin menghapus barang ini?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm{{ $item->id }}" action="{{ route('delete.product', $item->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Menggunakan event delegation untuk menangani submit form
        $(document).off('submit', 'form[id^="deleteForm"]'); // Lepas event handler lama jika ada
        $(document).on('submit', 'form[id^="deleteForm"]', function(event) {
            event.preventDefault(); // Mencegah pengiriman form bawaan

            var form = $(this); // Menyimpan elemen form yang dipilih

            $.ajax({
                type: 'DELETE',
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log('AJAX Success:', response);

                    if (response.status) {
                        // Tampilkan notifikasi SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500, // Tutup notifikasi setelah 1.5 detik
                        }).then(() => {
                            // Tutup modal setelah notifikasi
                            form.closest('.modal').modal('hide');

                            // Hapus elemen produk dari halaman
                            var productCard = form.closest('.col-lg-4');
                            if (productCard.length > 0) {
                                productCard.remove();
                            } else {
                                console.warn(
                                'Elemen kartu produk tidak ditemukan.');
                            }

                            // Reload halaman setelah modal ditutup
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal menghapus produk: ' + response.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);

                    if (xhr.status === 422) {
                        // Handle error khusus ketika status adalah 422 (Unprocessable Entity)
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = "Validasi error:<br>";
                        $.each(errors, function(key, value) {
                            errorMessage += value + "<br>";
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: errorMessage,
                        });
                    } else {
                        // Penanganan error umum
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'AJAX Error: ' + error,
                        });
                    }
                }
            });
        });
    });
</script>
