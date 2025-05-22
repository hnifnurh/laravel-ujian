<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <title>Detail Mata Kuliah</title>
</head>
<body>
    <h2>Detail Mata Kuliah: {{ $ujian->nama_mata_kuliah }}</h2>
    <p>Judul Ujian: {{ $ujian->judul_ujian }}</p>
        <form method="POST" action="{{ route('user.mulai', $ujian->id) }}">
            @csrf
            <input type="password" name="password" required>
            <button type="submit">Mulai Ujian</button>
        </form>
    <br>
    <a href="{{ route('user.ujian') }}">Kembali ke Daftar Ujian</a>
</body>
</html>
