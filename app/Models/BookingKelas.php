<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingKelas extends Model
{
    use HasFactory;
    protected $table = 'booking_kelas';
    protected $primaryKey = 'id_booking_kelas';
    public $timestamps = false;
    protected $fillable = [
        'id_booking_kelas',
        'status_booking_kelas',
        'id_jadwal_kelas',
        'tgl_booking_kelas'
    ];
}
