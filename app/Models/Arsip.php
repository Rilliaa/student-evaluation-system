<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';
    protected $primaryKey = 'id_arsip';
    protected $fillable = [
    'id_murid', 
    'id_ta', 
    'id_kelas',
    ];
    
    public function kelas()
{
    return $this->belongsTo(Kelas::class, 'id_kelas');
}

    public function murids()
    {
        return $this->belongsTo(Murid::class,'id_murid');
    }
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta');
    }
}
