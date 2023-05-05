<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    public $timestamps = false;
    protected $primaryKey = 'id_pegawai';
    protected $fillable = [
        'id_pegawai',
        'username',
        'password',
        'role',
        'no_telp',
        'email',
        'alamat',
        'nama_pegawai',
        'tanggal_lahir',
    ];
}
