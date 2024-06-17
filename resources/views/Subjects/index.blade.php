@extends('Teachers/teachers')

@section('title', 'Subjects')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Subjects</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('teacher.subjects.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Subject</a>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Code</th>
                <th class="py-2 px-4 border-b">Time From</th>
                <th class="py-2 px-4 border-b">Time To</th>
                <th class="py-2 px-4 border-b">Days of the Week</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $subject->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $subject->subject_code }}</td>
                    <td class="py-2 px-4 border-b">{{ $subject->time_from }}</td>
                    <td class="py-2 px-4 border-b">{{ $subject->time_to }}</td>
                    <td class="py-2 px-4 border-b">{{ $subject->days_of_week }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('teacher.subjects.edit', $subject) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                        <a href="{{ route('teacher.subjects.students', $subject) }}" class="bg-blue-500 text-white px-4 py-2 rounded">View Students</a>
                        <form action="{{ route('teacher.subjects.destroy', $subject) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
