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

                        <div class="flex items-center mb-4">
                            <span class="text-lg font-semibold text-gray-800">Days:</span>
                            <div class="ml-2 flex flex-wrap">
                                @foreach (explode(',', $subject->days_of_week) as $day)
                                    <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $day }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center mb-4">
                            <span class="text-lg font-semibold text-gray-800">Time:</span>
                            <span class="ml-2 text-lg text-gray-700">{{ date('h:i A', strtotime($subject->time_from)) }} until {{ date('h:i A', strtotime($subject->time_to)) }}</span>
                        </div>

                        <div class="flex items-center mb-4">
                            <span class="text-lg font-semibold text-gray-800">Room:</span>
                            <span class="ml-2 text-lg text-gray-700">{{ $subject->room }}</span>
                        </div>

                        <p class="text-gray-600 mb-4">{{ $subject->description }}</p>

                        @if ($subject->student && $subject->student->pivot->approved === 1)
                            @php
                                $sessionKey = 'enrollment_approved_' . $subject->subject_code;
                            @endphp
                            @if (!session()->has($sessionKey) && !session('closed_' . $sessionKey))
                                <div class="bg-green-200 text-green-800 px-4 py-2 rounded-md mt-4">
                                    Enrollment Approved
                                    <button type="button" class="text-green-600 hover:text-green-900 ml-2" onclick="closeNotification(this, '{{ $sessionKey }}')">&times;</button>
                                </div>
                                @php
                                    session()->put($sessionKey, true);
                                @endphp
                            @endif
                            <form action="{{ route('student.subject.leave') }}" method="POST">
                                @csrf
                                <input type="hidden" name="subject_code" value="{{ $subject->subject_code }}">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded mt-4">Leave Subject</button>
                            </form>
                        @elseif ($subject->student && $subject->student->pivot->approved === 0)
                            <div class="bg-yellow-200 text-yellow-800 px-4 py-2 rounded-md mt-4">
                                Awaiting Approval
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        function closeNotification(element, sessionKey) {
            element.parentElement.style.display = 'none';
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "/close-notification", true);
            xhr.send();
            sessionStorage.setItem('closed_' + sessionKey, true);
        }
    </script>
@endsection
