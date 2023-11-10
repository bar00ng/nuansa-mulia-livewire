<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class RabForm extends Form
{
    public $materials = [];

    public $ongkos_produksi_satuan;
    public $ongkos_produksi_quantity;
    public $ongkos_produksi_harga_satuan;
    public $ongkos_produksi_total;

    public $other_cost_satuan;
    public $other_cost_quantity;
    public $other_cost_harga_satuan;
    public $other_cost_total;

    public $subtotal_material;

    public $subtotal_ongoks_kerja;

    public $total;

    public $lain_lain_percent;
    public $lain_lain_converted;

    public $jasa_kontraktor_percent;
    public $jasa_kontraktor_converted;

    public function rules()
    {
        return [
            'materials.*.item' => 'required|string',
            'materials.*.satuan' => 'required|string',
            'materials.*.harga_satuan' => 'required|numeric',
            'materials.*.quantity' => 'required|numeric',
            'materials.*.total' => 'required|numeric',

            'ongkos_produksi_satuan' => 'required_with:ongkos_produksi_quantity,ongkos_produksi_harga_satuan',
            'ongkos_produksi_quantity' => 'required_with:ongkos_produksi_satuan,ongkos_produksi_harga_satuan',
            'ongkos_produksi_harga_satuan' => 'required_with:ongkos_produksi_satuan,ongkos_produksi_quantity',

            'other_cost_satuan' => 'required_with:other_cost_quantity,other_cost_harga_satuan',
            'other_cost_quantity' => 'required_with:other_cost_satuan,other_cost_harga_satuan',
            'other_cost_harga_satuan' => 'required_with:other_cost_satuan,other_cost_quantity',

            'subtotal_material' => 'required|numeric',

            'total' => 'required|numeric'
        ];
    }

    public function messages() {
        return [
            'materials.*.*.required' => 'Kolom ini wajib diisi.',
            'required_with' => 'Kolom ini wajib diisi.'
        ];
    }
}
