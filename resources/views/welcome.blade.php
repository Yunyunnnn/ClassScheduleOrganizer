<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADFC Class Schedule Organizer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Q0m7FSCsO89b2K07NkF+6HeL2RrUQh2bUe7ET52W7OvGWnmd5GQ06dVt+NkYt4jIv7oyjNqBdXrE5TKrNjnC8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Optional: Custom CSS for additional styling */
        .btn-link {
            transition: all 0.3s ease;
        }
        .btn-link:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-20 flex flex-col items-center">
        <h1 class="text-5xl font-bold mb-10 text-center text-gray-800">
            ADFC Class Schedule Organizer
        </h1>
        <div class="space-y-4">
            <a href="{{ route('student.login') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-md font-semibold flex items-center justify-center btn-link">
                <i class="fas fa-user-graduate mr-2"></i> Student Login
            </a>
            <a href="{{ route('student.register') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-md font-semibold flex items-center justify-center btn-link">
                <i class="fas fa-user-plus mr-2"></i> Student Registration
            </a>
            <a href="{{ route('teacher.login') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-md font-semibold flex items-center justify-center btn-link">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Teacher Login
            </a>
            <a href="{{ route('teacher.register') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-md font-semibold flex items-center justify-center btn-link">
                <i class="fas fa-user-tie mr-2"></i> Teacher Registration
            </a>
            <a href="{{ route('admin.login') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-md font-semibold flex items-center justify-center btn-link">
                <i class="fas fa-user-shield mr-2"></i> Admin Login
            </a>
        </div>
    </div>
</body>
</html>
