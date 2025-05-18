<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $fillable = ['nama_mata_kuliah', 'judul_ujian', 'password_ujian', 'waktu_ujian'];

    public function soals()
    {
        return $this->hasMany(Soal::class, 'ujian_id');
    }

    public function hasilUjians()
    {
        return $this->hasMany(HasilUjian::class);
    }

    public function matkul()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah');
    }
}

