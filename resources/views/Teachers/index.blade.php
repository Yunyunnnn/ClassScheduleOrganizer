@extends('Teachers.teachers')

@section('title', 'Student Enrollments')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Student Enrollments</h1>

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

        @foreach($subjects as $subject)
        <div class="bg-white shadow-lg rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">{{ $subject->name }}</h2>
                <p class="text-gray-600 mb-4">{{ $subject->subject_code }}</p>
                <div class="border-t pt-4">
                    <h3 class="text-xl font-semibold mb-2">Enrolling Students:</h3>
                    <ul>
                        @forelse($subject->students as $student)
                            <li class="mb-3 flex justify-between items-center">
                                <span class="font-semibold">{{ $student->first_name }} {{ $student->last_name }}</span> - Year: {{ $student->pivot->year_level }} - Block: {{ $student->pivot->block_number }}
                                <form action="{{ route('teacher.students.approve', ['subject' => $subject->subject_code, 'student' => $student->student_id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded ml-2">Approve</button>
                                </form>

                                <form action="{{ route('teacher.students.reject', ['subject' => $subject->subject_code, 'student' => $student->student_id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Reject</button>
                                </form>
                            </li>
                        @empty
                            <li class="text-gray-700">No enrollment applications yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    @endforeach


    </div>
@endsection
