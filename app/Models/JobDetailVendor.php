<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetailVendor extends Model
{
    public $timestamps = false;
    protected $table = 'job_detail_vendor';

    public function rabItem() {
        return $this->belongsTo(RabItem::class);
    }

    use HasFactory;
}
