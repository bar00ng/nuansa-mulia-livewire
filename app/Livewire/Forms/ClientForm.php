<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ClientForm extends Form
{
    #[Rule('required')]
    public $nama_client;

    #[Rule('required|min:4|max:4')]
    public $kd_client;

    #[Rule('required')]
    public $alamat_client;

    #[Rule('required')]
    public $nomor_telepon_client;

    public function store() {
        Client::create($this->all());
    }

    public function update($id) {
        Client::findOrFail($id)
            ->update($this->all());
    }
}
