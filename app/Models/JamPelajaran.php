<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamPelajaran extends Model
{
    use HasFactory;
    protected $table = 'jam_pelajarans';
    protected $primaryKey = 'id_jam'; 

    protected $fillable = [ 
        'jam_ke',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'hari',
        'id_jadwal' // Asumsikan ini adalah kunci luar untuk relasi dengan JadwalPelajaran
    ];

    public function jadwals()
    {
        return $this->hasMany(JadwalPelajaran::class, 'id_jam');
    }
    
}
