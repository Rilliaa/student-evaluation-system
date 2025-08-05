<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_guru'; // Menentukan primary key
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = [ // Mendefinisikan kolom yang dapat diisi
        'nip',
        'nama_guru',
        'id_mapel',
        'alamat',
        'email',
        'password',
        'role',
    ];


    


    public static $rules = [
        'nip' => 'required|unique:gurus,nip',
        // definisikan aturan validasi lainnya di sini
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role'); // Sesuaikan dengan nama kolom yang digunakan untuk menyimpan id role di tabel guru
    }

    // Relasi dengan mapels
    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'id_guru'); // Sesuaikan dengan nama kolom yang digunakan untuk menyimpan id mapel di tabel guru
    }
}
