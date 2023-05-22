<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSesiGym extends Model
{
    use HasFactory;
    protected $table = 'booking_sesi_gym';
    protected $primaryKey = 'id_booking_gym';
    public $timestamps = false;
    protected $fillable = [
        'id_booking_gym',
        'status_booking_gym',
        'id_member',
        'id_gym',
        'tgl_booking_gym'
    ];
}
