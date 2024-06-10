<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Registration</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-20 flex flex-col items-center">
        <h1 class="text-3xl font-bold mb-8">Teacher Registration</h1>
        <form action="{{ route('teacher.register') }}" method="POST">
            @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
        <strong>Error!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
            @endif
            @csrf
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="middle_initial" class="block text-gray-700">Middle Initial</label>
                <input type="text" name="middle_initial" id="middle_initial" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input mt-1 block w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-md font-semibold">Register</button>
        </form>
        <div class="mt-4">
            <a href="{{ route('welcome') }}" class="text-blue-500 hover:underline">Back to Welcome Page</a>
        </div>
    </div>
</body>
</html>
