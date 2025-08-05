<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelanggaranSiswa extends Model
{
    protected $table = 'pelanggaran_siswa';
    use HasFactory;
    protected $fillable = [
        'id_murid',
        'id_pelanggaran',
        'lokasi_pelanggaran',
        'tanggal_pelanggaran',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid');
    }
    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'id_pelanggaran');
    }
}
