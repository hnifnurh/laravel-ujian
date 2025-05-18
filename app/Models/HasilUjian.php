<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilUjian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ujian_id',
        'nilai',
        'jawaban_json', // jawaban disimpan dalam format JSON
    ];

    protected $casts = [
        'jawaban_json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}

