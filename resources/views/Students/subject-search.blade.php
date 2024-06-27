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

                                <h3 class="text-lg font-bold text-gray-800 mb-2">Schedules:</h3>
                                <ul>
                                    @foreach ($subject->schedules as $schedule)
                                        <li class="mb-4">
                                            <div class="p-4 bg-gray-100 shadow-md rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <h4 class="text-lg font-bold text-gray-800">Block: {{ $schedule->block_number }}</h4>
                                                    <div>
                                                        <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded"> {{ $schedule->course }}</span>
                                                        <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded"> {{ $schedule->year_level }}</span>
                                                        <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">{{ implode(', ', explode(',', $schedule->days_of_week)) }}</span>
                                                    </div>
                                                </div>
                                                <p class="text-lg text-gray-700 mt-2">
                                                    Time: {{ date('h:i A', strtotime($schedule->time_from)) }} - {{ date('h:i A', strtotime($schedule->time_to)) }}
                                                </p>
                                                <p class="text-lg text-gray-700 mt-2">
                                                    Room: {{ $schedule->room }}
                                                </p>
                                                <form action="{{ route('student.subject.enroll') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="subject_code" value="{{ $subject->subject_code }}">
                                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-4 py-2 rounded mt-4">Enroll</button>
                                                </form>
                                                @if ($errors->has('enrollment_error'))
                                                    <span class="text-red-500 text-sm">{{ $errors->first('enrollment_error') }}</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
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
