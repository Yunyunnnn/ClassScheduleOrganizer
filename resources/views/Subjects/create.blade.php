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

        <form action="{{ route('teacher.subjects.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <!-- Subject Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Subject Name</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" placeholder="Enter subject name" value="{{ old('name') }}" required>
            </div>

            <!-- Subject Code -->
            <div class="mb-4">
                <label for="subject_code" class="block text-gray-700 text-sm font-bold mb-2">Subject Code</label>
                <input type="text" name="subject_code" id="subject_code" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" placeholder="Enter subject code" value="{{ old('subject_code') }}" required>
            </div>

            <!-- Schedules Section -->
            <div id="schedules-container">
                <div class="schedule mb-6 border p-4 rounded-lg shadow-md" id="schedule_1">
                    <h2 class="text-xl font-bold mb-4">Schedule 1</h2>

                    <!-- Block Number -->
                    <div class="mb-4">
                        <label for="block_number_1" class="block text-gray-700 text-sm font-bold mb-2">Block Number</label>
                        <input type="text" name="schedules[1][block_number]" id="block_number_1" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" placeholder="Enter block number" value="{{ old('schedules.1.block_number') }}" required maxlength="1">
                    </div>

                    <!-- Year Level -->
                    <div class="mb-4">
                        <label for="year_level_1" class="block text-gray-700 text-sm font-bold mb-2">Year Level</label>
                        <select name="schedules[1][year_level]" id="year_level_1" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" required>
                            <option value="1" {{ old('schedules.1.year_level') == 1 ? 'selected' : '' }}>1st Year</option>
                            <option value="2" {{ old('schedules.1.year_level') == 2 ? 'selected' : '' }}>2nd Year</option>
                            <option value="3" {{ old('schedules.1.year_level') == 3 ? 'selected' : '' }}>3rd Year</option>
                            <option value="4" {{ old('schedules.1.year_level') == 4 ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>

                    <!-- Course -->
                    <div class="mb-4">
                        <label for="course_1" class="block text-gray-700 text-sm font-bold mb-2">Course</label>
                        <input type="text" name="schedules[1][course]" id="course_1" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline capitalize" placeholder="Enter course" value="{{ old('schedules.1.course') }}" required>
                    </div>

                    <!-- Time From -->
                    <div class="mb-4">
                        <label for="time_from_1" class="block text-gray-700 text-sm font-bold mb-2">Time From</label>
                        <input type="time" name="schedules[1][time_from]" id="time_from_1" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" value="{{ old('schedules.1.time_from') }}" required>
                    </div>

                    <!-- Time To -->
                    <div class="mb-4">
                        <label for="time_to_1" class="block text-gray-700 text-sm font-bold mb-2">Time To</label>
                        <input type="time" name="schedules[1][time_to]" id="time_to_1" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" value="{{ old('schedules.1.time_to') }}" required>
                    </div>

                    <!-- Days of the Week -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Days of the Week</label>
                        <div class="flex flex-wrap">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="mr-4 mb-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="schedules[1][days_of_week][]" value="{{ $day }}" class="form-checkbox">
                                        <span class="ml-2">{{ $day }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Room -->
                    <div class="mb-4">
                        <label for="room_1" class="block text-gray-700 text-sm font-bold mb-2">Room</label>
                        <input type="text" name="schedules[1][room]" id="room_1" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" placeholder="Enter room" value="{{ old('schedules.1.room') }}" required>
                    </div>
                </div>
            </div>

            <!-- Add Schedule Button -->
            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600 transition duration-200" onclick="addSchedule()">Add Another Schedule</button>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">Create Subject</button>
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

                    <!-- Block Number -->
                    <div class="mb-4">
                        <label for="block_number_${scheduleCount}" class="block text-gray-700 text-sm font-bold mb-2">Block Number</label>
                        <input type="text" name="schedules[${scheduleCount}][block_number]" id="block_number_${scheduleCount}" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" placeholder="Enter block number" required maxlength="1">
                    </div>

                    <!-- Year Level -->
                    <div class="mb-4">
                        <label for="year_level_${scheduleCount}" class="block text-gray-700 text-sm font-bold mb-2">Year Level</label>
                        <select name="schedules[${scheduleCount}][year_level]" id="year_level_${scheduleCount}" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" required>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>

                    <!-- Course -->
                    <div class="mb-4">
                        <label for="course_${scheduleCount}" class="block text-gray-700 text-sm font-bold mb-2">Course</label>
                        <input type="text" name="schedules[${scheduleCount}][course]" id="course_${scheduleCount}" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline capitalize" placeholder="Enter course" required>
                    </div>

                    <!-- Time From -->
                    <div
                    class="mb-4">
                        <label for="time_from_${scheduleCount}" class="block text-gray-700 text-sm font-bold mb-2">Time From</label>
                        <input type="time" name="schedules[${scheduleCount}][time_from]" id="time_from_${scheduleCount}" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" required>
                    </div>

                    <!-- Time To -->
                    <div class="mb-4">
                        <label for="time_to_${scheduleCount}" class="block text-gray-700 text-sm font-bold mb-2">Time To</label>
                        <input type="time" name="schedules[${scheduleCount}][time_to]" id="time_to_${scheduleCount}" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" required>
                    </div>

                    <!-- Days of the Week -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Days of the Week</label>
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

                    <!-- Room -->
                    <div class="mb-4">
                        <label for="room_${scheduleCount}" class="block text-gray-700 text-sm font-bold mb-2">Room</label>
                        <input type="text" name="schedules[${scheduleCount}][room]" id="room_${scheduleCount}" class="w-full px-3 py-2 border rounded focus:outline-none focus:shadow-outline" placeholder="Enter room" required>
                    </div>

                    <!-- Remove Schedule Button -->
                    <button type="button" class="text-sm text-red-500 hover:text-red-700 focus:outline-none focus:text-red-700" onclick="removeSchedule(${scheduleCount})">Remove</button>
                </div>
            `;

            const container = document.getElementById('schedules-container');
            const scheduleElement = document.createElement('div');
            scheduleElement.classList.add('animate__animated', 'animate__fadeInUp', 'duration-500', 'transform', 'hover:shadow-lg', 'hover:-translate-y-2', 'transition', 'ease-in-out');
            scheduleElement.innerHTML = scheduleTemplate.trim();
            container.appendChild(scheduleElement);

            // Reset the checkbox states when adding a new schedule
            const checkboxes = container.querySelectorAll(`#schedule_${scheduleCount} input[type="checkbox"]`);
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        function removeSchedule(scheduleId) {
            const schedule = document.getElementById(`schedule_${scheduleId}`);
            schedule.classList.add('animate__animated', 'animate__fadeOutDown', 'duration-500', 'transform', 'transition', 'ease-in-out');

            setTimeout(() => {
                schedule.remove();
            }, 500);
        }

        // Automatically capitalize input text for course fields
        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('capitalize')) {
                event.target.value = event.target.value.toUpperCase();
            }
        });

    </script>
@endsection
