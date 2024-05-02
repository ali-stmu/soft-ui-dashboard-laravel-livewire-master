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
                    <td>{{ $request->signed_date ?: '--' }}</td>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</div>
