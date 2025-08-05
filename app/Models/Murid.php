<?php 
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_murid'; 

    protected $fillable = [
        'nisn',
        'nama_murid',
        'tanggal_lahir',
        'jenis_kelamin',
        'id_kelas',
        'tahun_ajaran',
        'password',
        'role',
        'id_ortu',
        'id_kehadiran',
        'id_ta'
    ];
    public function arsip()
    {
        return $this->hasMany(Arsip::class,'id_murid');
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role'); 
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    
    public function ortus()
    {
        return $this->hasMany(Ortu::class, 'id_murid');
    }
    
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'id_nilai');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta');
    }
    

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'id_murid');
    }
}
