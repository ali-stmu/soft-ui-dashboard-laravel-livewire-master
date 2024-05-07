<div>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Initiator</th>
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
                        {{ $request->assignedBy->name }}
                    </td>
                    <td>
                        @if ($request->document->attachment)
                            <a href="{{ asset('storage/' . $request->document->attachment) }}" target="_blank">View
                                Attachment</a>
                        @else
                            No attachment
                        @endif
                    </td>
                    <td>{{ $request->document->dispatch_date }}</td>
                    <td>{{ $request->document->dispatcher->name }}</td>
                    <td>{{ $request->document->approved_date ?: '--' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" wire:click="approveRequest({{ $request->id }})">
                                        Return with Signature</a></li>
                                <li><a class="dropdown-item"
                                        wire:click="returnWithoutSignature({{ $request->id }})">Return
                                        without Signature</a></li>
                                <li><a class="dropdown-item" wire:click="forwardRequest({{ $request->id }})">Forward
                                        with Signature</a></li>
                                <li><a class="dropdown-item" wire:click="forwardRequest({{ $request->id }})">Forward
                                        without Signature</a></li>
                            </ul>
                        </div>
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
                    <button type="button" class="btn-close-black" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input wire:model.defer="remarks" type="text" class="form-control"
                                        id="remarks">
                                </div>
                                <div class="col">
                                    <label for="date" class="form-label">Return/Forward Date</label>
                                    <input wire:model.defer="returnForwardDate" type="date" class="form-control"
                                        id="returnForwardDate">
                                </div>
                            </div>
                        </div>
                        <button wire:click="confirmApprove" type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showReturnWithoutSignatureModal" tabindex="-1"
        aria-labelledby="approveConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveConfirmationModalLabel">Confirm Approval Without Signature</h5>
                    <button type="button" class="btn-close-black" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="rejectremarks" class="form-label">Remarks</label>
                                    <input wire:model.defer="rejectremarks" type="text" class="form-control"
                                        id="rejectremarks">
                                </div>
                                <div class="col">
                                    <label for="date" class="form-label">Return/Forward Date</label>
                                    <input wire:model.defer="rejectreturnForwardDate" type="date"
                                        class="form-control" id="rejectreturnForwardDate">
                                </div>
                            </div>
                        </div>
                        <button wire:click="rejectRequest" type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('showApproveModal', () => {
                $('#approveConfirmationModal').modal('show');
            });

            Livewire.on('closeModal', () => {
                $('#approveConfirmationModal').modal('hide');
            });
            Livewire.on('showReturnWithoutSignatureModal', () => {
                $('#showReturnWithoutSignatureModal').modal('show');
            });

            Livewire.on('closeModal', () => {
                $('#showReturnWithoutSignatureModal').modal('hide');
            });
            Livewire.on('forwardWithSignatureModal', () => {
                $('#forwardWithSignatureModal').modal('show');
            });
            Livewire.on('closeModal', () => {
                $('#forwardWithSignatureModal').modal('hide');
            });


        });
    </script>
</div>
