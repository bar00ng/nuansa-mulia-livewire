<?php

namespace App\Livewire\Clients;

use Livewire\Component;

class ListClient extends Component
{
    public function render()
    {
        return view('livewire.clients.list-client')
            ->extends('app')
            ->section('content');
    }
}
