<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'actor_id',
        'actor_type',
        'action',
        'object_type',
        'object_id',
        'description',
        'time_stamp',
    ];

    public function object()
    {
        return $this->morphTo();
    }

    public function actor()
    {
        return $this->morphTo();
    }
}
