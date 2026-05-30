<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Perpustakaan</title>
    <!-- Use Tailwind CDN for admin area to avoid requiring Vite build in dev/testing -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* custom scrollbar for sidebar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #374151; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #4b5563; }
    </style>
</head>
<body class="flex min-h-screen bg-gray-100">

    @include('admin.sidebar')

    <div class="flex-1 p-10">
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 text-green-800">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 rounded bg-red-50 text-red-800">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

</body>
</html>
