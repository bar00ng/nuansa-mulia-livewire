<?php

namespace App\Livewire\Rab;

use App\Livewire\Forms\RabForm;
use Livewire\Component;

class CreateRab extends Component
{
    public \App\Models\JobDetail $job_detail;

    public RabForm $form;

    public function mount() {
        $this->form->materials[] = [
            'item' => '',
            'satuan' => '',
            'quantity' => '',
            'harga_satuan' => '',
            'total' => ''
        ];
    }

    public function onSave() {
        $this->validate();
    }

    public function addMaterial() {
        $this->form->materials[] = [
            'item' => '',
            'satuan' => '',
            'quantity' => '',
            'harga_satuan' => '',
            'total' => ''
        ];
    }

    public function removeMaterial($index) {
        unset($this->form->materials[$index]);
        $this->form->materials = array_values($this->form->materials);
    }

    public function render()
    {
        return view('livewire.rab.create-rab')
            ->title("RAB - " .  $this->job_detail->nama_job);
    }
}
