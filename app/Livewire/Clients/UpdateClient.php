<?php

namespace App\Livewire\Clients;

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

            flash('Berhasil mengubah data client.', 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            flash('Terjadi kesalahan saat mengubah data client.', 'danger');
        } catch (QueryException $ex) {
            Log::error($ex);
            DB::rollBack();

            flash('Terjadi kesalahan saat mengubah data client.', 'danger');
        }
    }

    public function render()
    {
        return view('livewire.clients.update-client')
            ->title($this->client->nama_client);
    }
}
