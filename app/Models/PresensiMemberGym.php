<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMemberGym extends Model
{
    use HasFactory;
    protected $table = 'presensi_member_gym';
    public $timestamps = false;
    protected $primaryKey = 'id_presensi_gym';
    protected $fillable = [
        'id_presensi_gym',
        'id_member',
        'waktu_presensi_member_gym',
        'id_gym'
    ];
}
