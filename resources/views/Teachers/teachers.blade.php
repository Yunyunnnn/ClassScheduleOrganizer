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
                    <form id="logout-form" method="POST" action="{{ route('teacher.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto py-10">
        @if(session('approval_message_dismissed', false) == false && isset($approved) && $approved)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" id="approvalMessage">
                Your account is approved.
                <button onclick="dismissApprovalMessage()" class="absolute top-0 bottom-0 right-0 px-4 py-3">X</button>
            </div>
        @endif

        @if(isset($approved) && !$approved)
            <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 z-50">
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                    Your account is not yet verified by the admin. Please wait for approval.
                    <form method="POST" action="{{ route('teacher.logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded mt-6">Logout</button>
                    </form>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <script>
        document.querySelector('nav button').addEventListener('click', function() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        });

        function dismissApprovalMessage() {
            document.getElementById('approvalMessage').remove();
            fetch('{{ route("teacher.dismissApprovalMessage") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        }
    </script>
</body>
</html>
