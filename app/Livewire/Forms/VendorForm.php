<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class VendorForm extends Form
{
    #[Rule('required')]
    public $nama_vendor;

    public function store() {
        \App\Models\Vendor::create($this->all());
    }

    public function update($id) {
        \App\Models\Vendor::findOrFail($id)
            ->update($this->all());
    }
}
