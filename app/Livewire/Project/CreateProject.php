<?php

namespace App\Livewire\Project;

use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tambah Project')]

class CreateProject extends Component
{
    public ProjectForm $form;

    public $clients;

    use LivewireAlert;

    public function render()
    {
        $this->clients = Client::get();

        return view('livewire.project.create-project');
    }

    public function mount() {
        $this->form->job_details[] = [
            'item' => '',
            'ukuran' => '',
            'keterangan' => '',
            'harga_penawaran' => ''
        ];
    }

    public function removeRow($index) {
        unset($this->form->job_details[$index]);
        $this->form->job_details = array_values($this->form->job_details);
    }

    public function addRow()
    {
        $this->form->job_details[] = [
            'item' => '',
            'ukuran' => '',
            'keterangan' => '',
            'harga_penawaran' => '',
        ];
    }

    public function generateKodeProject()
    {
        $client = Client::find($this->form->client_id);
        $countProject = $client->projects->count() + 1;
        $countProjectFormatted = str_pad($countProject, 3, '0', STR_PAD_LEFT);

        $kodeProject = "$client->kd_client-$countProjectFormatted";

        $this->form->kd_project = $kodeProject;
    }

    public function onSave()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->form->save();
            DB::commit();
            $this->form->reset();

            flash('Berhasil menambahkan project.', 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            flash('Terjadi kesalahan saat menambahkan project.', 'danger');
        } catch (QueryException $ex) {
            Log::error($ex);
            DB::rollBack();

            flash('Terjadi kesalahan saat menambahkan project.', 'danger');
        }
    }
}
