@extends('Teachers.teachers')

@section('title', 'View Students')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">View Students</h1>

    <!-- List of Subjects -->
    <div class="mb-6 space-y-2">
        <h2 class="text-xl font-bold mb-2">Subjects</h2>
        <div class="flex flex-wrap">
            @foreach($subjects as $subject)
            <a href="{{ route('teacher.view.students', ['subject' => $subject->subject_code]) }}"
                class="subject-box inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-full mr-3 mb-3 transition duration-300 ease-in-out hover:bg-blue-500 hover:text-white">
                {{ $subject->name }} - {{ $subject->subject_code }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Selected Subject Section -->
    @if ($selectedSubject)
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Students Enrolled in {{ $selectedSubject->name }}</h2>

        <!-- Filter Form -->
        <form action="{{ route('teacher.view.students', ['subject' => $selectedSubject->subject_code]) }}" method="GET" class="mb-4">
            <div class="flex space-x-4">
                <div>
                    <label for="block_number" class="block text-sm font-medium text-gray-700">Block Number:</label>
                    <input type="text" name="block_number" id="block_number" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500" value="{{ old('block_number', request()->input('block_number')) }}" placeholder="Enter block number">
                </div>
                <div>
                    <label for="course" class="block text-sm font-medium text-gray-700">Course:</label>
                    <input type="text" name="course" id="course" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500 uppercase" value="{{ old('course', strtoupper(request()->input('course'))) }}" placeholder="Enter course" maxlength="10">
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Year:</label>
                    <select name="year" id="year" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500">
                        <option value="">Select Year</option>
                        <option value="1st Year" {{ old('year', request()->input('year')) === '1st Year' ? 'selected' : '' }}>1st Year</option>
                        <option value="2nd Year" {{ old('year', request()->input('year')) === '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3rd Year" {{ old('year', request()->input('year')) === '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4th Year" {{ old('year', request()->input('year')) === '4th Year' ? 'selected' : '' }}>4th Year</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mt-auto">Filter</button>
                    <a href="{{ route('teacher.view.students', ['subject' => $selectedSubject->subject_code, 'show_all' => true]) }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md mt-auto">Show All</a>
                </div>
            </div>
        </form>

        <!-- Students Table -->
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow overflow-hidden rounded-lg border border-gray-200">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-blue-500 text-white text-left border-b-2 border-gray-300">First Name</th>
                            <th class="px-6 py-3 bg-blue-500 text-white text-left border-b-2 border-gray-300">Last Name</th>
                            <th class="px-6 py-3 bg-blue-500 text-white text-left border-b-2 border-gray-300">Student ID</th>
                            <th class="px-6 py-3 bg-blue-500 text-white text-left border-b-2 border-gray-300">Email</th>
                            <th class="px-6 py-3 bg-blue-500 text-white text-left border-b-2 border-gray-300">Block</th>
                            <th class="px-6 py-3 bg-blue-500 text-white text-left border-b-2 border-gray-300">Year</th>
                            <th class="px-6 py-3 bg-blue-500 text-white text-left border-b-2 border-gray-300">Course</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enrolledStudents as $student)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->first_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->last_name }}</td>
                            <t- class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->student_id }}</td>
                               <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->email }}</td>
                               <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->block }}</td>
                               <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->year }}</td>
                               <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->course }}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
       @endif

       <!-- Placeholder for No Subject Selected -->
       @if (!$selectedSubject)
       <div class="bg-white shadow-md rounded-lg p-6">
           <p class="text-lg">Select a subject to view students enrolled.</p>
       </div>
       @endif
   </div>

   <style>
       .subject-box {
           transition: background-color 0.3s, color 0.3s;
       }
   </style>

   <script>
       function clearFilters() {
           document.getElementById('block_number').value = '';
           document.getElementById('course').value = '';
           document.getElementById('year').value = '';
       }
   </script>

   @endsection
