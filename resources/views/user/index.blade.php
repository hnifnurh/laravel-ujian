<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mata Kuliah yang Mengadakan Ujian</title>
</head>
<body>
    <h1>Selamat Datang Bro {{ Auth::user()->name }}</h1>
    <h2>Daftar Mata Kuliah yang Mengadakan Ujian</h2>

    @foreach ($ujianList as $ujian)
        <form method="GET" action="{{ route('user.detail', $ujian->id) }}" style="margin-bottom: 10px;">
            <button type="submit">
                {{ $ujian->nama_mata_kuliah }}
            </button>
        </form>
    @endforeach

    <br>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Log Out</button>
    </form>
</body>
</html>
