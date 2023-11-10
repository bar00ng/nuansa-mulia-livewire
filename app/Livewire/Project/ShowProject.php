<?php

namespace App\Livewire\Project;

use Livewire\Component;

class ShowProject extends Component
{
    public \App\Models\Project $project;

    public $job_details;

    public function deleteJobDetail($jobDetailId) {
        \App\Models\JobDetail::find($jobDetailId)
            ->delete();
    }

    public function mount() {
        $this->job_details = [];
    }

    public function addJobDetail(){
        $this->job_details[] = [
            'item' => '',
            'ukuran' => '',
            'keterangan' => '',
            'harga_penawaran' => ''
        ];
    }

    public function removeJobDetail($index) {
        unset($this->job_details[$index]);
        $this->job_details = array_values($this->job_details);
    }

    public function render()
    {
        return view('livewire.project.show-project')
            ->title($this->project->nama_project);
    }
}
