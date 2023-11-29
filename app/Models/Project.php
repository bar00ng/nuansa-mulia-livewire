<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

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
}
