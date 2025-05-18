<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $fillable = ['ujian_id', 'pertanyaan', 'jumlah_pilihan', 'pilihan', 'jawaban_benar'];

    protected $casts = [
        'pilihan' => 'array', // otomatis decode json ke array saat diakses
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}

