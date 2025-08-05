<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    use HasFactory;
    protected $table = 'prestasi_siswa';
    protected $primaryKey = 'id'; 
    protected $fillable = [
        'id_murid',
        'id_prestasi',
        'lokasi_prestasi',
        'tanggal_prestasi',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid');
    }
    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'id_prestasi');
    }
}
