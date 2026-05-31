<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Online</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f1f3f6] flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
        <div class="p-8">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-800">Login Perpustakaan</h1>
                <p class="text-sm text-gray-500 mt-2">Masuk untuk melanjutkan ke dashboard</p>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-[12px] font-semibold text-gray-700 mb-2" for="username">Email atau Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" required
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 py-3 text-sm text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                </div>

                <div>
                    <label class="block text-[12px] font-semibold text-gray-700 mb-2" for="password">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 py-3 text-sm text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100" />
                </div>

                <div class="flex items-center justify-between text-sm text-gray-600">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                        Ingat saya
                    </label>
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Belum punya akun?</a>
                </div>

                <button type="submit" class="w-full rounded-xl bg-[#4f46e5] px-4 py-3 text-sm font-semibold text-white hover:bg-[#4338ca] transition-colors">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
