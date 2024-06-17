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
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Type</th>
                    <th class="py-2 px-4 border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td class="py-2 px-4 border-b">Student</td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('admin.approve', ['id' => $student->student_id, 'type' => 'Student']) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Approve</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-2 px-4 border-b text-center">No pending students</td>
                </tr>
                @endforelse

                @forelse ($teachers as $teacher)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                    <td class="py-2 px-4 border-b">Teacher</td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('admin.approve', ['id' => $teacher->id, 'type' => 'Teacher']) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Approve</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-2 px-4 border-b text-center">No pending teachers</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded mt-6">Logout</button>
        </form>
    </div>
</body>
</html>
