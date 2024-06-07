<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-md overflow-hidden">
            <div class="p-6">
                <h1 class="text-3xl font-semibold text-gray-800 mb-4">Welcome, Student!</h1>
                <p class="text-gray-600">You are logged in as a student.</p>
            </div>
            <form action="{{ route('student.logout') }}" method="POST" class="text-red-500 hover:text-red-700 font-semibold">
                @csrf
                <button type="submit">Logout</button>
            </form>            
        </div>
    </div>

</body>

</html>
