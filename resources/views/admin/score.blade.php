<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Skor Ujian</title>
</head>
<body>
    <h1>Daftar Nilai Semua Ujian</h1>

    @forelse($ujians as $ujian)
        <h2>{{ $ujian->nama_mata_kuliah }} - {{ $ujian->judul_ujian }}</h2>

        @if($ujian->hasilUjians->isEmpty())
            <p>Belum ada peserta.</p>
        @else
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ujian->hasilUjians as $hasil)
                        <tr>
                            <td>{{ $hasil->user->name ?? 'Tidak diketahui' }}</td>
                            <td>{{ $hasil->nilai }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <br>
    @empty
        <p>Tidak ada ujian tersedia.</p>
    @endforelse

    <a href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
</body>
</html>
