<?php

namespace App\Livewire\Clients;

use App\Livewire\Forms\ClientForm;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tambah Client')]

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

            $this->alert('success', 'Berhasil menamahkan client baru.');
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat menambahkan client baru.');
        } catch (QueryException $ex) {
            Log::error($ex);
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat menambahkan client baru.');
        }
    }

    public function render()
    {
        return view('livewire.clients.create-client');
    }
}
