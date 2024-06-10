<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
            <h1 class="text-2xl font-bold mb-6 text-center">Admin Login</h1>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded">Login</button>
                <div class="mt-4 text-center">
                    <a href="{{ route('welcome') }}" class="text-blue-500 hover:underline">Back to Welcome Page</a>
                </div>
            </form>     
        </div>
    </div>
</body>
</html>

