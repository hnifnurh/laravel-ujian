<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login Ujian</title>
    <link rel="stylesheet" href="{{ asset('css/login-ujian.css') }}">
</head>
<body>
    <h2>Selamat datang Di Page Ujian, Silahkan Login Dulu</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
    @csrf
        <label>Email:</label><br />
        <input type="email" name="email" required /><br /><br />

        <label>Password:</label><br />
        <input type="password" name="password" required /><br /><br />

        <button type="submit">Login</button>
    </form>
</body>
</html>
