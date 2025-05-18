<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $ujianList = Ujian::with('matkul')->get();
        return view('user.index', compact('ujianList'));
    }

    public function show(Ujian $ujian)
    {
        if (!$ujian) abort(404);
        return view('user.detail', compact('ujian'));
    }

    public function start(Ujian $ujian, Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if ($request->password !== $ujian->password_ujian) {
            return back()->withErrors(['password' => 'Password ujian salah']);
        }

        // Simpan session untuk menandai user sudah mulai ujian ini
        Session::put('ujian_started_' . $ujian->id, true);

        // FIXED: pakai route yang ada
        return redirect()->route('user.ujian.detail', $ujian->id);
    }

    public function detail($id)
    {
        $ujian = Ujian::findOrFail($id);
        $soalList = $ujian->soals;

        return view('user.kerjakan', compact('ujian', 'soalList')); // ganti dari 'user.ujian'
    }

    public function submit(Ujian $ujian, Request $request)
    {
        if (!Session::get('ujian_started_' . $ujian->id)) {
            return redirect()->route('user.ujian.detail', $ujian->id)
                ->withErrors(['msg' => 'Silakan mulai ujian terlebih dahulu dengan memasukkan password']);
        }

        $jawaban = $request->input('jawaban', []);

        $soalList = Soal::where('ujian_id', $ujian->id)->get();
        $jumlahSoal = $soalList->count();

        $benar = 0;
        foreach ($soalList as $soal) {
            if (isset($jawaban[$soal->id]) && $jawaban[$soal->id] == $soal->jawaban_benar) {
                $benar++;
            }
        }
        $total = $soalList->count();
        $nilai = $total > 0 ? round(($benar / $total) * 100) : 0;

        // Simpan nilai ke database
        HasilUjian::create([
            'user_id' => Auth::id(),
            'ujian_id' => $ujian->id,
            'nilai' => $nilai,
        ]);

        // Simpan ke session juga kalau mau ditampilkan di `finish()`
        Session::put('nilai_ujian_' . $ujian->id, $nilai);
        Session::forget('ujian_started_' . $ujian->id);

        return redirect()->route('user.ujian.selesai', $ujian->id);
    }

    public function finish(Ujian $ujian)
    {
        $nilai = Session::get('nilai_ujian_' . $ujian->id);

        if ($nilai === null) {
            return redirect()->route('user.ujian.detail', $ujian->id)
                ->withErrors(['msg' => 'Anda belum mengikuti ujian ini.']);
        }

        // Bersihkan session nilai setelah tampilkan hasil
        Session::forget('nilai_ujian_' . $ujian->id);

        return view('user.selesai', compact('nilai'));
    }
}
