<!-- resources/views/emails/approval_request_alert.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Approval Request Alert</title>
</head>

<body>
    <h1>Approval Request Alert</h1>

    <p>This is a reminder that an approval request is pending for more than 3 days.</p>

    <p>
        <strong>Title:</strong> {{ $approvalRequest->document->title }}<br>
        <strong>Description:</strong> {{ $approvalRequest->document->description }}<br>
        <strong>Assigned To:</strong> {{ $approvalRequest->assignedTo->name }}<br>
    </p>

    <p>Please take the necessary action.</p>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>

</html>
