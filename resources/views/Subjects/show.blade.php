@extends('Teachers/teachers')

@section('title', 'Subject Details')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Subject Details</h1>

    <div class="mb-4">
        <h2 class="text-xl font-bold">Subject Information</h2>
        <p><strong>Name:</strong> {{ $subject->name }}</p>
        <p><strong>Code:</strong> {{ $subject->subject_code }}</p>
        <p><strong>Time:</strong> {{ $subject->time_from }} - {{ $subject->time_to }}</p>
        <p><strong>Days:</strong> {{ $subject->days_of_week }}</p>
    </div>

    <div class="mb-4">
        <h2 class="text-xl font-bold">Enrolled Students</h2>
        @if($students->isEmpty())
            <p>No students enrolled in this subject.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">First Name</th>
                        <th class="py-2">Last Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td class="border px-4 py-2">{{ $student->first_name }}</td>
                            <td class="border px-4 py-2">{{ $student->last_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <a href="{{ route('teacher.subjects.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Subjects</a>
@endsection
