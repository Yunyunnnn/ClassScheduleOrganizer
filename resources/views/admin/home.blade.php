<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-4">Pending Approvals</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                    <tr>
                        <td class="py-2 px-4">{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td class="py-2 px-4">Student</td>
                        <td class="py-2 px-4">
                            <form action="{{ route('admin.approve', ['id' => $student->student_id, 'type' => 'Student']) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Approve</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-2 px-4 text-center text-gray-500">No pending students</td>
                    </tr>
                    @endforelse

                    @forelse ($teachers as $teacher)
                    <tr>
                        <td class="py-2 px-4">{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                        <td class="py-2 px-4">Teacher</td>
                        <td class="py-2 px-4">
                            <form action="{{ route('admin.approve', ['id' => $teacher->id, 'type' => 'Teacher']) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Approve</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-2 px-4 text-center text-gray-500">No pending teachers</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Logout</button>
        </form>
    </div>
</body>
</html>
