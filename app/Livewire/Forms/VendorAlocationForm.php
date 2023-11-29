<?php

namespace App\Livewire\Forms;

// use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VendorAlocationForm extends Form
{
    public $alokasi_vendor = [];

    public function rules()
    {
        return [
            "alokasi_vendor" => 'required',
            "alokasi_vendor.*.vendor" => 'required'
        ];
    }

    public function messages()
    {
        return [
            'alokasi_vendor.*.vendor.required' => 'Kolom vendor wajib diisi.',
        ];
    }

    public function save() {
        foreach ($this->alokasi_vendor as $job_detail_id => $data) {
            \App\Models\JobDetail::find($job_detail_id)
                ->update([
                    'vendor_id' => $data['vendor']
                ]);
        }
    }
}
