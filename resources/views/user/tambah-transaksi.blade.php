<!-- Modal -->
<div class="modal fade" id="tambahtransaksimodal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Beli</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambah-transaksi-form" action="{{ route('payment') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="status_order" value="waiting">
                <input type="hidden" name="cart_id" value="{{ $item->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="photo_receipt" class="form-label">Bukti Transfer </label>
                        <input type="file" class="form-control" id="photo_receipt" name="photo_receipt"
                            accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="stock{{ $item->id }}" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock{{ $item->id }}" name="stock"
                            min="1" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" style="color: green">Beli</button>
                    </div>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt_token')
            }
        });

        $('#tambah-transaksi-form').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var cartData = [];

            cartData.push({
                id: $(this).find('input[name="cart_id"]').val(),
                stock: $(this).find('input[name="stock"]').val()
            });

            formData.append('cart', JSON.stringify(cartData));
            console.log('sdadas', cartData)
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
