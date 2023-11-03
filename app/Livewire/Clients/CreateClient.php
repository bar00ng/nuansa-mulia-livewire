<?php

namespace App\Livewire\Clients;

use App\Livewire\Forms\ClientForm;
use App\Models\Client;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateClient extends Component
{
    public ClientForm $form;

    use LivewireAlert;

    public function storeData()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->form->store();
            DB::commit();
            $this->form->reset();

            $this->alert('success', 'Data client berhasil ditambahkan!', [], route('client.index'));
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
        } catch (QueryException $ex) {
            Log::error($ex);
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.clients.create-client')
            ->extends('app')
            ->section('content');
    }
}
