<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Home')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }

        function closeApprovalMessage() {
            localStorage.setItem('approvedMessageDismissed', 'true');
            document.getElementById('approvalMessage').remove();
        }

        document.addEventListener('DOMContentLoaded', function () {
            const userApproved = @json(auth()->user()->approved);
            if (userApproved) {
                if (!localStorage.getItem('approvedMessageDismissed')) {
                    document.getElementById('approvalMessage').classList.remove('hidden');
                }
            } else {
                document.getElementById('notApprovedMessage').classList.remove('hidden');
            }
        });

        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('dropdown');
            if (!event.target.closest('#dropdown') && !event.target.closest('#dropdownButton')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-gradient-to-r from-blue-500 to-indigo-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-white">Student Portal</h1>
                    </div>
                </div>
                <div class="sm:ml-6 relative">
                    <div>
                        @auth
                            <button id="dropdownButton" type="button" onclick="toggleDropdown()"
                                class="flex items-center text-white hover:text-gray-200 ">
                                <span class="text-lg font-semibold">Menu</span>
                            </button>
                            <div id="dropdown"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                                <div class="py-1" role="menu" aria-orientation="vertical"
                                    aria-labelledby="options-menu">
                                    <div class="block px-4 py-2 text-sm text-gray-700">
                                        <div class="text-lg text-gray-500">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                        <div class="text-xs text-gray-500">Student ID: {{ auth()->user()->student_id }}</div>
                                        <div class="text-xs text-gray-500">Block: {{ auth()->user()->block_number }}</div>
                                        <div class="text-xs text-gray-500">Year: {{ auth()->user()->year_level }}</div>
                                        <div class="text-xs text-gray-500">Course: {{ auth()->user()->course }}</div>
                                    </div>
                                    <a href="{{ route('student.home') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Dashboard</a>
                                    <a href="{{ route('student.subject.search') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Subject Search</a>
                                    <form method="POST" action="{{ route('student.logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </div>

    @auth
        @if (!auth()->user()->approved)
            <div id="notApprovedMessage" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white p-8 rounded-lg shadow-md max-w-sm w-full text-center">
                    <h2 class="text-2xl font-bold mb-4 text-red-500">Account Not Approved</h2>
                    <p class="text-gray-700 mb-4">Your account is pending approval. You cannot access the system until approved by the admin.</p>
                    <form method="POST" action="{{ route('student.logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                    </form>
                </div>
            </div>
        @else
            <div id="approvalMessage" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white p-8 rounded-lg shadow-md max-w-sm w-full text-center">
                    <h2 class="text-2xl font-bold mb-4 text-green-500">Account Approved</h2>
                    <p class="text-gray-700 mb-4">Your account has been approved. You can now fully access the system.</p>
                    <button onclick="closeApprovalMessage()" class="bg-green-500 text-white px-4 py-2 rounded">Close</button>
                </div>
            </div>
        @endif
    @endauth
</body>

</html>
