<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Vendor extends Model
{
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'nama_vendor'
    ];

    public function job_details() {
        return $this->belongsToMany(JobDetail::class);
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
