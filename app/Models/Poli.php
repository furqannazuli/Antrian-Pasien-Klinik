<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    protected $fillable = [
        'nama_poli',
        'loket',
    ];

    public function antrians()
    {
        return $this->hasMany(Antrian::class);
    }
}
