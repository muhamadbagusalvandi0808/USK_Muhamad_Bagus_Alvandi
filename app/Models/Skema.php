<?php

namespace App\Models;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    protected $fillable = [
        'kd_skema',
        'nm_skema',
    ];

    public function pesertas()
    {
        return $this->hasMany(Peserta::class, 'skema_id');
    }
}
