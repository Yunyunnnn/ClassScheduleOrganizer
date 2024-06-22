@extends('Teachers/teachers')

@section('title', 'Subjects')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" id="successMessage">
            {{ session('success') }}
            <button onclick="dismissSuccessMessage()" class="absolute top-0 bottom-0 right-0 px-4 py-3">X</button>
        </div>
    @endif

    <h1 class="text-3xl font-bold mb-6">Subjects</h1>

    <a href="{{ route('teacher.subjects.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Subject</a>

    <table class="min-w-full bg-white shadow-md rounded my-6">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-3 px-6 text-left border-b border-gray-300">Name</th>
                <th class="py-3 px-6 text-left border-b border-gray-300">Code</th>
                <th class="py-3 px-6 text-left border-b border-gray-300">Days of the Week</th>
                <th class="py-3 px-6 text-center border-b border-gray-300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr class="hover:bg-gray-100">
                    <td class="py-4 px-6 border-b border-gray-300">{{ $subject->name }}</td>
                    <td class="py-4 px-6 border-b border-gray-300">{{ $subject->subject_code }}</td>
                    <td class="py-4 px-6 border-b border-gray-300">
                        @foreach (explode(',', $subject->days_of_week) as $day)
                            @php
                                $dayAbbreviation = '';
                                switch (trim($day)) {
                                    case 'Monday':
                                        $dayAbbreviation = 'M';
                                        break;
                                    case 'Tuesday':
                                        $dayAbbreviation = 'T';
                                        break;
                                    case 'Wednesday':
                                        $dayAbbreviation = 'W';
                                        break;
                                    case 'Thursday':
                                        $dayAbbreviation = 'Th';
                                        break;
                                    case 'Friday':
                                        $dayAbbreviation = 'F';
                                        break;
                                    case 'Saturday':
                                        $dayAbbreviation = 'S';
                                        break;
                                    case 'Sunday':
                                        $dayAbbreviation = 'Su';
                                        break;
                                    default:
                                        $dayAbbreviation = '';
                                        break;
                                }
                            @endphp
                            <span class="inline-block px-2 py-1 text-xs font-semibold leading-none bg-gray-200 text-gray-800 rounded-full mr-1 mb-1">{{ $dayAbbreviation }}</span>
                        @endforeach
                    </td>
                    <td class="py-4 px-6 text-center border-b border-gray-300">
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('teacher.subjects.edit', $subject) }}" class="text-gray-600 hover:text-gray-900">Edit</a>
                            <form action="{{ route('teacher.subjects.destroy', $subject) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function dismissSuccessMessage() {
            document.getElementById('successMessage').remove();
        }
    </script>

@endsection
