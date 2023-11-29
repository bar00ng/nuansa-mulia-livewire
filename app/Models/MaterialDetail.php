<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'rab_item_id',
        'material',
        'satuan',
        'quantity',
        'harga_satuan',
        'total_harga'
    ];

    public function rabItem() {
        return $this->belongsTo(RabItem::class);
    }
}
