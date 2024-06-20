<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Subject Search')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }

        function closeAlert() {
            localStorage.setItem('approvedMessageDismissed', 'true');
            document.getElementById('approvalMessage').remove();
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (localStorage.getItem('approvedMessageDismissed') === 'true') {
                const approvalMessage = document.getElementById('approvalMessage');
                if (approvalMessage) {
                    approvalMessage.style.display = 'none';
                }
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

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold">Student Portal</h1>
                    </div>
                </div>
                <div class="sm:ml-6 relative">
                    <div>
                        <button id="dropdownButton" type="button" onclick="toggleDropdown()"
                            class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-gray-500">
                            <span class="text-lg font-semibold">{{ auth()->user()->first_name }}</span>
                            <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 0 1 1.414 0L10 10.586l3.293-3.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 0-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div id="dropdown"
                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <div class="block px-4 py-2 text-sm text-gray-700">
                                <div class="text-xl text-gray-500">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                                <div class="text-xs text-gray-500">Student ID: {{ auth()->user()->student_id }}</div>
                                <div class="text-xs text-gray-500">Block: {{ auth()->user()->block }}</div>
                            </div>
                            <a href="{{ route('student.subject.search') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem">Subject Search</a>
                            <a href="{{ route('student.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="menuitem">Dashboard</a>
                            <form method="POST" action="{{ route('student.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Subject Search Content -->
    <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Subject Search</h1>
        <!-- Your subject search content goes here -->
        <form action="{{ route('student.subject.search.results') }}" method="GET">
            <div class="mb-4">
                <label for="subjectCode" class="block text-sm font-medium text-gray-700">Subject Code</label>
                <input type="text" name="subjectCode" id="subjectCode"
                       class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="subjectName" class="block text-sm font-medium text-gray-700">Subject Name</label>
                <input type="text" name="subjectName" id="subjectName"
                       class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md">Search</button>
        </form>
        <!-- Search results will be displayed here -->
        @if(isset($subjects))
            <div class="mt-6">
                <h2 class="text-2xl font-semibold mb-4">Search Results</h2>
                <ul>
                    @forelse($subjects as $subject)
                        <li class="mb-2">
                            <div class="p-4 bg-white shadow rounded-lg">
                                <h3 class="text-lg font-bold">{{ $subject->subject_name }} ({{ $subject->subject_code }})</h3>
                                <p>{{ $subject->description }}</p>
                            </div>
                        </li>
                    @empty
                        <li>No subjects found</li>
                    @endforelse
                </ul>
            </div>
        @endif
    </div>

</body>

</html>
