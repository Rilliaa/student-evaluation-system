<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_mapel'; // Menentukan primary key

    protected $fillable = [ // Mendefinisikan kolom yang dapat diisi
        'kode_mapel',
        'nama_mapel',
        'id_guru',

    ];
    
    public function rules()
    {
        return [
            'kode_mapel' => 'required|unique:mapels',
            // tambahkan aturan validasi lain jika perlu
        ];
    }

    public function gurus()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    //  yg lama
    }
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'id_mapel', 'id_mapel');
        // return $this->hasMany(Nilai::class, 'id_mapel');
    }
 
    

    // Definisikan relasi dengan tabel lain di sini jika diperlukan
}
