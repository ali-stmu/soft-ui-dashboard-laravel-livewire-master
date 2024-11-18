<!DOCTYPE html>
<html>

<head>
    <title>ORIC Form Forwarded for Review</title>
</head>

<body>
    <p>Dear {{ $reviewerName }},</p>

    <p>You have been assigned to review the ORIC form titled: <strong>{{ $formTitle }}</strong>.</p>

    <p>This is a formal reminder that the review must be completed within <strong>10 working days</strong> from today,
        {{ \Carbon\Carbon::now()->format('F j, Y') }}. We kindly request you to ensure the review is submitted by
        <strong>{{ \Carbon\Carbon::now()->addWeekdays(10)->format('F j, Y') }}</strong>.
    </p>

    <p>Please review the form and provide your feedback at the earliest.</p>

    <p>Thank you for your cooperation.</p>

    <p>Best regards,<br>{{ $directorName }}<br>Director ORIC</p>
</body>

</html>
