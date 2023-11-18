<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class JobDetail extends Model
{
    use HasFactory;

    use HasUuids;

    protected $fillable = ['nama_job', 'ukuran_job', 'keterangan_job', 'harga_penawaran_job', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function vendors()
    {
        // TODO Eager Load rab item relations
        return $this->belongsToMany(Vendor::class)
            ->withPivot(['rab_item_id'])
            ->using(\App\Models\JobDetailVendor::class);
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
