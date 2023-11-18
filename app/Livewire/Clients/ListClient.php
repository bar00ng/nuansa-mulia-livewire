<?php

namespace App\Livewire\Clients;

use App\Livewire\Tables\ClientTable;
use App\Models\Client;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('List Client')]

class ListClient extends Component
{
    public function render()
    {
        return view('livewire.clients.list-client');
    }
}
