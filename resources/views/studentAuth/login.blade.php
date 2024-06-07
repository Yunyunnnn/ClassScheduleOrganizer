<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


</head>
<body class="bg-gray-100">
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold mb-8 text-center">Login</h1>
            <form action="{{ route('student.login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="student_id" class="block text-gray-700">Student ID</label>
                    <input type="text" name="student_id" id="student_id" class="form-input mt-1 block w-full" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="form-input mt-1 block w-full" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</button>
            </form>
            <div class="mt-4 text-center">
                <a href="{{ route('welcome') }}" class="text-blue-500 hover:underline">Back to Welcome Page</a>
            </div>
        </div>
    </div>
</body>
</html>
