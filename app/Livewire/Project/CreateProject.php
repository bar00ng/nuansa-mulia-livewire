<?php

namespace App\Livewire\Project;

use App\Livewire\Forms\JobDetailForm;
use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\JobDetail;
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
    public ProjectForm $projectForm;

    public JobDetailForm $jobDetailForm;

    public $clients;

    use LivewireAlert;

    public function render()
    {
        $this->clients = Client::get();

        return view('livewire.project.create-project');
    }

    public function mount() {
        $this->jobDetailForm->job_details[] = [
            'item' => '',
            'ukuran' => '',
            'keterangan' => '',
            'harga_penawaran' => ''
        ];
    }

    public function removeRow($index) {
        unset($this->jobDetailForm->job_details[$index]);
        $this->jobDetailForm->job_details = array_values($this->jobDetailForm->job_details);
    }

    public function addRow()
    {
        $this->jobDetailForm->job_details[] = [
            'item' => '',
            'ukuran' => '',
            'keterangan' => '',
            'harga_penawaran' => '',
        ];
    }

    public function generateKodeProject()
    {
        $client = Client::find($this->projectForm->client_id);
        $countProject = $client->projects->count() + 1;
        $countProjectFormatted = str_pad($countProject, 3, '0', STR_PAD_LEFT);

        $kodeProject = "$client->kd_client-$countProjectFormatted";

        $this->projectForm->kd_project = $kodeProject;
    }

    public function onSave()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $project = $this->projectForm->save();
            $this->jobDetailForm->save($project);
            DB::commit();
            $this->projectForm->reset();
            $this->jobDetailForm->reset();

            $this->dispatch('job-detail-updated');
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
