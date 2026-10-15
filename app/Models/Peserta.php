<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'pesertas'; // Sesuaikan jika nama tabelnya berbeda

    // PASTIKAN SEMUA KOLOM INI ADA DI DALAM $fillable
    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'nik',
        'nis',
        'skema_id',
        'jk',
        'telp',
        'alamat',
        'ktp',
        'ijazah',
        'sertifikat',
        'status_verifikasi',
        'status',
    ];

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id');
    }
}