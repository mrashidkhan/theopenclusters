<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message from Open Clusters Systems</title>
</head>
<body>
    <h1>New Contact Message from Open Clusters Systems</h1>
    <p><strong>Name:</strong> {{ $contactData['name'] }}</p>
    <p><strong>Email:</strong> {{ $contactData['email'] }}</p>
    <p><strong>Subject:</strong> {{ $contactData['subject'] ?? 'No subject provided' }}</p>
    <p><strong>Message:</strong> {{ $contactData['message'] }}</p>
</body>
</html>
