@extends('Teachers.teacher')

@section('title', 'Student Management')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Student Management</h1>

    @foreach($subjects as $subject)
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-4">{{ $subject->name }}</h2>

            <ul>
                @forelse($subject->students as $student)
                    <li>
                        {{ $student->first_name }} {{ $student->last_name }} - {{ $student->year_level }}
                        @if (!$student->pivot->approved)
                            <form action="{{ route('teacher.students.approve', ['subject' => $subject->id, 'student' => $student->id]) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded">Approve</button>
                            </form>
                            <form action="{{ route('teacher.students.reject', ['subject' => $subject->id, 'student' => $student->id]) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded">Reject</button>
                            </form>
                        @endif
                    </li>
                @empty
                    <li>No students enrolled yet.</li>
                @endforelse
            </ul>
        </div>
    @endforeach
@endsection
