<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function ujian()
    {
        return $this->hasMany(Ujian::class);
    }
}

