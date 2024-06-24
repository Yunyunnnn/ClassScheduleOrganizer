@extends('Teachers.teachers')

@section('title', 'Add Subject')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Add Subject</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('teacher.subjects.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Subject Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded" value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label for="subject_code" class="block text-gray-700">Subject Code</label>
                <input type="text" name="subject_code" id="subject_code" class="w-full px-4 py-2 border rounded" value="{{ old('subject_code') }}" required>
            </div>

            <div id="schedules-container">
                <div class="schedule mb-6 border p-4 rounded-lg shadow-md" id="schedule_1">
                    <h2 class="text-xl font-bold mb-4">Schedule 1</h2>

                    <div class="mb-4">
                        <label for="block_number_1" class="block text-gray-700">Block Number</label>
                        <input type="text" name="schedules[1][block_number]" id="block_number_1" class="w-full px-4 py-2 border rounded" value="{{ old('schedules.1.block_number') }}" required maxlength="1">
                    </div>

                    <div class="mb-4">
                        <label for="year_level_1" class="block text-gray-700">Year Level</label>
                        <select name="schedules[1][year_level]" id="year_level_1" class="w-full px-4 py-2 border rounded" required>
                            <option value="1" {{ old('schedules.1.year_level') == 1 ? 'selected' : '' }}>1st Year</option>
                            <option value="2" {{ old('schedules.1.year_level') == 2 ? 'selected' : '' }}>2nd Year</option>
                            <option value="3" {{ old('schedules.1.year_level') == 3 ? 'selected' : '' }}>3rd Year</option>
                            <option value="4" {{ old('schedules.1.year_level') == 4 ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="course_1" class="block text-gray-700">Course</label>
                        <input type="text" name="schedules[1][course]" id="course_1" class="w-full px-4 py-2 border rounded capitalize" value="{{ old('schedules.1.course') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="time_from_1" class="block text-gray-700">Time From</label>
                        <input type="time" name="schedules[1][time_from]" id="time_from_1" class="w-full px-4 py-2 border rounded" value="{{ old('schedules.1.time_from') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="time_to_1" class="block text-gray-700">Time To</label>
                        <input type="time" name="schedules[1][time_to]" id="time_to_1" class="w-full px-4 py-2 border rounded" value="{{ old('schedules.1.time_to') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Days of the Week</label>
                        <div class="flex flex-wrap">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="mr-4 mb-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="schedules[1][days_of_week][]" value="{{ $day }}" class="form-checkbox"
                                               {{ is_array(old('schedules.1.days_of_week')) && in_array($day, old('schedules.1.days_of_week')) ? 'checked' : '' }}>
                                        <span class="ml-2">{{ $day }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="room_1" class="block text-gray-700">Room</label>
                        <input type="text" name="schedules[1][room]" id="room_1" class="w-full px-4 py-2 border rounded" value="{{ old('schedules.1.room') }}" required>
                    </div>
                </div>
            </div>

            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded mb-4" onclick="addSchedule()">Add Another Schedule</button>

            <div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create Subject</button>
            </div>
        </form>
    </div>

    <script>
        let scheduleCount = 1;

        function addSchedule() {
            scheduleCount++;
            const scheduleTemplate = `
                <div class="schedule mb-6 border p-4 rounded-lg shadow-md" id="schedule_${scheduleCount}">
                    <h2 class="text-xl font-bold mb-4">Schedule ${scheduleCount}</h2>

                    <div class="mb-4">
                        <label for="block_number_${scheduleCount}" class="block text-gray-700">Block Number</label>
                        <input type="text" name="schedules[${scheduleCount}][block_number]" id="block_number_${scheduleCount}" class="w-full px-4 py-2 border rounded" required maxlength="1">
                    </div>

                    <div class="mb-4">
                        <label for="year_level_${scheduleCount}" class="block text-gray-700">Year Level</label>
                        <select name="schedules[${scheduleCount}][year_level]" id="year_level_${scheduleCount}" class="w-full px-4 py-2 border rounded" required>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="course_${scheduleCount}" class="block text-gray-700">Course</label>
                        <input type="text" name="schedules[${scheduleCount}][course]" id="course_${scheduleCount}" class="w-full px-4 py-2 border rounded capitalize" required>
                    </div>

                    <div class="mb-4">
                        <label for="time_from_${scheduleCount}" class="block text-gray-700">Time From</label>
                        <input type="time" name="schedules[${scheduleCount}][time_from]" id="time_from_${scheduleCount}" class="w-full px-4 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label for="time_to_${scheduleCount}" class="block text-gray-700">Time To</label>
                        <input type="time" name="schedules[${scheduleCount}][time_to]" id="time_to_${scheduleCount}" class="w-full px-4 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Days of the Week</label>
                        <div class="flex flex-wrap">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="mr-4 mb-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="schedules[${scheduleCount}][days_of_week][]" value="{{ $day }}" class="form-checkbox">
                                        <span class="ml-2">{{ $day }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="room_${scheduleCount}" class="block text-gray-700">Room</label>
                        <input type="text" name="schedules[${scheduleCount}][room]" id="room_${scheduleCount}" class="w-full px-4 py-2 border rounded" required>
                    </div>
                </div>
            `;

            const container = document.getElementById('schedules-container');
            const scheduleElement = document.createElement('div');
            scheduleElement.innerHTML = scheduleTemplate.trim();
            container.appendChild(scheduleElement.firstChild);
        }

        // Automatically capitalize input text for course fields
        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('capitalize')) {
                event.target.value = event.target.value.toUpperCase();
            }
        });

    </script>
@endsection

