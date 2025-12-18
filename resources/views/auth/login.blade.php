<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - E-Commerce BJL</title>
    </head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div style="width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
            <h3>🔑 Halaman Login Admin</h3>

            @if ($errors->any())
                <div style="background-color: #fdd; border: 1px solid #f00; padding: 10px; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 8px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required style="width: 100%; padding: 8px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Saya</label>
                </div>

                <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Login</button>
            </form>
        </div>
    </div>
</body>
</html>