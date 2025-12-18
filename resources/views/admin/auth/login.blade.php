<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 h-screen flex justify-center items-center">

    <div class="bg-white w-96 p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Login Admin</h2>

        @if ($errors->any())
            <div class="text-red-500 mb-2">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded">
            </div>

            <button class="bg-blue-600 text-white w-full p-2 rounded">Login</button>
        </form>
    </div>

</body>
</html>
