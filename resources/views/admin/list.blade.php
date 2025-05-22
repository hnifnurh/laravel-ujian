<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Ujian</title>
    <link rel="stylesheet" href="{{ asset('css/list.css') }}">
</head>
<body>
    <h2>Daftar Ujian</h2>

    <a href="{{ route('admin.create') }}">+ Buat Ujian Baru</a><br><br>

    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($ujians->count())
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Judul Ujian</th>
                    <th>Waktu (menit)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ujians as $ujian)
                    <tr>
                        <td>{{ $ujian->id }}</td>
                        <td>{{ $ujian->nama_mata_kuliah }}</td>
                        <td>{{ $ujian->judul_ujian }}</td>
                        <td>{{ $ujian->waktu_ujian }}</td>
                        <td>
                            <a href="{{ route('admin.edit', $ujian->id) }}">Edit</a>
                            <!-- Bisa ditambah Delete dll -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada ujian yang dibuat.</p>
    @endif

    <br>
    <a href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
</body>
</html>
