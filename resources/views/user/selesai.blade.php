<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian Selesai</title>
    <link rel="stylesheet" href="{{ asset('css/selesai.css') }}">
</head>
<body>
    <h2>Ujian Selesai</h2>
    <p>Skor Anda: {{ $nilai }}</p>
    <a href="{{ route('user.ujian') }}">Kembali ke List Ujian</a>
</body>
</html>
