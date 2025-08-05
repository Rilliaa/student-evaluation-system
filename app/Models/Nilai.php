<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_nilai'; 

    protected $fillable = [
        'id_murid',
        'id_mapel',
        'nilai',
        'id_ta',
    ];

    public function murids()
    {
        return $this->belongsTo(Murid::class, 'id_murid');
        // return $this->belongsTo(Murid::class);
    }

    public function mapels()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
        // return $this->belongsTo(Mapel::class);
    }
   
}
