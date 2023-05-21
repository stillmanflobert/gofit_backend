<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiInstruktur extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'presensi_instruktur';
    protected $primaryKey = 'id_presensi_instruktur';
    protected $fillable = [
        'id_presensi_instruktur',
        'id_instruktur',
        'waktu_presensi',
        'waktu_mulai_kelas',
        'durasi_kelas',
    ];
}
