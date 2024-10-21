<div>
    <div class="container mt-4">
        <h2 class="mb-4">Research Grants</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Project Title</th>
                        <th>PI Name</th>
                        <th>Initiated By</th>
                        <th>PI Designation</th>
                        <th>PI Email</th>
                        <th>PI Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($oricForms as $form)
                        <tr>
                            <td>{{ $form->project_title }}</td>
                            <td>{{ $form->pi_name }}</td>
                            <td>{{ $form->user->name }}</td>
                            <td>{{ $form->pi_designation }}</td>
                            <td>{{ $form->pi_email }}</td>
                            <td>{{ $form->pi_department }}</td>
                            <td>
                                <a href="{{ route('research-grants.show', $form->id) }}"
                                    class="btn btn-info btn-sm">View</a>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#returnModal"
                                    data-user-id="{{ $form->user->id }}" data-id="{{ $form->id }}">Return</button>
                                <button class="btn btn-success btn-sm" data-id="{{ $form->id }}">Forward</button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Return Remarks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="returnRemarksForm" wire:submit.prevent="submitRemark"> <!-- Add the ID here -->
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
                    <!-- Add form attribute -->
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const returnButtons = document.querySelectorAll(
                'button[data-toggle="modal"][data-target="#returnModal"]');

            returnButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id'); // Get the user ID
                    const formId = this.getAttribute('data-id'); // Get the form ID
                    @this.set('selectedUserId', userId); // Set the selected user ID in Livewire
                    @this.set('selectedFormId', formId); // Set the selected form ID in Livewire
                    $('#returnModal').modal('show'); // Show the modal
                });
            });
        });
        window.addEventListener('refresh-page', () => {
            location.reload(); // Refresh the page on successful remark submission
        });
    </script>

</div>
