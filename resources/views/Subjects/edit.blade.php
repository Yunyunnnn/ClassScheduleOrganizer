@extends('Teachers/teachers')

@section('title', 'Edit Subject')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Subject</h1>

    <form action="{{ route('teacher.subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Subject Name</label>
            <input type="text" name="name" id="name" value="{{ $subject->name }}" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="code" class="block text-gray-700">Subject Code</label>
            <input type="text" name="code" id="code" value="{{ $subject->subject_code }}" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="time_from" class="block text-gray-700">Time From</label>
            <input type="time" name="time_from" id="time_from" value="{{ $subject->time_from }}" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="time_to" class="block text-gray-700">Time To</label>
            <input type="time" name="time_to" id="time_to" value="{{ $subject->time_to }}" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Days of the Week</label>
            <div class="flex flex-wrap">
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <div class="mr-4 mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="days_of_week[]" value="{{ $day }}" class="form-checkbox"
                                   @if(in_array($day, explode(',', $subject->days_of_week))) checked @endif>
                            <span class="ml-2">{{ $day }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <label for="room" class="block text-gray-700">Room</label>
            <input type="text" name="room" id="room" value="{{ $subject->room }}" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="flex items-center">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mr-4">Update Subject</button>
            <a href="{{ route('teacher.subjects.list') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
        </div>
    </form>
@endsection
