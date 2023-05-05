<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalHarian extends Model
{
    use HasFactory;
    protected $table = 'jadwal_harian';
    protected $primaryKey = 'id_jadwal_kelas';
    public $timestamps = false;
    protected $fillable = [
        'id_jadwal_kelas',
        'waktu_mulai_kelas',
        'waktu_selesai_kelas',
        'id_instruktur',
        'sisa_member_kelas',
        'id_jadwal_default'
    ];
}
