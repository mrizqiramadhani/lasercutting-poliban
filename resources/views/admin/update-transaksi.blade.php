<!-- Edit Modal -->
<div class="modal fade" id="updateModal{{ $trans->id }}" tabindex="-1"
    aria-labelledby="updateModalLabel{{ $trans->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $trans->id }}">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateForm{{ $trans->id }}" action="{{ route('update.status', ['id' => $trans->id]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status_order" class="form-label">Status Order</label>
                        <select class="form-select" id="status_order" name="status_order">
                            <option value="waiting" {{ $trans->status_order === 'waiting' ? 'selected' : '' }}>Waiting
                            </option>
                            <option value="order_place" {{ $trans->status_order === 'order_place' ? 'selected' : '' }}>
                                Order Placed</option>
                            <option value="on_progress" {{ $trans->status_order === 'on_progress' ? 'selected' : '' }}>
                                On
                                Progress</option>
                            <option value="finished" {{ $trans->status_order === 'finished' ? 'selected' : '' }}>
                                Finished</option>
                            <option value="out_of_delivery"
                                {{ $trans->status_order === 'out_of_delivery' ? 'selected' : '' }}>Out for Delivery
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('form[id^="updateForm"]').off('submit').on('submit', function(event) {
            event.preventDefault();

            var form = $(this);
            var formData = form.serialize();
            var modalId = form.closest('.modal').attr('id');
            var submitButton = form.find('button[type="submit"]');

            submitButton.prop('disabled', true); // Disable the submit button

            $.ajax({
                type: 'PUT',
                url: form.attr('action'),
                data: formData,
                success: function(response) {
                    console.log('AJAX Success:', response);

                    if (response.status) {
                        // Close the modal
                        $('#' + modalId).modal('hide');

                        // Show SweetAlert notification
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 3000, // Close alert after 1 second
                            showConfirmButton: false
                        }).then(() => {
                            window.location
                                .reload(); // Refresh page after successful update
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to update transaction status: ' + response
                                .message,
                        });
                        submitButton.prop('disabled', false); // Re-enable the submit button
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'AJAX Error: ' + error,
                    });
                    submitButton.prop('disabled', false); // Re-enable the submit button
                }
            });
        });
    });
</script>
