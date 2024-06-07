<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-20 flex flex-col items-center">
        <h1 class="text-5xl font-bold mb-10">Welcome to Class Schedule Organizer</h1>
        <div class="space-x-4">
            <a href="{{ route('student.login') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-md font-semibold">Student Login</a>
            <a href="{{ route('student.register') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-md font-semibold">Student Registration</a>
            <a href="{{ route('teacher.login') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-md font-semibold">Teacher Login</a>
            <a href="{{ route('teacher.register') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-md font-semibold">Teacher Registration</a>
            <a href="{{ route('admin.login') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-md font-semibold">Admin Login</a>
        </div>
    </div>
</body>
</html>

