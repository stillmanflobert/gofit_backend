<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinInstruktur extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_izin_instruktur';
    protected $table = 'izin_instruktur';
    public $timestamps = false;
    protected $fillable = [
        'id_izin_instruktur',
        'id_instruktur',
        'id_instruktur_pengganti',
        'waktu_izin',
        'tgl_konfirmasi',
        'status_izin',
        'keterangan'
    ];
}
