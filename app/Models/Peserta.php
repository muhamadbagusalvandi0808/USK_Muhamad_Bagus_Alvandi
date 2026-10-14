<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
'skema_id',
        'nik',
        'nis', 
        'nama',
        'jk',
        'email',
        'telp',
        'alamat',
    ];

    public function skema()
    {
        return $this->belongsTo(Skema::class);
    }
};
