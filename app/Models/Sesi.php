<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    protected $table = 'sesi';
    protected $primaryKey = 'id_sesi';
    protected $fillable = [
    'tanggal', 
    'hari', 
    'id_ta', 
    'id_kehadiran'
];

    // Definisi relasi kehadiran ke sesi
    public function kehadiran()
    {
        return $this->belongsTo(Kehadiran::class, 'id_kehadiran');
    }
    public function tahunAjaran()
    {
     return $this->belongsTo(TahunAjaran::class,'id_ta');
    }
}
