<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/kerjakan.css') }}">
    <title>Ujian: {{ $ujian->judul }}</title>
    <script>
        let totalSeconds = {{ ($ujian->waktu_ujian ?? 30) * 60 }}; // default 30 menit
        function startTimer() {
            const timerDisplay = document.getElementById("timer");
            const interval = setInterval(() => {
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                timerDisplay.innerText = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                totalSeconds--;

                if (totalSeconds < 0) {
                    clearInterval(interval);
                    alert("Waktu ujian habis. Jawaban akan dikumpulkan otomatis.");
                    document.getElementById("ujian-form").submit();
                }
            }, 1000);
        }

        window.onload = startTimer;
    </script>
</head>
<body>
    <h2>Ujian: {{ $ujian->judul }}</h2>
    <p>Sisa waktu: <span id="timer"></span></p>

    <form id="ujian-form" method="POST" action="{{ route('user.submit', $ujian->id) }}">
        @csrf
        @foreach ($soalList as $index => $soal)
            <p>{{ $index + 1 }}. {{ $soal->pertanyaan }}</p>
            @php $opsi = json_decode($soal->pilihan, true); @endphp
            @foreach ($opsi as $key => $value)
                <label>
                    <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $key }}"> {{ $value }}
                </label><br>
            @endforeach
        @endforeach
        <br>
        <button type="submit">Kumpulkan</button>
    </form>
</body>
</html>
