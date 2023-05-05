<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDefault extends Model
{
    use HasFactory;
    protected $table = 'jadwal_default';
    protected $primaryKey = 'id_jadwal_default';
    public $timestamps = false;
    protected $fillable = [
        'id_instruktur',
        'id_kelas',
        'id_jadwal_default',
        'sesi_jadwal_default',
        'hari_jadwal_default',
    ];
}
