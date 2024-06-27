@extends('Teachers/teachers')

@section('title', 'Edit Subject')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Subject</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Validation Error!</strong>
            <ul class="mt-3 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teacher.subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Subject Name</label>
            <input type="text" name="name" id="name" value="{{ $subject->name }}" class="w-full px-4 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="subject_code" class="block text-gray-700">Subject Code</label>
            <input type="text" name="subject_code" id="subject_code" value="{{ $subject->subject_code }}" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div id="schedules-container">
            @foreach ($subject->schedules as $index => $schedule)
                <div class="schedule mb-6 border rounded-lg shadow-md">
                    <div class="schedule-header flex justify-between items-center px-4 py-3 bg-blue-500 text-white cursor-pointer rounded-t-lg">
                        <h2 class="text-xl font-bold">Schedule {{ $index + 1 }}</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                            <path fill-rule="evenodd" d="M12 2a1 1 0 0 1 1 1v16a1 1 0 0 1-2 0V3a1 1 0 0 1 1-1zm-1.293 5.293a1 1 0 1 1 1.414-1.414L12 7.586l1.293-1.293a1 1 0 1 1 1.414 1.414L13.414 9l1.293 1.293a1 1 0 0 1-1.414 1.414L12 10.414l-1.293 1.293a1 1 0 0 1-1.414-1.414L10.586 9 9.293 7.707a1 1 0 0 1 0-1.414z"/>
                        </svg>
                    </div>
                    <div class="schedule-details px-4 py-3 hidden">
                        <input type="hidden" name="schedules[{{ $index + 1 }}][id]" value="{{ $schedule['id'] }}">
                        <div class="mb-4">
                            <label for="block_number_{{ $index + 1 }}" class="block text-gray-700">Block Number</label>
                            <input type="text" name="schedules[{{ $index + 1 }}][block_number]" id="block_number_{{ $index + 1 }}" value="{{ $schedule['block_number'] }}" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="year_level_{{ $index + 1 }}" class="block text-gray-700">Year Level</label>
                            <select name="schedules[{{ $index + 1 }}][year_level]" id="year_level_{{ $index + 1 }}" class="w-full px-4 py-2 border rounded" required>
                                @foreach(range(1, 4) as $year)
                                    <option value="{{ $year }}" {{ $schedule['year_level'] == $year ? 'selected' : '' }}>{{ $year }}th Year</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="course_{{ $index + 1 }}" class="block text-gray-700">Course</label>
                            <input type="text" name="schedules[{{ $index + 1 }}][course]" id="course_{{ $index + 1 }}" value="{{ $schedule['course'] }}" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="time_from_{{ $index + 1 }}" class="block text-gray-700">Time From</label>
                            <input type="time" name="schedules[{{ $index + 1 }}][time_from]" id="time_from_{{ $index + 1 }}" value="{{ $schedule['time_from'] }}" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="time_to_{{ $index + 1 }}" class="block text-gray-700">Time To</label>
                            <input type="time" name="schedules[{{ $index + 1 }}][time_to]" id="time_to_{{ $index + 1 }}" value="{{ $schedule['time_to'] }}" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Days of the Week</label>
                            <div class="flex flex-wrap">
                                @php
                                    $daysOfWeek = is_array($schedule['days_of_week']) ? $schedule['days_of_week'] : explode(',', $schedule['days_of_week']);
                                @endphp
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <div class="mr-4 mb-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="schedules[{{ $index + 1 }}][days_of_week][]" value="{{ $day }}" class="form-checkbox" {{ in_array($day, $daysOfWeek) ? 'checked' : '' }}>
                                            <span class="ml-2">{{ $day }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="room_{{ $index + 1 }}" class="block text-gray-700">Room</label>
                            <input type="text" name="schedules[{{ $index + 1 }}][room]" id="room_{{ $index + 1 }}" value="{{ $schedule['room'] }}" class="w-full px-4 py-2 border rounded" required>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded mb-4" onclick="addSchedule()">Add Another Schedule</button>

        <div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update Subject</button>
            <a href="{{ route('teacher.subjects.list') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleHeaders = document.querySelectorAll('.schedule-header');
            scheduleHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const details = header.nextElementSibling;
                    details.classList.toggle('hidden');
                });
            });
        });

        let scheduleCount = {{ count($subject->schedules) }};

        function addSchedule() {
            scheduleCount++;
            const scheduleTemplate = `
                <div class="schedule mb-6 border rounded-lg shadow-md">
                    <div class="schedule-header flex justify-between items-center px-4 py-3 bg-blue-500 text-white cursor-pointer rounded-t-lg">
                        <h2 class="text-xl font-bold">Schedule ${scheduleCount}</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                            <path fill-rule="evenodd" d="M12 2a1 1 0 0 1 1 1v16a1 1 0 0 1-2 0V3a1 1 0 0 1 1-1zm-1.293 5.293a1 1 0 1 1 1.414-1.414L12 7.586l1.293-1.293a
                                1 1 0 1 1 1.414 1.414L13.414 9l1.293 1.293a1 1 0 1 1-1.414 1.414L12 10.414l-1.293 1.293a1 1 0 0 1-1.414-1.414L10.586 9 9.293 7.707a1 1 0 0 1 0-1.414z"/>
                        </svg>
                    </div>
                    <div class="schedule-details px-4 py-3">
                        <div class="mb-4">
                            <label for="block_number_${scheduleCount}" class="block text-gray-700">Block Number</label>
                            <input type="text" name="schedules[${scheduleCount}][block_number]" id="block_number_${scheduleCount}" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="year_level_${scheduleCount}" class="block text-gray-700">Year Level</label>
                            <select name="schedules[${scheduleCount}][year_level]" id="year_level_${scheduleCount}" class="w-full px-4 py-2 border rounded" required>
                                @foreach(range(1, 4) as $year)
                                    <option value="{{ $year }}">{{ $year }}th Year</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="course_${scheduleCount}" class="block text-gray-700">Course</label>
                            <input type="text" name="schedules[${scheduleCount}][course]" id="course_${scheduleCount}" class="w-full px-4 py-2 border rounded" required>
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
                </div>
                `;

            const container = document.getElementById('schedules-container');
            const scheduleElement = document.createElement('div');
            scheduleElement.innerHTML = scheduleTemplate;
            container.appendChild(scheduleElement);

            // Add event listener for newly added schedule header
            const newScheduleHeader = scheduleElement.querySelector('.schedule-header');
            newScheduleHeader.addEventListener('click', () => {
                const details = scheduleElement.querySelector('.schedule-details');
                details.classList.toggle('hidden');
            });
        }
    </script>
@endsection
