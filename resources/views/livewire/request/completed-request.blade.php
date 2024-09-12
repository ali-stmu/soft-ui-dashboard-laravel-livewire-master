<div>
    <div>
        <div class="row mb-4">
            <div class="col">
                <input type="text" wire:model="searchTerm" class="form-control"
                    placeholder="Search by title or description...">
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th> <!-- Serial number column -->

                    <th>Title</th>
                    <th>Description</th>
                    <th>Initiator</th>
                    <th>Attachment</th>
                    <th>Dispatch Date</th>
                    <th>Dispatcher</th>
                    <th>Approved Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestes as $index => $request)
                    <tr>
                        <td>{{ ($requestes->currentPage() - 1) * $requestes->perPage() + $index + 1 }}</td>
                        <!-- Display serial number -->
                        <td>{{ $request->document->title }}</td>
                        <td>{{ $request->document->description }}</td>
                        <td>{{ $request->assignedBy->name }}</td>
                        <td>
                            @if ($request->document->attachment)
                                <a href="{{ asset('storage/' . $request->document->attachment) }}" target="_blank">View
                                    Attachment</a>
                            @else
                                No attachment
                            @endif
                        </td>
                        <td>{{ optional($request->document)->dispatch_date ?? '--' }}</td>
                        <td>{{ optional($request->document->dispatcher)->name ?? '--' }}</td>
                        <td>{{ $request->signed_date ?? '--' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $requestes->links() }}
        </div>
    </div>



</div>
