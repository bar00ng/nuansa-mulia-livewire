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

    public function messages()
    {
        return [
            'materials.*.item.required' => 'Kolom item pada material wajib diisi.',
            'materials.*.item.min' => 'Kolom item pada material minimal harus memiliki :min karakter.',
            'materials.*.satuan.required' => 'Kolom satuan pada material wajib diisi.',
            'materials.*.satuan.min' => 'Kolom satuan pada material minimal harus memiliki :min karakter.',
            'materials.*.quantity.required' => 'Kolom quantity pada material wajib diisi.',
            'materials.*.quantity.numeric' => 'Kolom quantity pada material harus berupa angka.',
            'materials.*.harga_satuan.required' => 'Kolom harga satuan pada material wajib diisi.',
            'materials.*.harga_satuan.numeric' => 'Kolom harga satuan pada material harus berupa angka.',
            'materials.*.harga_satuan.min' => 'Kolom harga satuan pada material minimal harus lebih besar dari :min.',
            'materials.*.total.required' => 'Kolom total pada material wajib diisi.',
            'materials.*.total.numeric' => 'Kolom total pada material harus berupa angka.',
            'materials.*.total.min' => 'Kolom total pada material minimal harus lebih besar dari :min.',
            'production_cost_total.required_with' => 'Kolom total biaya produksi harus diisi ketika ada nilai pada kolom satuan, quantity, dan harga satuan biaya produksi.',
            'subtotal_material.required' => 'Kolom subtotal material wajib diisi.',
            'subtotal_material.numeric' => 'Kolom subtotal material harus berupa angka.',
            'subtotal_material.min' => 'Kolom subtotal material minimal harus lebih besar dari :min.',
            'subtotal_other_cost.numeric' => 'Kolom subtotal biaya lain-lain harus berupa angka.',
            'subtotal_other_cost.min' => 'Kolom subtotal biaya lain-lain minimal harus lebih besar dari :min.',
            'total_biaya.required' => 'Kolom total biaya wajib diisi.',
            'total_biaya.numeric' => 'Kolom total biaya harus berupa angka.',
            'total_biaya.min' => 'Kolom total biaya minimal harus lebih besar dari :min.',
            'lain_lain_percent.numeric' => 'Kolom persentase lain-lain harus berupa angka.',
            'lain_lain_percent.min' => 'Kolom persentase lain-lain minimal harus lebih besar dari :min.',
            'lain_lain_converted.numeric' => 'Kolom nilai konversi lain-lain harus berupa angka.',
            'lain_lain_converted.min' => 'Kolom nilai konversi lain-lain minimal harus lebih besar dari :min.',
            'jasa_kontraktor_percent.numeric' => 'Kolom persentase jasa kontraktor harus berupa angka.',
            'jasa_kontraktor_percent.min' => 'Kolom persentase jasa kontraktor minimal harus lebih besar dari :min.',
            'jasa_kontraktor_converted.numeric' => 'Kolom nilai konversi jasa kontraktor harus berupa angka.',
            'jasa_kontraktor_converted.min' => 'Kolom nilai konversi jasa kontraktor minimal harus lebih besar dari :min.',
            'grand_total.required' => 'Kolom grand total wajib diisi.',
            'grand_total.numeric' => 'Kolom grand total harus berupa angka.',
            'grand_total.min' => 'Kolom grand total minimal harus lebih besar dari :min.',
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
