<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_client',
        'nama_client',
        'alamat_client',
        'nomor_telepon_client'
    ];

    public function projects() {
        return $this->hasMany(Project::class);
    }
}
