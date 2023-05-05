<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    use HasFactory;
    protected $table = 'instruktur';
    protected $primaryKey = 'id_instruktur';
    public $timestamps = false;
    protected $fillable = [
        'id_instruktur',
        'nama_instruktur',
        'alamat_instruktur',
        'telepon_instruktur',
        'username_instruktur',
        'tanggal_lahir'
    ];
}
