@extends('Teachers/teachers')

@section('title', 'Add Subject')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Add Subject</h1>

    <!-- Warning Modal -->
    @if(session('warning'))
        <div id="warningModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: block;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 18h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Warning
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ session('warning') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="closeWarningModal()">
                            Close
                        </button>
                    </div>
                </div>
            </div>
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

        <div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create Subject</button>
        </div>
    </form>

    <script>
        function closeWarningModal() {
            document.getElementById('warningModal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('warning'))
                document.getElementById('warningModal').style.display = 'block';
            @endif
        });
    </script>
@endsection
