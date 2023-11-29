<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class RabItem extends Model
{
    use HasFactory;

    protected $attributes = [
        "subtotal_ongkos_kerja" => 0,
        'lain_lain' => 0,
        'jasa_kontraktor' => 0
    ];

    protected $fillable = [
        'subtotal_material',
        'subtotal_ongkos_kerja',
        'total_biaya',
        'lain_lain',
        'jasa_kontraktor',
        'grand_total'
    ];

    public function materialDetails() {
        return $this->hasMany(MaterialDetail::class);
    }

    public function otherCost() {
        return $this->hasOne(OtherCost::class);
    }

    public function productionCost() {
        return $this->hasOne(ProductionCost::class);
    }
}
