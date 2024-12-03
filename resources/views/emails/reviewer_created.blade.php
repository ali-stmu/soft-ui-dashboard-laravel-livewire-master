<!DOCTYPE html>
<html>

<head>
    <title>Reviewer Account Created</title>
</head>

<body>
    <h1>Welcome, {{ $name }}!</h1>
    <p>We are pleased to inform you that your reviewer account has been successfully created.</p>
    <p>Your registered email is: <strong>{{ $email }}</strong></p>
    <p>Your temporary password is: <strong>{{ $password }}</strong></p>
    <p>Please use the link below to log in to your account and update your password:</p>
    <p>
        <a href="https://diary.stmu.edu.pk/login" target="_blank">
            Click here to log in
        </a>
    </p>
    <p>We appreciate your valuable contributions and look forward to your collaboration.</p>
    <p>Best regards,</p>
    <p>The ORIC Team</p>
</body>

</html>
