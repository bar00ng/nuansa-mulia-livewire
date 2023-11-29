<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    use HasFactory;


    protected $fillable = ['nama_job', 'ukuran_job', 'keterangan_job', 'harga_penawaran_job', 'project_id', 'vendor_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function selectedVendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function vendors()
    {
        // TODO Eager Load rab item relations
        return $this->belongsToMany(Vendor::class)
            ->withPivot(['rab_item_id'])
            ->using(\App\Models\JobDetailVendor::class);
    }
}
