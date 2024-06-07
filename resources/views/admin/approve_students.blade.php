<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Students</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Approve Students</h1>
        <ul class="list-disc list-inside">
            @foreach ($students as $student)
                <li class="mb-4">{{ $student->first_name }} {{ $student->last_name }}
                    <form method="POST" action="{{ route('admin.approve.student', $student->id) }}">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md font-semibold">Approve</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
