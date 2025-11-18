<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Poli;
class Antrian extends Model
{
    protected $fillable = [
        'nama_pasien',
        'nik',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'tanggal_lahir',
        'poli_id',
        'keluhan',
        'jenis_pembayaran',
        'nomor_antrian',
        'estimasi_waktu',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'estimasi_waktu' => 'datetime',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }
}
