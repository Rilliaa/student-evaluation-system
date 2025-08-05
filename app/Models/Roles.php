<?php
// Model Roles
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_roles'; // Menentukan primary key

    protected $fillable = [
        'nama_roles',
    ];

    // Relasi Roles memiliki banyak murid
    public function murids()
    {
        return $this->hasMany(Murid::class, 'role_id');
    }

    // Relasi Roles memiliki banyak guru
    public function gurus()
    {
        return $this->hasMany(Guru::class);
    }

    // Relasi Roles memiliki banyak wali murid (Ortu)
    public function ortus()
    {
        return $this->hasMany(Ortu::class, 'id_ortu'); // Seharusnya menggunakan belongsTo
    }
}
