<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buat Ujian</title>
    <link rel="stylesheet" href="{{ asset('css/create-ujian.css') }}">
</head>
<body>
    <h2>{{ isset($ujian) ? 'Edit Ujian' : 'Buat Ujian Baru' }}</h2>

    <form method="POST" action="{{ isset($ujian) ? route('admin.update', $ujian->id) : route('admin.store') }}">
        @csrf

        <label for="nama_mata_kuliah">Nama Mata Kuliah:</label><br>
        <input type="text" name="nama_mata_kuliah" value="{{ old('nama_mata_kuliah', $ujian->nama_mata_kuliah ?? '') }}"><br><br>

        <label for="judul_ujian">Judul Ujian:</label><br>
        <input type="text" name="judul_ujian" value="{{ old('judul_ujian', $ujian->judul_ujian ?? '') }}"><br><br>

        <label for="password_ujian">Password Ujian:</label><br>
        <input type="text" name="password_ujian" value="{{ old('password_ujian', $ujian->password_ujian ?? '') }}"><br><br>

        <label for="waktu_ujian">Waktu Ujian (menit):</label><br>
        <input type="number" name="waktu_ujian" value="{{ old('waktu_ujian', $ujian->waktu_ujian ?? '') }}"><br><br>

        <h3>Soal Ujian (Pilihan Ganda)</h3>
        <div id="soal-container">
            <!-- Soal pertama otomatis muncul -->
            <div class="soal-group" data-index="0">
                <button type="button" class="remove-btn" onclick="removeSoal(this)" style="display:none;">-</button>

                <label>Pertanyaan:</label><br>
                <textarea name="soal[0][pertanyaan]" required></textarea><br><br>

                <label>Jumlah Pilihan:</label><br>
                <select name="soal[0][jumlah_pilihan]" onchange="updatePilihan(this)" required>
                    <option value="3" selected>3 (a-c)</option>
                    <option value="4">4 (a-d)</option>
                    <option value="5">5 (a-e)</option>
                </select><br><br>

                <div class="pilihan-container">
                    <label>Pilihan a:</label><br>
                    <input type="text" name="soal[0][pilihan][a]" required><br><br>

                    <label>Pilihan b:</label><br>
                    <input type="text" name="soal[0][pilihan][b]" required><br><br>

                    <label>Pilihan c:</label><br>
                    <input type="text" name="soal[0][pilihan][c]" required><br><br>
                </div>

                <label>Jawaban Benar:</label><br>
                <select name="soal[0][jawaban_benar]" required>
                    <option value="a" selected>A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                </select><br><br>
            </div>
        </div>

        <button type="button" onclick="addSoal()">+ Tambah Soal</button><br><br>

        <button type="submit">{{ isset($ujian) ? 'Update Ujian' : 'Simpan Ujian' }}</button>
    </form>

    <script>
        let soalCount = 1;

        function addSoal() {
            const container = document.getElementById('soal-container');
            const index = soalCount++;

            const soalGroup = document.createElement('div');
            soalGroup.classList.add('soal-group');
            soalGroup.setAttribute('data-index', index);

            soalGroup.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeSoal(this)">-</button>

                <label>Pertanyaan:</label><br>
                <textarea name="soal[${index}][pertanyaan]" required></textarea><br><br>

                <label>Jumlah Pilihan:</label><br>
                <select name="soal[${index}][jumlah_pilihan]" onchange="updatePilihan(this)" required>
                    <option value="3" selected>3 (a-c)</option>
                    <option value="4">4 (a-d)</option>
                    <option value="5">5 (a-e)</option>
                </select><br><br>

                <div class="pilihan-container">
                    <label>Pilihan a:</label><br>
                    <input type="text" name="soal[${index}][pilihan][a]" required><br><br>

                    <label>Pilihan b:</label><br>
                    <input type="text" name="soal[${index}][pilihan][b]" required><br><br>

                    <label>Pilihan c:</label><br>
                    <input type="text" name="soal[${index}][pilihan][c]" required><br><br>
                </div>

                <label>Jawaban Benar:</label><br>
                <select name="soal[${index}][jawaban_benar]" required>
                    <option value="a" selected>A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                </select><br><br>
            `;

            container.appendChild(soalGroup);
        }

        function removeSoal(button) {
            const soalGroup = button.closest('.soal-group');
            soalGroup.remove();
        }

        function updatePilihan(select) {
            const jumlah = parseInt(select.value);
            const container = select.closest('.soal-group').querySelector('.pilihan-container');
            const index = select.closest('.soal-group').getAttribute('data-index');

            container.innerHTML = '';

            const letters = ['a', 'b', 'c', 'd', 'e'];
            for(let i = 0; i < jumlah; i++) {
                const letter = letters[i];
                container.innerHTML += `
                    <label>Pilihan ${letter}:</label><br>
                    <input type="text" name="soal[${index}][pilihan][${letter}]" required><br><br>
                `;
            }

            const jawabanSelect = select.closest('.soal-group').querySelector('select[name$="[jawaban_benar]"]');
            jawabanSelect.innerHTML = '';
            for(let i = 0; i < jumlah; i++) {
                const letter = letters[i];
                jawabanSelect.innerHTML += `<option value="${letter}">${letter.toUpperCase()}</option>`;
            }
        }
    </script>

    <br>
    <a href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
</body>
</html>
