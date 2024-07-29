<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Diary Management System</title>
</head>

<body>
    <h1>Welcome, {{ $user->name }}</h1>
    <p>Welcome to the Diary Management System powered by the MIS department at Shifa Tameer Millat University.</p>
    <p>We are excited to have you on board.</p>
    <p><strong>Department:</strong> {{ $department->name }}</p>
    <p><strong>Designation:</strong> {{ $designation->name }}</p>
    <p><strong>Role:</strong> {{ $role->name }}</p>
</body>

</html>
