<div>
    <h1>Submitted Research Grants</h1>

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
                                <a class="btn btn-info btn-sm">Edit</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
