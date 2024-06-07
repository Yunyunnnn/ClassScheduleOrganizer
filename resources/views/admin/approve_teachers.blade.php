<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Approve Teachers</h1>
        <ul class="space-y-4">
            @foreach ($teachers as $teacher)
                <li class="flex items-center justify-between bg-white p-4 rounded-lg shadow-md">
                    <span>{{ $teacher->first_name }} {{ $teacher->last_name }}</span>
                    <form method="POST" action="{{ route('admin.approve.teacher', $teacher->id) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600">Approve</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
