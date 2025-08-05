<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id_kelas'; 
    protected $fillable = [
       'nama_kelas', 
       'id_guru',
       'id_ta'
    ];

    /**
     * Get the guru that owns the kelas.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    /**
     * The students that belong to the kelas.
     */
    public function murids()
    {
        return $this->hasMany(Murid::class, 'id_kelas');
        // return $this->belongsTo(Murid::class, 'id_kelas');
    }
    
    public function kehadirans()
    {
        // return $this->belongsTo(Murid::class, 'id');sebelum nya pakai has many
        return $this->hasMany(Kehadiran::class, 'id_kelas'); 
    }
    public function rincian()
    {
        return $this->hasManyThrough(Rincian::class, Murid::class);
    }
    public function jadwalPelajarans()
    {
        return $this->hasMany(JadwalPelajaran::class, 'id_kelas');
    }
    public function sesis()
    {
        return $this->hasMany(Sesi::class,'id_kelas');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta');
    }
    
}
