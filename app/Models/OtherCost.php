<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherCost extends Model
{
    use HasFactory;
    protected $fillable = [
        'rab_item_id',
        'satuan',
        'quantity',
        'harga_satuan',
        'total_harga'
    ];

    public function rabItem() {
        return $this->belongsTo(RabItem::class);
    }
}
