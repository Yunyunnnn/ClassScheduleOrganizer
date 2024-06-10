<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        @if(auth()->user()->approved)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                Your account is approved.
                <button onclick="this.parentElement.remove();" class="absolute top-0 bottom-0 right-0 px-4 py-3">X</button>
            </div>
        @else
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6">
                Your account is not yet verified by the admin. Please wait for approval.
            </div>
        @endif
        <h1 class="text-3xl font-bold mb-6">Welcome, Teacher</h1>
        <p class="text-gray-700 text-lg">Your content goes here.</p>
        <form method="POST" action="{{ route('teacher.logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded mt-6">Logout</button>
        </form>
    </div>
</body>
</html>

