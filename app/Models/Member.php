<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'member';
    protected $primaryKey = 'id_member';
    public $timestamps = false;
    protected $fillable = [
        'id_member',
        'nama_member',
        'alamat_member',
        'telepon_member',
        'jumlah_deposit_uang',
        'waktu_mulai_aktivasi',
        'waktu_aktivasi_ekspired',
        'waktu_daftar_member',
        'email',
        'tanggal_lahir',
        'status'
    ];
}
