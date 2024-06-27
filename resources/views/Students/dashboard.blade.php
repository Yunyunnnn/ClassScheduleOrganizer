@extends('Students.home')

@section('title', 'Student Dashboard')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">My Subjects</h1>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                <div>{{ session('success') }}</div>
                <button type="button" class="text-white hover:text-gray-200" onclick="closeNotification(this)">&times;</button>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                <div>{{ session('warning') }}</div>
                <button type="button" class="text-white hover:text-gray-200" onclick="closeNotification(this)">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                <div>{{ session('error') }}</div>
                <button type="button" class="text-white hover:text-gray-200" onclick="closeNotification(this)">&times;</button>
            </div>
        @endif

        @if ($enrolledSubjects->isEmpty())
            <p class="text-gray-700">You are not enrolled in any subjects yet.</p>
        @else
            @foreach ($enrolledSubjects as $subject)
                <div class="bg-white shadow-lg rounded-lg mb-6">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-4">{{ $subject->name }}</h2>

                        <div class="flex items-center mb-4">
                            <span class="text-lg font-semibold text-gray-800">Teacher:</span>
                            <span class="ml-2 text-lg text-gray-700">{{ $subject->teacher->first_name }} {{ $subject->teacher->last_name }}</span>
                        </div>

                        <div class="mb-4">
                            <ul>
                                @foreach ($subject->schedules as $schedule)
                                    <li class="mb-2">
                                        <div class="flex items-center mb-2">
                                            <span class="text-sm font-medium text-gray-800">Block:</span>
                                            <span class="ml-2 text-sm text-gray-700">{{ $schedule->block_number }}</span>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <span class="text-sm font-medium text-gray-800">Course:</span>
                                            <span class="ml-2 text-sm text-gray-700">{{ $schedule->course }}</span>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <span class="text-sm font-medium text-gray-800">Year Level:</span>
                                            <span class="ml-2 text-sm text-gray-700">{{ $schedule->year_level }}</span>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <span class="text-sm font-medium text-gray-800">Days:</span>
                                            <span class="ml-2 text-sm text-gray-700">{{ implode(', ', explode(',', $schedule->days_of_week)) }}</span>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <span class="text-sm font-medium text-gray-800">Time:</span>
                                            <span class="ml-2 text-sm text-gray-700">{{ date('h:i A', strtotime($schedule->time_from)) }} - {{ date('h:i A', strtotime($schedule->time_to)) }}</span>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <span class="text-sm font-medium text-gray-800">Room:</span>
                                            <span class="ml-2 text-sm text-gray-700">{{ $schedule->room }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <form action="{{ route('student.subject.leave') }}" method="POST">
                            @csrf
                            <input type="hidden" name="subject_code" value="{{ $subject->subject_code }}">
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded mt-4">Leave Subject</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        function closeNotification(element) {
            element.parentElement.style.display = 'none';
        }
    </script>
@endsection
