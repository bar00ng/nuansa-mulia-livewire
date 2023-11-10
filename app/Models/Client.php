<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Client extends Model
{
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'kd_client',
        'nama_client',
        'alamat_client',
        'nomor_telepon_client'
    ];

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
