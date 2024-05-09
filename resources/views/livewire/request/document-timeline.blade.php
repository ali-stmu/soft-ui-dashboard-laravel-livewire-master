<div class="container">
    @foreach ($documentTimeline as $documentData)
        <div class="card mb-3 approval-card">
            <div class="card-header approval-card-header">
                <h3>Document Title: {{ $documentData['document']['title'] ?? '' }}</h3>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item approval-card-content">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Description:</strong> {{ $documentData['document']['description'] ?? '' }}<br>
                            <strong>Initiated By:</strong> {{ $documentData['document']['initiator'] ?? '' }}
                        </div>
                    </div>
                    <hr>

                    @foreach ($documentData['approvalRequests'] as $index => $approvalRequest)
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Assigned By:</strong> {{ $approvalRequest['assignedBy'] ?? '' }}<br>
                                <strong>Assigned To:</strong> {{ $approvalRequest['assignedTo'] ?? '' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong>
                                @if ($approvalRequest['status'] === 'finalapproved')
                                    Forwarded
                                @else
                                    {{ $approvalRequest['status'] ?? '' }}
                                @endif
                                <br>
                                <strong>Signed Date:</strong> {{ $approvalRequest['signedDate'] ?? '' }}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </li>
            </ul>
        </div>
    @endforeach
</div>
