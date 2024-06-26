<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm{{ $item->id }}" action="{{ route('update.product') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name"
                            value="{{ $item->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="editStock" name="stock"
                            value="{{ $item->stock }}" required maxlength="7" </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="editPrice" name="price"
                                value="{{ $item->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3" required>{{ $item->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editPhoto" class="form-label">Photo URL</label>
                            <input type="file" class="form-control" id="editPhoto" name="photo" accept="image/*"
                                value="{{ $item->photo }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('form[id^="editForm"]').on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('AJAX Success:', response);

                    if (response.status) {
                        // Close the modal
                        var modalId = $(event.target).closest('.modal').attr('id');
                        $('#' + modalId).modal('hide');

                        // Show SweetAlert notification
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to update product: ' + response.message,
                        });
                    }
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'AJAX Error: ' + error,
                    });
                }
            });
        });
    });
</script>
