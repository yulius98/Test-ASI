<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Client</title>
</head>
<body>
    <h1>Create New Client</h1>
    <form action="{{ route('my_client.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        
        <label for="slug">Slug:</label>
        <input type="text" name="slug" required>
        
        <label for="client_logo">Client Logo:</label>
        <input type="file" name="client_logo">
        
        <button type="submit">Create Client</button>
    </form>
    <a href="{{ route('my_client.index') }}">Back to Clients</a>
</body>
</html>
