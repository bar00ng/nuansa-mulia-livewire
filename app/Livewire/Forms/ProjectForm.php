<?php

namespace App\Livewire\Forms;

use App\Models\JobDetail;
use App\Models\Project;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ProjectForm extends Form
{
    public $kd_project;

    public $nama_project;

    public $lokasi;

    public $pekerjaan;

    public $client_id = '';

    public $nama_pic;

    public $nomor_pic;

    public $status = \App\Enums\ProjectStatus::ON_GOING;

    public $job_details = [];

    protected $rules = [
        'kd_project' => 'required',
        'nama_project' => 'required',
        'lokasi' => 'required',
        'pekerjaan' => 'required',
        'client_id' => 'required',
        'nama_pic' => 'required',
        'nomor_pic' => 'required',
        'job_details.*.item' => 'required|string|min:3',
        'job_details.*.ukuran' => 'required|string|min:2',
        'job_details.*.keterangan' => 'required|string|min:1',
        'job_details.*.harga_penawaran' => 'required|numeric|min:0',
    ];

    public function save() {
        $project = Project::create([
            "kd_project" => $this->kd_project,
            'nama_project' => $this->nama_project,
            'lokasi' => $this->lokasi,
            'pekerjaan' => $this->pekerjaan,
            'client_id' => $this->client_id,
            'nama_pic' => $this->nama_pic,
            'nomor_pic' => $this->nomor_pic,
            'status' => $this->status
        ]);

        foreach ($this->job_details as $job_detail) {
            $detail = $project->job_details()->create([
                'nama_job' => $job_detail['item'],
                'ukuran_job' => $job_detail['ukuran'],
                'keterangan_job' => $job_detail['keterangan'],
                'harga_penawaran_job' => $job_detail['harga_penawaran'],
                'project_id' => $project->id
            ]);

            $vendor = \App\Models\Vendor::get()->pluck('id');

            $detail->vendors()->attach($vendor, ['project_id' => $project->id]);
        }
    }
}
