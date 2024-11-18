<div>
    <div class="container mt-4">
        <h2 class="mb-4">Research Grants</h2>

        <!-- Search input -->
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Search by Project Title or PI Name"
                wire:model.debounce.300ms="search">
        </div>

        <!-- Table of Research Grants -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Serial No</th>
                        <th>Project Title</th>
                        <th>PI Name</th>
                        <th>Initiated By</th>
                        {{-- <th>PI Designation</th>
                        <th>PI Email</th> --}}
                        <th>PI Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($oricForms as $form)
                        <tr
                            class="{{ $form->status_id == 5 ? 'table-danger' : '' }} 
                                   {{ $form->is_forwarded ? 'table-success' : '' }}">
                            <td>{{ ($oricForms->currentPage() - 1) * $oricForms->perPage() + $loop->iteration }}</td>
                            <td>{{ $form->project_title }}</td>
                            <td>{{ $form->pi_name }}</td>
                            <td>{{ $form->user->name }}</td>
                            <td>{{ $form->pi_department }}</td>
                            <td>
                                <a href="{{ route('research-grants.show', $form->id) }}"
                                    class="btn btn-info btn-sm">View</a>
                                @if ($form->status_id != 5)
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#returnModal" data-user-id="{{ $form->user->id }}"
                                        data-id="{{ $form->id }}">Return</button>
                                    <button class="btn btn-success btn-sm" data-target="#forwardModal"
                                        data-id="{{ $form->id }}">Forward</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No research grants found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>




        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $oricForms->links() }}
        </div>
    </div>

    <!-- Return Modal (No changes needed here) -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Return Remarks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="returnRemarksForm" wire:submit.prevent="submitRemark">
                        <div class="mb-3">
                            <label for="remarks" class="label">Remarks</label>
                            <textarea class="form-control" id="remarks" rows="3" wire:model.defer="remarksTitle" required></textarea>
                        </div>
                        <input type="hidden" wire:model="selectedFormId">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" form="returnRemarksForm">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Forward Modal -->
    <!-- Forward Modal -->
    <div class="modal fade" id="forwardModal" tabindex="-1" aria-labelledby="forwardModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forwardModalLabel">Select Reviewers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="forwardForm" wire:submit.prevent="forwardForm">
                        <div class="mb-3">
                            <label class="form-label">Reviewers</label>
                            <div class="row">
                                @foreach ($reviewers as $reviewer)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="reviewer{{ $reviewer->id }}" wire:model="selectedReviewers"
                                                value="{{ $reviewer->id }}">
                                            <label class="form-check-label" for="reviewer{{ $reviewer->id }}">
                                                {{ $reviewer->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" form="forwardForm">Forward</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const returnButtons = document.querySelectorAll(
                'button[data-toggle="modal"][data-target="#returnModal"]');
            const forwardButtons = document.querySelectorAll(
                'button[data-target="#forwardModal"]'); // Add for Forward buttons

            returnButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const formId = this.getAttribute('data-id');
                    @this.set('selectedUserId', userId);
                    @this.set('selectedFormId', formId);

                    const returnModal = new bootstrap.Modal(document.getElementById('returnModal'));
                    returnModal.show();
                });
            });

            forwardButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const formId = this.getAttribute('data-id');
                    @this.set('selectedFormId', formId);

                    const forwardModal = new bootstrap.Modal(document.getElementById(
                        'forwardModal'));
                    forwardModal.show();
                });
            });

        });
    </script>

</div>
