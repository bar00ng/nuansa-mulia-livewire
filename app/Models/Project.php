<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Project extends Model
{
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'kd_project',
        'nama_project',
        'client_id',
        'nama_pic',
        'nomor_pic',
        'lokasi',
        'pekerjaan',
        'status',
        'budget_rab'
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function job_details() {
        return $this->hasMany(JobDetail::class);
    }

    public function job_detail_vendor() {
        return $this->hasMany(JobDetailVendor::class);
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
