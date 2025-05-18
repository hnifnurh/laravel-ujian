<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;

class UjianController extends Controller
{
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mata_kuliah' => 'required|string|max:255',
            'judul_ujian' => 'required|string|max:255',
            'password_ujian' => 'required|string|max:255',
            'waktu_ujian' => 'required|integer|min:1',
            'soal' => 'required|array|min:1',
            'soal.*.pertanyaan' => 'required|string',
            'soal.*.jumlah_pilihan' => 'required|in:3,4,5',
            'soal.*.pilihan' => 'required|array',
            'soal.*.jawaban_benar' => 'required|string',
        ]);

        $ujian = Ujian::create([
            'nama_mata_kuliah' => $validated['nama_mata_kuliah'],
            'judul_ujian' => $validated['judul_ujian'],
            'password_ujian' => $validated['password_ujian'],
            'waktu_ujian' => $validated['waktu_ujian'],
        ]);

        foreach ($validated['soal'] as $soalData) {
            Soal::create([
                'ujian_id' => $ujian->id,
                'pertanyaan' => $soalData['pertanyaan'],
                'jumlah_pilihan' => $soalData['jumlah_pilihan'],
                'pilihan' => json_encode($soalData['pilihan']),
                'jawaban_benar' => $soalData['jawaban_benar'],
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Ujian berhasil dibuat!');
    }

    public function list()
    {
        $ujians = Ujian::all();
        return view('admin.list', compact('ujians'));
    }

    public function skor($ujian_id)
    {
        $ujian = Ujian::findOrFail($ujian_id);
        $pesertas = HasilUjian::where('ujian_id', $ujian_id)->with('user')->get();

        return view('admin.skor', compact('ujian', 'pesertas'));
    }
}
