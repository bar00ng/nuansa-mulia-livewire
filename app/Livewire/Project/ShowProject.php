<?php

namespace App\Livewire\Project;

use App\Livewire\Forms\JobDetailForm;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowProject extends Component
{
    use LivewireAlert;

    #[On("job-detail-updated")]
    public function jobDetailUpdated($jobDetail) {
    }

    #[On("confirmed")]
    public function jobDetailDeleteConfirmed($data) {
        $jobDetailId = $data['job_detail_id'] ?? null;

        if ($jobDetailId) {
            try {
                DB::beginTransaction();

                $jobDetail = \App\Models\JobDetail::find($jobDetailId);

                if($jobDetail) {
                    $jobDetail->delete();
                    DB::commit();

                    $this->alert('success', 'Job Detail berhasil dihapus.');
                    $this->dispatch('job-detail-updated', jobDetail: $jobDetail);
                } else {
                    DB::rollBack();
                    Log::error("Tidak ditemukan job detail dengan ID = $jobDetailId.");

                    $this->alert('warning', "Terjadi kesalahan saat menghapus job detail");
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error("Throwable\t: $th");

                $this->alert('warning', "Terjadi kesalahan saat menghapus job detail");
            }
        } else {
            DB::rollBack();
            Log::error("Job Detail ID cannot be null");

            $this->alert('warning', 'Terjadi kesalahan saat menghapus job detail.');
        }
    }

    public \App\Models\Project $project;

    public JobDetailForm $jobDetailForm;

    public function deleteJobDetail($jobDetailId)
    {
        $this->confirm('Apa anda yakin ingin menghapus job detail ini?',[
            'toast' => false,
            'position' => 'center',
            'onConfirmed' => 'confirmed',
            'data' => [
                'job_detail_id' => $jobDetailId
            ]
        ]);
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

            $jobDetail = $this->jobDetailForm->save($this->project);
            DB::commit();
            $this->jobDetailForm->reset();

            $this->alert('success', 'Berhasil menambahkan job detail baru.');
            $this->dispatch('job-detail-updated', jobDetail: $jobDetail);
        } catch (\Throwable $th) {
            Log::error("Throwable\t: $th");
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat menambahkan job detail baru.');
        } catch (QueryException $ex) {
            Log::error("Query Exception\t: $ex");
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat menambahkan job detail baru.');
        }
    }

    public function render()
    {
        return view('livewire.project.show-project')->title($this->project->nama_project);
    }
}
