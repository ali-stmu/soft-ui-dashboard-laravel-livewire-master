<div class="text-center">
    <div style="margin-left: 5rem; margin-right: 5rem;">
        <table class="table mx-auto">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Initiator</th>
                    <th>Attachment</th>
                    <th>Dispatch Date</th>
                    <th>Dispatcher</th>
                    <th>Approved Date</th>
                    <th>Receiving Date</th> <!-- Added column -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestes as $request)
                    @php
                        // Calculate the difference in days between the current date and the request's creation date
                        $differenceInDays = now()->diffInDays($request->created_at);
                    @endphp
                    <tr style="{{ $differenceInDays > 3 ? 'color: red;' : '' }}">
                        <td>
                            <button wire:click="getAllApprovalRequests({{ $request->document->id }})"
                                class="document-title" data-toggle="modal"
                                data-target="#documentDetailsModal{{ $request->id }}">
                                {{ $request->document->title }}
                            </button>
                        </td>
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
                        @if ($request->receiving_date)
                            <td>{{ $request->receiving_date }} </td>
                        @else
                            <td>
                                <input type="date" wire:model.defer="receivingDates.{{ $request->id }}" />
                                <button wire:click="saveReceivingDate({{ $request->id }})"
                                    class="btn btn-success">Save</button>
                            </td>
                        @endif
                        <td>
                            <div class="dropdown">

                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" wire:click="approveRequest({{ $request->id }})">
                                            Return with Signature</a></li>
                                    <li><a class="dropdown-item"
                                            wire:click="returnWithoutSignature({{ $request->id }})">Return
                                            without Signature</a></li>
                                    <li><a class="dropdown-item"
                                            wire:click="forwardRequest({{ $request->id }})">Forward
                                            with Signature</a></li>
                                    <li><a class="dropdown-item"
                                            wire:click="forwardRequest({{ $request->id }})">Forward
                                            without Signature</a></li>
                                </ul>
                            </div>

                        </td>
                    </tr>
                    <div class="modal fade" id="documentDetailsModal{{ $request->id }}" tabindex="-1"
                        aria-labelledby="documentDetailsModalLabel{{ $request->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="documentDetailsModalLabel{{ $request->id }}">Document
                                        Details</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body"> <!-- Modified line -->
                                    <!-- Display document details here -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <x-bladewind::timeline-group align_left="true" position="left"
                                                anchor="big" stacked="true">

                                                @foreach ($documentTimeline as $key => $documentData)
                                                    @php
                                                        // Generate a random color for each document
                                                        $colors = ['orange', 'green', 'purple', 'gray', 'pink', 'blue'];
                                                        $randomColor = $colors[array_rand($colors)];
                                                    @endphp
                                                    <x-bladewind::timeline-group color="{{ $randomColor }}">
                                                        <x-bladewind::timeline
                                                            date="{{ $documentData['document']['created_at']->diffForHumans() }}">
                                                            <x-slot:content>
                                                                <ul>
                                                                    <li>
                                                                        <strong>Title:</strong>
                                                                        {{ $documentData['document']['title'] }}
                                                                    </li>

                                                                    <li><strong>Description:</strong>
                                                                        {{ $documentData['document']['description'] }}
                                                                    </li>
                                                                    <li><strong>Initiated By:</strong>
                                                                        {{ $documentData['document']['initiator'] }}
                                                                    </li>
                                                                    <hr>
                                                                    <x-bladewind::timeline-group>
                                                                        @foreach ($documentData['approvalRequests'] as $approvalRequest)
                                                                            <x-bladewind::timeline
                                                                                date="{{ $approvalRequest['created_at']->diffForHumans() }}">
                                                                                <x-slot:content>
                                                                                    <div class="row">
                                                                                        <div class="col-md-1">
                                                                                            <strong
                                                                                                class="index-number">{{ $loop->iteration }}</strong>
                                                                                        </div>
                                                                                        <div class="col-md-5">
                                                                                            <strong>Assigned
                                                                                                By:</strong>
                                                                                            {{ $approvalRequest['assignedBy'] }}<br>
                                                                                            <strong>Assigned
                                                                                                To:</strong>
                                                                                            {{ $approvalRequest['assignedTo'] }}
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <strong>Status:</strong>
                                                                                            @if ($approvalRequest['status'] === 'finalapproved')
                                                                                                Forwarded
                                                                                            @else
                                                                                                {{ $approvalRequest['status'] }}
                                                                                            @endif
                                                                                            <br>
                                                                                            <strong>Signed
                                                                                                Date:</strong>
                                                                                            {{ $approvalRequest['signedDate'] }}
                                                                                        </div>
                                                                                    </div>
                                                                                </x-slot:content>
                                                                            </x-bladewind::timeline>
                                                                            <hr>
                                                                        @endforeach
                                                                    </x-bladewind::timeline-group>
                                                                </ul>
                                                            </x-slot:content>
                                                        </x-bladewind::timeline>
                                                    </x-bladewind::timeline-group>
                                                @endforeach
                                            </x-bladewind::timeline-group>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="approveConfirmationModal" tabindex="-1"
            aria-labelledby="approveConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveConfirmationModalLabel">Confirm Approval</h5>
                        <button type="button" class="btn-close-black" data-bs-dismiss="modal"
                            aria-label="Close">X</button>
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
                        <h5 class="modal-title" id="approveConfirmationModalLabel">Confirm Approval Without Signature
                        </h5>
                        <button type="button" class="btn-close-black" data-bs-dismiss="modal"
                            aria-label="Close">X</button>
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
                            <button wire:click="rejectRequest" type="submit"
                                class="btn btn-primary">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // JavaScript to handle click event on document title
            document.addEventListener('DOMContentLoaded', function() {
                const documentTitles = document.querySelectorAll('.document-title');
                documentTitles.forEach(title => {
                    title.addEventListener('click', function(event) {
                        event.preventDefault();
                        const targetModalId = this.getAttribute('data-target');
                        const targetModal = document.querySelector(targetModalId);
                        $(targetModal).modal('show');
                    });
                });
            });
        </script>

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
</div>
