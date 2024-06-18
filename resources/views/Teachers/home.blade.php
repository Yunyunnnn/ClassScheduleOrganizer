@extends('Teachers.teachers')

@section('title', 'Teacher Dashboard')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h1>
        
        @if ($approved)
            @if (session('approval_message_dismissed', false) == false)
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" id="approvalMessage">
                    Your account is approved.
                    <button onclick="dismissApprovalMessage()" class="absolute top-0 bottom-0 right-0 px-4 py-3">X</button>
                </div>
            @endif

            <table class="min-w-full bg-white shadow-md rounded my-6">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left border-b border-gray-300">Name</th>
                        <th class="py-3 px-6 text-left border-b border-gray-300">Code</th>
                        <th class="py-3 px-6 text-left border-b border-gray-300">Time From</th>
                        <th class="py-3 px-6 text-left border-b border-gray-300">Time To</th>
                        <th class="py-3 px-6 text-left border-b border-gray-300">Days of the Week</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr class="hover:bg-gray-100">
                            <td class="py-4 px-6 border-b border-gray-300">{{ $subject->name }}</td>
                            <td class="py-4 px-6 border-b border-gray-300">{{ $subject->subject_code }}</td>
                            <td class="py-4 px-6 border-b border-gray-300">{{ date('g:i a', strtotime($subject->time_from)) }}</td>
                            <td class="py-4 px-6 border-b border-gray-300">{{ date('g:i a', strtotime($subject->time_to)) }}</td>
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
                                    <span class="inline-block px-2 py-1 text-xs font-semibold leading-none bg-blue-200 text-blue-800 rounded-full mr-1 mb-1">{{ $dayAbbreviation }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        @else
            <p class="text-gray-700 text-lg">Your account is not yet verified by the admin. Please wait for approval.</p>
            <form method="POST" action="{{ route('teacher.logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded mt-6">Logout</button>
            </form>
        @endif
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
