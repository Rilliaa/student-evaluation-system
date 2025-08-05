<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajarans';
    protected $primaryKey = 'id_jadwal'; 
    protected $fillable = [ // Mendefinisikan kolom yang dapat diisi
        'id_jam',
        'id_kelas',
        'id_mapel',
        'id_guru',
        'id_ta',
    ];
    use HasFactory;
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    

 
    // public function jampels()
    // {
    //     return $this->hasMany(JamPelajaran::class,  'id_jadwal');
    // }
    public function jampels()
    {
        return $this->belongsTo(JamPelajaran::class,  'id_jam');
    }

    public function mapels()
    {
        // return $this->belongsTo(Mapel::class, 'id_mapel');
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }
   
};
