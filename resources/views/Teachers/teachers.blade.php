<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('teacher.home') }}" class="text-white text-lg font-bold">Teacher Dashboard</a>
            <div class="relative">
                <button id="menuButton" class="text-white focus:outline-none">
                    <i class="fas fa-bars"></i> <!-- FontAwesome icon for Menu -->
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden" id="dropdownMenu">
                    <a href="{{ route('teacher.home') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">
                        <i class="fas fa-home mr-2"></i> <!-- FontAwesome icon for Home -->
                        Dashboard
                    </a>
                    <a href="{{ route('teacher.subjects.list') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">
                        <i class="fas fa-book mr-2"></i> <!-- FontAwesome icon for Subjects -->
                        Subjects
                    </a>
                    <a href="{{ route('teacher.view.students') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">
                        <i class="fas fa-users mr-2"></i> <!-- FontAwesome icon for Manage Students -->
                        Manage Students
                    </a>
                    <a href="{{ route('teacher.student.management') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">
                        <i class="fas fa-user-graduate mr-2"></i> <!-- FontAwesome icon for Students Enrollment -->
                        Enrollment
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('teacher.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">
                            <i class="fas fa-sign-out-alt mr-2"></i> <!-- FontAwesome icon for Logout -->
                            Logout
                        </button>
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
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg relative max-w-lg mx-auto">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M4.293 17.293a1 1 0 011.414 0L12 23.586l6.293-6.293a1 1 0 011.414 0L20.707 19.707a1 1 0 010 1.414L12 30l-8.707-8.707a1 1 0 010-1.414L4.293 17.293zM15 10l-2.5 4H11l-2.5-4H15z"></path></svg>
                        <h2 class="text-2xl font-bold mb-2">Account Not Verified</h2>
                        <p class="mb-4">Your account is not yet verified by the admin. Please wait for approval.</p>
                    </div>
                    <form method="POST" action="{{ route('teacher.logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-md mt-4 hover:bg-red-600">
                            <i class="fas fa-sign-out-alt mr-2"></i> <!-- FontAwesome icon for Logout -->
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <script>
        document.getElementById('menuButton').addEventListener('click', function() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            var isClickInside = document.getElementById('dropdownMenu').contains(event.target) || document.getElementById('menuButton').contains(event.target);
            if (!isClickInside) {
                document.getElementById('dropdownMenu').classList.add('hidden');
            }
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
