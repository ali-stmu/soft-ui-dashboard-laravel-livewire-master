<div>
    <h1 style="text-align: center; font-size: 1.5em; font-weight: bold;">
        Submitted Research Grants by {{ Auth::user()->name }}
    </h1>

    <div class="container mt-4">
        <!-- Search Bar -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by Project Title"
                    wire:model.debounce.500ms="search">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Sr.No</th> <!-- Added serial number header -->
                        <th>Project Title</th>
                        <th>PI Name</th>
                        {{-- <th>PI Designation</th>
                        <th>PI Email</th> --}}
                        <th>PI Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($oricForms as $index => $form)
                        <tr>
                            <td>{{ $loop->iteration + ($oricForms->currentPage() - 1) * $oricForms->perPage() }}</td>
                            <!-- Serial number -->
                            <td>{{ $form->project_title }}</td>
                            <td>{{ $form->pi_name }}</td>
                            {{-- <td>{{ $form->pi_designation }}</td>
                            <td>{{ $form->pi_email }}</td> --}}
                            <td>{{ $form->pi_department }}</td>
                            <td>
                                @if ($form->status_id == 5)
                                    <button wire:click="editForm({{ $form->id }})"
                                        class="btn btn-info btn-sm">Edit</button>
                                    <button wire:click="loadRemarks({{ $form->id }})"
                                        class="btn btn-secondary btn-sm">View Director Remarks</button>
                                    <button wire:click="" class="btn btn-info btn-sm">View Reviewer Remarks</button>
                                @endif
                                <a href="{{ route('research-grants.show', $form->id) }}"
                                    class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $oricForms->links() }}
            </div>
        </div>
    </div>

    <!-- Remarks Modal remains unchanged -->
    <div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remarksModalLabel">Remarks for Selected Research Grant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (count($remarks) > 0)
                        <ul class="list-group">
                            @foreach ($remarks as $remark)
                                <li class="list-group-item">
                                    <strong>{{ $remark->title }}</strong>
                                    <br>
                                    <small>By: {{ $remark->director->name }} </small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No remarks available for this form.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event to show the modal
            window.addEventListener('showRemarksModal', event => {
                $('#remarksModal').modal('show');
            });

            // Event to hide the modal if needed
            window.addEventListener('hideRemarksModal', event => {
                $('#remarksModal').modal('hide');
            });
        });
    </script>

</div>
