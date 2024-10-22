<div>
    <h1 style="text-align: center; font-size: 1.5em; font-weight: bold;">
        Submitted Research Grants by {{ Auth::user()->name }}
    </h1>

    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Project Title</th>
                        <th>PI Name</th>
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
                            <td>{{ $form->pi_designation }}</td>
                            <td>{{ $form->pi_email }}</td>
                            <td>{{ $form->pi_department }}</td>
                            <td>
                                {{-- Edit Only for status Returned --}}
                                @if ($form->status_id == 5)
                                    <button wire:click="editForm({{ $form->id }})"
                                        class="btn btn-info btn-sm">Edit</button>
                                    <a href="{{ route('research-grants.show', $form->id) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                @else
                                    <a href="{{ route('research-grants.show', $form->id) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
