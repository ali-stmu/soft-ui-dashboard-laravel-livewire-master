<div>
    <h3>Assigned Evaluation Forms</h3>

    <div class="mb-3">
        <input type="text" wire:model="search" class="form-control"
            placeholder="Search by Project Title, PI Name, or PI Email">
    </div>

    @if ($assignedForms->isEmpty())
        <p>No forms are assigned to you for evaluation.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Project Title</th>
                    <th>PI Name</th>
                    <th>PI Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignedForms as $forward)
                    <tr>
                        <td>{{ $forward->form->project_title }}</td>
                        <td>{{ $forward->form->pi_name }}</td>
                        <td>{{ $forward->form->pi_email }}</td>
                        <td>
                            <a href="{{ route('research-grants.show', $forward->form->id) }}"
                                class="btn btn-primary btn-sm">View</a>
                            <!-- Evaluate Now button -->
                            <a class="btn btn-secondary btn-sm"
                                wire:click="redirectToEvaluation({{ $forward->form->id }})">
                                Evaluate Now
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination controls -->
        {{ $assignedForms->links() }}
    @endif
</div>
