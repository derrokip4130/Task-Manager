<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Task Manager</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>

    <p>You have been added to the Task Management System.</p>

    <p><strong>Temporary Password:</strong> {{ $tempPassword }}</p>

    <p>Please log in using your email and this password:</p>

    <a href="{{ url('/login') }}">Log in</a>

    <p>Thanks,<br>The Admin Team</p>
</body>
</html>
