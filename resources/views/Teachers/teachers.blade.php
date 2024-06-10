<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('teacher.home') }}" class="text-white text-lg font-bold">Teacher Dashboard</a>
            <div class="relative">
                <button class="text-white focus:outline-none">
                    Menu
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden" id="dropdownMenu">
                    <a href="{{ route('teacher.home') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">Dashboard</a>
                    <a href="{{ route('teacher.subjects.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">Subjects</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto py-10">
        @yield('content')
    </div>

    <script>
        document.querySelector('nav button').addEventListener('click', function() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
