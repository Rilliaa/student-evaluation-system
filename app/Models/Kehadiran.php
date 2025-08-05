<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_murid',
        'id_kelas',
        'status',
        'keterangan',
        'id_sesi'
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas'); // Relasi belongsTo ke model Murid
    }
    public function sesi()
    {
        return $this->hasMany(Sesi::class, 'id_kehadiran');
    }
 
}
