@extends('Teachers/teachers')

@section('title', 'Students Enrolled in ' . $subject->name)

@section('content')
    <h1 class="text-3xl font-bold mb-6">Students Enrolled in {{ $subject->name }}</h1>

    <a href="{{ route('teacher.subjects.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Back to Subjects</a>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">First Name</th>
                <th class="py-2 px-4 border-b">Last Name</th>
                <th class="py-2 px-4 border-b">Student ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $student->first_name }}</td>
                    <td class="py-2 px-4 border-b">{{ $student->last_name }}</td>
                    <td class="py-2 px-4 border-b">{{ $student->student_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
