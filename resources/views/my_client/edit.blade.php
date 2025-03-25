<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
</head>
<body>
    <h1>Edit Client</h1>
    <form action="{{ route('my_client.update', $client->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $client->name }}" required>
        
        <label for="slug">Slug:</label>
        <input type="text" name="slug" value="{{ $client->slug }}" required>
        
        <label for="client_logo">Client Logo:</label>
        <input type="file" name="client_logo">
        
        <button type="submit">Update Client</button>
    </form>
    <a href="{{ route('my_client.index') }}">Back to Clients</a>
</body>
</html>
