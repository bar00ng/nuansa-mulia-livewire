<?php

namespace App\Livewire\Clients;

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
    #[On('client-deleted')]
    public function setMessage($message) {
        if ($message == 'success') {
            flash('Data client berhasil dihapus.', $message);
        } else {
            flash('Gagal menghapus data client.', $message);
        }
    }

    public function render()
    {
        return view('livewire.clients.list-client');
    }
}
