<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - BJL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; margin:0; }
        /* Merak (peacock) gradient background */
        .bg-merak {
            background:
                radial-gradient(circle at 10% 20%, rgba(124,58,237,0.12), transparent 15%),
                linear-gradient(135deg, #052A40 0%, #0B5B5B 40%, #06B6D4 70%, #7C3AED 100%);
            background-attachment: fixed;
            color-scheme: dark;
        }
    </style>
</head>
<body class="bg-red-600">
    <div class="min-h-screen flex flex-col justify-center items-center px-4">
        
        <div class="w-full max-w-sm bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="h-1.5 bg-red-600"></div>
            
            <div class="p-6 md:p-8">
                <div class="mb-6 text-center">
                    <h3 class="text-xl font-bold text-gray-800">Login Admin</h3>
                    <p class="text-xs text-gray-500 mt-1">Gunakan kredensial  E-Commerce BJL Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border-l-2 border-red-500 rounded text-xs text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                            class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500/20 focus:border-red-600 outline-none transition-all placeholder:text-gray-400"
                            placeholder="name@company.com" required autofocus>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider">Password</label>
                        </div>
                        <input type="password" id="password" name="password" 
                            class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500/20 focus:border-red-600 outline-none transition-all placeholder:text-gray-400"
                            placeholder="••••••••" required>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" 
                            class="h-3.5 w-3.5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <label for="remember" class="ml-2 block text-xs text-gray-500 select-none">Ingat sesi saya</label>
                    </div>

                    <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors duration-200 shadow-md shadow-red-500/20">
                        Masuk Dashboard
                    </button>
                </form>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <p class="text-center text-xs text-gray-500">
                        Belum terdaftar? <a href="{{ route('register') }}" class="text-red-600 font-semibold hover:underline">Buat akun admin</a>
                    </p>
                </div>
            </div>
        </div> 
    </div>
</body>
</html>