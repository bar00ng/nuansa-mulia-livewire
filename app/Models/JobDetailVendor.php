<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JobDetailVendor extends Pivot
{
    public $timestamps = false;

    public function rab_item() {
        return $this->belongsTo(RabItem::class);
    }

    use HasFactory;
}
