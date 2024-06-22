@extends('Students.home')

@section('title', 'Subject Dashboard')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">My Subjects</h1>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                <div>{{ session('success') }}</div>
                <button type="button" class="text-white hover:text-gray-200" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                <div>{{ session('warning') }}</div>
                <button type="button" class="text-white hover:text-gray-200" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                <div>{{ session('error') }}</div>
                <button type="button" class="text-white hover:text-gray-200" onclick="this.parentElement.style.display='none'">&times;</button>
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

                        <p class="text-gray-600 mb-4">{{ $subject->description }}</p>

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
@endsection
