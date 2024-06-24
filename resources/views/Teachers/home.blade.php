@extends('Teachers.teachers')

@section('title', 'Teacher Dashboard')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Welcome, Teacher {{ auth()->user()->last_name }}</h1>

        <!-- Flash Message -->
        @if (session('approval_message'))
            <div id="approvalMessage" class="bg-green-500 text-white p-4 rounded mb-4 flex justify-between items-center">
                <div>{{ session('approval_message') }}</div>
                <button type="button" class="text-white hover:text-gray-200" onclick="dismissApprovalMessage()">&times;</button>
            </div>
        @endif

        <!-- Subjects and Schedules Table -->
        <div class="overflow-x-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-500 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium">Subject Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Subject Code</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Schedules</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($subjects as $subject)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $subject->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $subject->subject_code }}</td>
                                <td class="px-6 py-4 space-y-2">
                                    <ul class="divide-y divide-gray-200">
                                        @foreach ($subject->schedules as $schedule)
                                            <li class="py-2 flex space-x-4 items-center">
                                                <div class="w-14 h-8 flex items-center justify-center bg-blue-200 rounded-md text-blue-800 font-semibold text-xs">
                                                    @php
                                                        $daysOfWeek = explode(',', $schedule->days_of_week);
                                                    @endphp
                                                    @foreach ($daysOfWeek as $day)
                                                        @php
                                                            switch (trim($day)) {
                                                                case 'Monday':
                                                                    echo 'M';
                                                                    break;
                                                                case 'Tuesday':
                                                                    echo 'T';
                                                                    break;
                                                                case 'Wednesday':
                                                                    echo 'W';
                                                                    break;
                                                                case 'Thursday':
                                                                    echo 'Th';
                                                                    break;
                                                                case 'Friday':
                                                                    echo 'F';
                                                                    break;
                                                                case 'Saturday':
                                                                    echo 'S';
                                                                    break;
                                                                case 'Sunday':
                                                                    echo 'Su';
                                                                    break;
                                                                default:
                                                                    echo '';
                                                                    break;
                                                            }
                                                        @endphp
                                                        @if (!$loop->last)
                                                            <span class="mr-1"></span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="flex-1 ml-2 space-y-1">
                                                    <div class="text-sm font-semibold">Block: {{ $schedule->block_number }}</div>
                                                    <div class="text-xs text-gray-600">{{ $schedule->course }}</div>
                                                    <div class="text-xs text-gray-600">Time: {{ date('g:i a', strtotime($schedule->time_from)) }} - {{ date('g:i a', strtotime($schedule->time_to)) }}</div>
                                                    <div class="text-xs text-gray-600">Room: {{ $schedule->room }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function dismissApprovalMessage() {
            document.getElementById('approvalMessage').remove();
            fetch('{{ route("teacher.dismissApprovalMessage") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        }
    </script>
@endsection
