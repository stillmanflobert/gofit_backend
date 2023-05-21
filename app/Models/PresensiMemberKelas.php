<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMemberKelas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'presensi_member_kelas';
    protected $primaryKey = 'id_presensi_kelas';
    protected $fillable = [
        'id_presensi_kelas',
        'id_member',
        'waktu_presensi_member_kelas',
        'id_jadwal_kelas'
    ];
}
