<!DOCTYPE html>
<html>

<head>
    <title>Your Account Information Has Been Updated</title>
</head>

<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>Your account information at the Diary Management System has been updated. Here are the changes:</p>
    <ul>
        @foreach ($changes as $field => $change)
            <li><strong>{{ ucfirst($field) }}:</strong> {{ $change['old'] }} -> {{ $change['new'] }}</li>
        @endforeach
    </ul>
    <p>Best regards,</p>
    <p>MIS Department, Shifa Tameer Millat University</p>
</body>

</html>
