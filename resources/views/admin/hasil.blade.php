<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Hasil Ujian Saya</title>
</head>
<body>
    <h2>Hasil Ujian Saya</h2>
    <table border="1">
        <tr>
            <th>Mata Kuliah</th>
            <th>Judul Ujian</th>
            <th>Nilai</th>
            <th>Tanggal</th>
        </tr>
        @foreach ($hasilUjians as $hasil)
            <tr>
                <td>{{ $hasil->ujian->nama_mata_kuliah ?? '-' }}</td>
                <td>{{ $hasil->ujian->judul_ujian ?? '-' }}</td>
                <td>{{ $hasil->nilai }}</td>
                <td>{{ $hasil->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
