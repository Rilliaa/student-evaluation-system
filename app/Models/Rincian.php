<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rincian extends Model
{
    protected $primaryKey = 'id_rincian'; 
    use HasFactory;

    protected $fillable = [ // Mendefinisikan kolom yang dapat diisi
        'id_guru',
        'id_mapel',
        'id_nilai',
        'id_kelas',
        'id_murid',

    ];
    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
