<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDepositKelas extends Model
{
    use HasFactory;
    protected $table = 'transaksi_deposit_kelas';
    protected $primaryKey = 'id_transaksi_deposit_kelas';
    public $timestamps = false;
    protected $fillable = [
        'id_member',
        'id_kelas',
        'id_pegawai',
        'id_transaksi_deposit_kelas',
        'tgl_transaksi_deposit_kelas',
        'jumlah_kelas',
        'bonus_deposit_kelas',
        'total_pembayaran',
        'masa_berlaku'
    ];
}
