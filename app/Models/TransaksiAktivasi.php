<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiAktivasi extends Model
{
    use HasFactory;
    protected $table = 'transaksi_aktivasi';
    protected $primaryKey = 'id_transaksi_aktivasi';
    public $timestamps = false;
    protected $fillable = [
        'id_transaksi_aktivasi',
        'id_pegawai',
        'id_member',
        'tgl_transaksi_aktivasi',
        'masa_berlaku_transaksi_aktivasi',
        'jumlah_pembayaran_transaksi_aktivasi',
    ];
}
