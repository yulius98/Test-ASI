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
        
        <h2>AWS Credentials</h2>
        <label for="aws_access_key_id">AWS Access Key ID:</label>
        <input type="text" name="aws_access_key_id" required>
    
        <label for="aws_secret_access_key">AWS Secret Access Key:</label>
        <input type="text" name="aws_secret_access_key" required>
    
        <label for="aws_bucket">AWS Bucket Name:</label>
        <input type="text" name="aws_bucket" required>
    
        <button type="submit">Create Client</button>
    </form>
</body>
</html>
