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
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Type</th>
                        <th class="py-2 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingStudents as $student)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td class="py-2 px-4 border-b">Student</td>
                        <td class="py-2 px-4 border-b">
                            <form method="POST" action="{{ route('admin.approve', ['id' => $student->id, 'type' => 'student']) }}">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:text-blue-700">Approve</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    
                    @foreach($pendingTeachers as $teacher)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                        <td class="py-2 px-4 border-b">Teacher</td>
                        <td class="py-2 px-4 border-b">
                            <form method="POST" action="{{ route('admin.approve', ['id' => $teacher->id, 'type' => 'teacher']) }}">
                                @csrf
                                <button type="submit" class="text-blue-500 hover:text-blue-700">Approve</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded mt-6">Logout</button>
        </form>
    </div>
</body>
</html>
