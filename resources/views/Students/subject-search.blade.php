@extends('Students.home')

@section('title', 'Subject Search')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Subject Search</h1>

        <!-- Subject search form -->
        <form action="{{ route('student.subject.search.results') }}" method="GET" class="bg-white shadow-md rounded-lg p-6 mb-8">
            <div class="mb-4">
                <label for="subjectId" class="block text-sm font-medium text-gray-700">Subject ID</label>
                <input type="text" name="subjectId" id="subjectId"
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                @error('subjectId')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 py-2 rounded-md transition duration-300">Search</button>
        </form>

        <!-- Display flash messages -->
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

        <!-- Display search results -->
        @if (isset($subjects) && $subjects->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Search Results</h2>
                <ul>
                    @foreach ($subjects as $subject)
                        <li class="mb-6">
                            <div class="p-6 bg-white shadow-lg rounded-lg">
                                <h3 class="text-lg font-bold text-gray-800 mb-2">Subject Name:</h3>
                                <p class="text-lg text-gray-700 pb-4">{{ $subject->name }}</p>

                                <h3 class="text-lg font-bold text-gray-800 mb-2">Subject Code:</h3>
                                <p class="text-lg text-gray-700 pb-4">{{ $subject->subject_code }}</p>

                                <h3 class="text-lg font-bold text-gray-800 mb-2">Teacher:</h3>
                                <p class="text-lg text-gray-700 pb-4">{{ $subject->teacher->first_name }} {{ $subject->teacher->last_name }}</p>

                                <h3 class="text-lg font-bold text-gray-800 mb-2">Days:</h3>
                                <div class="flex flex-wrap pb-4">
                                    @foreach (explode(',', $subject->days_of_week) as $day)
                                        <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">{{ $day }}</span>
                                    @endforeach
                                </div>

                                <h3 class="text-lg font-bold text-gray-800 mb-2">Time:</h3>
                                <p class="text-lg text-gray-700 pb-4">{{ date('h:i A', strtotime($subject->time_from)) }} until {{ date('h:i A', strtotime($subject->time_to)) }}</p>

                                <p class="text-gray-600">{{ $subject->description }}</p>

                                @if ($subject->isEnrolledByUser(auth()->user()))
                                    @if ($subject->isEnrollmentApproved(auth()->user()))
                                        <div class="bg-green-200 text-green-800 px-4 py-2 rounded-md mt-4">
                                            Enrolled and Approved
                                        </div>
                                    @else
                                        <div class="bg-yellow-200 text-yellow-800 px-4 py-2 rounded-md mt-4">
                                            Awaiting Approval
                                        </div>
                                    @endif
                                @else
                                    <form action="{{ route('student.subject.enroll') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="subject_code" value="{{ $subject->subject_code }}">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-4 py-2 rounded mt-4">Enroll</button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="text-gray-700">No subjects found</p>
        @endif
    </div>
@endsection
