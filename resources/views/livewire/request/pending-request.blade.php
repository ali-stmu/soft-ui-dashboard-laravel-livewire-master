<div>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Attachment</th>
                <th>Dispatch Date</th>
                <th>Dispatcher</th>
                <th>Approved Date</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($requestes as $request)
                <tr>
                    <td>{{ $request->document->title }}</td>
                    <td>{{ $request->document->description }}</td>
                    <td>
                        @if ($request->document->attachment)
                            <a href="{{ asset('storage/' . $request->document->attachment) }}" target="_blank">View
                                Attachment</a>
                        @else
                            No attachment
                        @endif
                    </td>
                    <td>{{ $request->document->dispatch_date }}</td>
                    <td>{{ $request->document->dispatcher->name }}</td> <!-- Assuming dispatcher relation exists -->
                    <td>{{ $request->document->approved_date ?: '--' }}</td>
                    <td>
                        <!-- Button for forwarding -->
                        <button wire:click="approveRequest({{ $request->id }})" class="btn btn-primary" title="Approve">
                            <i class="fas fa-check-circle"></i>
                        </button>
                        <!-- Reject Button -->
                        <button wire:click="rejectRequest({{ $request->id }})" class="btn btn-primary" title="Reject">
                            <i class="fas fa-times-circle"></i>
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="approveConfirmationModal" tabindex="-1" aria-labelledby="approveConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveConfirmationModalLabel">Confirm Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="confirmApprove">
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <input wire:model.defer="remarks" type="text" class="form-control" id="remarks">
                        </div>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('showApproveModal', () => {
                $('#approveConfirmationModal').modal(
                    'show'); // Assuming you're using jQuery for Bootstrap modals
            });

            Livewire.on('closeModal', () => {
                $('#approveConfirmationModal').modal(
                    'hide'); // Assuming you're using jQuery for Bootstrap modals
            });
        });
    </script>
</div>
