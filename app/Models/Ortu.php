<?php
// Model Ortu
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ortu extends Authenticatable
{
    use HasFactory;

    // Menentukan primary key
    protected $primaryKey = 'id_ortu'; 

    // Mendefinisikan kolom yang dapat diisi
    protected $fillable = [ 
        'nama_ortu',
        'username',
        'password',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'email',
        'no_hp',
        'role', // Kolom ini seharusnya mengacu pada id_roles di tabel roles
        'id_murid'
    ];

    // Relasi Ortu memiliki satu peran (Roles)
    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role'); // Relasi belongsTo ke model Role
    }

    // Relasi Ortu memiliki banyak murid
    
    public function murids()
    {
        return $this->belongsTo(Murid::class, 'id_murid'); // Relasi hasMany
        // return $this->hasMany(Murid::class, 'id_ortu'); // Relasi hasMany
    }
}
