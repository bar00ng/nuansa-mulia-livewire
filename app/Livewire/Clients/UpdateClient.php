<?php

namespace App\Livewire\Clients;

use Livewire\Attributes\Title;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Livewire\Forms\ClientForm;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateClient extends Component
{
    public ClientForm $form;

    public \App\Models\Client $client;

    use LivewireAlert;

    public function mount() {
        $this->form->nama_client = $this->client->nama_client;
        $this->form->kd_client = $this->client->kd_client;
        $this->form->alamat_client = $this->client->alamat_client;
        $this->form->nomor_telepon_client = $this->client->nomor_telepon_client;
    }

    public function update() {
        $this->form->validate();
        try {
            DB::beginTransaction();

            $this->form->update($this->client->id);
            DB::commit();

            $this->alert('success', 'Berhasil mengubah data client.');
        } catch (\Throwable $th) {
            Log::error("Throwable\t: $th");
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat mengubah data client.');
        } catch (QueryException $ex) {
            Log::error("Query Exception\t: $ex");
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat mengubah data client.');
        }
    }

    public function render()
    {
        return view('livewire.clients.update-client')
            ->title($this->client->nama_client);
    }
}
