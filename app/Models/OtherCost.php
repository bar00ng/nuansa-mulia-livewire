<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class OtherCost extends Model
{
    use HasFactory, HasUuids;
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

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
