<!DOCTYPE html>
<html>

<head>
    <title>Document Created</title>
</head>

<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>Your document titled "{{ $document->title }}" has been created successfully.</p>
    <p>Description: {{ $document->description }}</p>
    <p>Dispatch Date: {{ $document->dispatch_date }}</p>
    <p>Approved Date: {{ $document->approved_date }}</p>
    <p>Best regards,</p>
    <p>MIS Department, Shifa Tameer Millat University</p>
</body>

</html>
