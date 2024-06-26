<div>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Initiator</th>
                <th>Forwarded By</th>
                <th>Forwarded To</th>
                <th>Attachment</th>
                <th>Dispatch Date</th>
                <th>Dispatcher</th>
                <th>Forwarded Date</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($requestes as $request)
                <tr>
                    <td>{{ $request->document->title }}</td>
                    <td>{{ $request->document->description }}</td>
                    <td>
                        {{ $request->createdBy->name }}
                    </td>
                    <td>
                        {{ $request->assignedBy->name }}
                    </td>
                    <td>{{ $request->assignedTo->name }}</td>

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
                </tr>
            @endforeach
        </tbody>
    </table>


</div>
