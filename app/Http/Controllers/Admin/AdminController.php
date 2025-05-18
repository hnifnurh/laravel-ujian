<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mata_kuliah' => 'required|string',
            'judul_ujian' => 'required|string',
            'password_ujian' => 'required|string',
            'waktu_ujian' => 'required|integer',
            'soal' => 'required|array',
            'soal.*.pertanyaan' => 'required|string',
            'soal.*.jumlah_pilihan' => 'required|integer',
            'soal.*.pilihan' => 'required|array',
            'soal.*.jawaban_benar' => 'required|string',
        ]);


        $ujian = Ujian::create([
            'nama_mata_kuliah' => $request->nama_mata_kuliah,
            'judul_ujian' => $request->judul_ujian,
            'password_ujian' => $request->password_ujian,
            'waktu_ujian' => $request->waktu_ujian,
        ]);

        foreach ($request->soal as $soalData) {
            Soal::create([
                'ujian_id' => $ujian->id,
                'pertanyaan' => $soalData['pertanyaan'],
                'jumlah_pilihan' => $soalData['jumlah_pilihan'],
                'pilihan' => json_encode($soalData['pilihan']),
                'jawaban_benar' => $soalData['jawaban_benar'],
            ]);
        }

        return redirect()->route('admin.list')->with('success', 'Ujian dan soal berhasil disimpan.');
    }

    public function list()
    {
        $ujians = Ujian::withCount('soals')->get();
        return view('admin.list', compact('ujians'));
    }

    public function score(Request $request)
    {
        $ujians = Ujian::with(['hasilUjians.user'])->get();

        return view('admin.score', compact('ujians'));
    }

    public function edit($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        return view('admin.create', compact('ujian'));
    }

    public function update(Request $request, $id)
    {
        $ujian = Ujian::findOrFail($id);
        $ujian->update([
            'nama_mata_kuliah' => $request->nama_mata_kuliah,
            'judul_ujian' => $request->judul_ujian,
            'password_ujian' => $request->password_ujian,
            'waktu_ujian' => $request->waktu_ujian,
        ]);

        // Hapus semua soal lama
        $ujian->soals()->delete();

        // Simpan soal baru
        foreach ($request->soal as $s) {
            $ujian->soals()->create([
                'pertanyaan' => $s['pertanyaan'],
                'jumlah_pilihan' => $s['jumlah_pilihan'],
                'pilihan' => json_encode($s['pilihan']),
                'jawaban_benar' => $s['jawaban_benar'],
            ]);
        }

        return redirect()->route('admin.list')->with('success', 'Ujian berhasil diperbarui.');
    }
}
