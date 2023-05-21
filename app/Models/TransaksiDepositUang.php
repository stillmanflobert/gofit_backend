<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDepositUang extends Model
{
    use HasFactory;
    protected $table = 'transaksi_deposit_uang';
    protected $primaryKey = 'id_transaksi_deposit_uang';
    public $timestamps = false;
    protected $fillable = [
        'id_transaksi_deposit_uang',
        'id_pegawai',
        'id_member',
        'tgl_transaksi_deposit_uang',
        'jumlah_transaksi_deposit_uang',
        'bonus_deposit_uang',
        'total_transaksi_deposit_uang'
    ];
}
