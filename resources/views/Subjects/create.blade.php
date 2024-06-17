@extends('Teachers/teachers')

@section('title', 'Add Subject')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Add Subject</h1>

    @if(session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6">
            {{ session('warning') }}
        </div>
    @endif

    <form action="{{ route('teacher.subjects.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Subject Name</label>
            <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="code" class="block text-gray-700">Subject Code</label>
            <input type="text" name="code" id="code" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="time_from" class="block text-gray-700">Time From</label>
            <input type="time" name="time_from" id="time_from" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="time_to" class="block text-gray-700">Time To</label>
            <input type="time" name="time_to" id="time_to" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Days of the Week</label>
            <div class="flex flex-wrap">
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <div class="mr-4 mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="days_of_week[]" value="{{ $day }}" class="form-checkbox">
                            <span class="ml-2">{{ $day }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <label for="students" class="block text-gray-700">Add Students (optional)</label>
            <div id="students">
                <div class="flex mb-2">
                    <input type="text" name="student_first_names[]" placeholder="First Name" class="w-1/2 px-4 py-2 border rounded mr-2">
                    <input type="text" name="student_last_names[]" placeholder="Last Name" class="w-1/2 px-4 py-2 border rounded">
                </div>
            </div>
            <button type="button" id="add-student" class="bg-blue-500 text-white px-4 py-2 rounded">Add Another Student</button>
        </div>
        <div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create Subject</button>
        </div>
    </form>

    <script>
        document.getElementById('add-student').addEventListener('click', function () {
            const studentDiv = document.createElement('div');
            studentDiv.className = 'flex mb-2';
            studentDiv.innerHTML = `
                <input type="text" name="student_first_names[]" placeholder="First Name" class="w-1/2 px-4 py-2 border rounded mr-2">
                <input type="text" name="student_last_names[]" placeholder="Last Name" class="w-1/2 px-4 py-2 border rounded">
            `;
            document.getElementById('students').appendChild(studentDiv);
        });
    </script>
@endsection
