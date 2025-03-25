<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Clients</title>
</head>
<body>
    <h1>My Clients</h1>
    <a href="{{ route('my_client.create') }}">Create New Client</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->slug }}</td>
                    <td>
                        <a href="{{ route('my_client.edit', $client->slug) }}">Edit</a>
                        <form action="{{ route('my_client.delete', $client->slug) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
