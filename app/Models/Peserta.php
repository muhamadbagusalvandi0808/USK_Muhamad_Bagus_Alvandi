<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
        'no_peserta',
        'nama',
        'email',
        'alamat',
        'skema_id',
    ];

    public function skema()
    {
        return $this->belongsTo(Skema::class);
    }
};
