<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard-ujian.css') }}">
</head>
<body>
    <h2>Dashboard Admin</h2>
    <ul>
        <li><a href="{{ route('admin.create') }}">Buat Ujian</a></li>
        <li><a href="{{ route('admin.list') }}">List Ujian</a></li>
        <li><a href="{{ route('admin.score', ['ujian_id' => 1]) }}">Skor Ujian</a></li>
    </ul>

    <br>
    <form action="{{ route('logout') }}" method="POST" style="max-width: 500px;">
        @csrf
        <button type="submit">Log Out</button>
    </form>
</body>
</html>
