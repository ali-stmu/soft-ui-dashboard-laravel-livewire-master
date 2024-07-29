<!DOCTYPE html>
<html>

<head>
    <title>Document Assigned to You</title>
</head>

<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>A new document titled "{{ $document->title }}" has been assigned to you by {{ $creator->name }}.</p>
    <p>Description: {{ $document->description }}</p>
    <p>Dispatch Date: {{ $document->dispatch_date }}</p>
    <p>Approved Date: {{ $document->approved_date }}</p>
    <p>Best regards,</p>
    <p>MIS Department, Shifa Tameer Millat University</p>
</body>

</html>
