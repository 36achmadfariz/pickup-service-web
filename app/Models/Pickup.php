<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'nomor_kontak',
        'alamat_pickup',
        'alamat_tujuan',
        'deskripsi_barang',
        'berat_kg',
        'status',
        'assigned_to',
        'catatan',
        'pickup_time',
    ];

    public function kurir()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
