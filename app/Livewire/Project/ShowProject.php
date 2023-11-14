<?php

namespace App\Livewire\Project;

use App\Livewire\Forms\JobDetailForm;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowProject extends Component
{
    #[On("job-detail-updated")]
    public function jobDetailUpdated($status) {
        if ($status == 'success') {
            flash('Berhasil menambahkan job detail baru.', $status);
        } else {
            flash('Terjadi kesalahan saat menambahkan job detail baru.', $status);
        }
    }

    public \App\Models\Project $project;

    public JobDetailForm $jobDetailForm;

    public function deleteJobDetail($jobDetailId)
    {
        \App\Models\JobDetail::find($jobDetailId)->delete();
    }

    public function mount()
    {
        $this->project->load('job_details', 'job_details.vendors');
        $this->jobDetailForm->job_details = [];
    }

    public function addJobDetail()
    {
        $this->jobDetailForm->job_details[] = [
            'item' => '',
            'ukuran' => '',
            'keterangan' => '',
            'harga_penawaran' => '',
        ];
    }

    public function removeJobDetail($index)
    {
        unset($this->jobDetailForm->job_details[$index]);
        $this->jobDetailForm->job_details = array_values($this->jobDetailForm->job_details);
    }

    public function updateJobDetails()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->jobDetailForm->save($this->project);
            DB::commit();
            $this->jobDetailForm->reset();

            $this->dispatch('job-detail-updated', status: 'success')->self();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            $this->dispatch('job-detail-updated', status: 'danger')->self();
        } catch (QueryException $ex) {
            Log::error($ex);
            DB::rollBack();

            $this->dispatch('job-detail-updated', status: 'danger')->self();
        }
    }

    public function render()
    {
        return view('livewire.project.show-project')->title($this->project->nama_project);
    }
}
