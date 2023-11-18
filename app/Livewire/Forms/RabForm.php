<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class RabForm extends Form
{
    public $production_cost_satuan, $production_cost_quantity, $production_cost_harga_satuan, $production_cost_total;

    public $other_cost_satuan, $other_cost_quantity, $other_cost_harga_satuan, $other_cost_total;

    public $materials = [];

    public $subtotal_material;

    public $subtotal_other_cost;

    public $total_biaya;

    public $grand_total;

    public $lain_lain_percent;

    public $lain_lain_converted;

    public $jasa_kontraktor_percent;

    public $jasa_kontraktor_converted;

    public function rules()
    {
        return [
            // Production Cost Validation
            'production_cost_satuan' => 'nullable|string',
            'production_cost_quantity' => 'nullable|numeric',
            'production_cost_harga_satuan' => 'nullable|numeric',
            'production_cost_total' => 'nullable|numeric|required_with:production_cost_satuan,production_cost_quantity,production_cost_harga_satuan',

            // Other Cost Validation
            'other_cost_satuan' => 'nullable|string',
            'other_cost_quantity' => 'nullable|numeric',
            'other_cost_harga_satuan' => 'nullable|numeric',
            'other_cost_total' => 'nullable|numeric|required_with:other_cost_satuan,other_cost_quantity,other_cost_harga_satuan',

            // Subtotal Material, Other, Total Buaya
            'subtotal_material' => 'required|numeric|min:0',
            'subtotal_other_cost' => 'nullable|numeric|min:0',
            'total_biaya' => 'required|numeric|min:0',

            // Lain- lain and Jasa Kontraktor Field
            'lain_lain_percent' => 'nullable|numeric|min:0',
            'lain_lain_converted' => 'nullable|numeric|min:0',
            'jasa_kontraktor_percent' => 'nullable|numeric|min:0',
            'jasa_kontraktor_converted' => 'nullable|numeric|min:0',

            // Material Field
            'materials.*.item' => 'required|min:3',
            'materials.*.satuan' => 'required|min:2',
            'materials.*.quantity' => 'required|numeric',
            'materials.*.harga_satuan' => 'required|numeric|min:0',
            'materials.*.total' => 'required|numeric|min:0',

            // Grand Total Field
            'grand_total' => 'required|min:0|numeric',
        ];
    }

    // TODO Buat validation message
    public function messages()
    {
        return [
            'materials.*.*.required' => 'Kolom ini wajib diisi.',
            'production_cost_total.required_with' => 'tes',
        ];
    }

    public function store($job_detail_id, $vendor_id)
    {
        $rabItem = \App\Models\RabItem::create([
            'subtotal_material' => $this->subtotal_material,
            'subtotal_ongkos_kerja' => $this->subtotal_other_cost,
            'total_biaya' => $this->total_biaya,
            'lain_lain' => $this->lain_lain_percent,
            'jasa_kontraktor' => $this->jasa_kontraktor_percent,
            'grand_total' => $this->grand_total,
        ]);

        foreach ($this->materials as $material) {
            $rabItem->materialDetails()->create([
                'material' => $material['item'],
                'satuan' => $material['satuan'],
                'quantity' => $material['quantity'],
                'harga_satuan' => $material['harga_satuan'],
                'total_harga' => $material['total'],
            ]);
        }

        if ($this->production_cost_satuan && $this->production_cost_quantity && $this->production_cost_harga_satuan && $this->production_cost_total) {
            $rabItem->productionCost()->create([
                'satuan' => $this->production_cost_satuan,
                'quantity' => $this->production_cost_quantity,
                'harga_satuan' => $this->production_cost_harga_satuan,
                'total_harga' => $this->production_cost_total,
            ]);
        }

        if ($this->other_cost_harga_satuan && $this->other_cost_quantity && $this->other_cost_harga_satuan && $this->other_cost_total) {
            $rabItem->otherCost()->create([
                'satuan' => $this->other_cost_harga_satuan,
                'quantity' => $this->other_cost_quantity,
                'harga_satuan' => $this->other_cost_harga_satuan,
                'total_harga' => $this->other_cost_total,
            ]);
        }

        \App\Models\JobDetailVendor::where('job_detail_id', $job_detail_id)
            ->where('vendor_id', $vendor_id)
            ->update([
                'rab_item_id' => $rabItem->id,
            ]);
    }
}
