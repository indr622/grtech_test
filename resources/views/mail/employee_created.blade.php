<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Employee Created</title>
</head>

<body>
    <h1>New Employee Created</h1>
    <p>Dear {{ $employee->company->name }},</p>
    <p>A new employee has been added to your company:</p>

    <p><strong>First Name:</strong> {{ $employee->first_name }}</p>
    <p><strong>Last Name:</strong> {{ $employee->last_name }}</p>
    <p><strong>Email:</strong> {{ $employee->email }}</p>
    <p><strong>Phone:</strong> {{ $employee->phone }}</p>

    <p>Best regards,<br>{{ config('app.name') }}</p>
</body>

</html>
