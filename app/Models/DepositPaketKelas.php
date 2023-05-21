<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositPaketKelas extends Model
{
    use HasFactory;
    protected $table = 'deposit_paket_kelas';
    protected $primaryKey = 'id_deposit_paket_kelas';
    public $timestamps = false;
    protected $fillable = [
        'id_deposit_paket_kelas',
        'id_kelas',
        'id_member',
        'depisit_paket_kelas',
        'tgl_kadaluarsa'
    ];
}
