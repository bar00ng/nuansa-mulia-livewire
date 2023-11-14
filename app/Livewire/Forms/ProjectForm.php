<?php

namespace App\Livewire\Forms;

use App\Models\Project;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ProjectForm extends Form
{
    #[Rule("required", message: "Kolom wajib diisi.")]
    public $kd_project;
    #[Rule("required", message: "Kolom wajib diisi.")]
    public $nama_project;
    #[Rule("required", message: "Kolom wajib diisi.")]
    public $lokasi;
    #[Rule("required", message: "Kolom wajib diisi.")]
    public $pekerjaan;
    #[Rule("required", message: "Kolom wajib diisi.")]
    public $client_id = '';
    #[Rule("required", message: "Kolom wajib diisi.")]
    public $nama_pic;
    #[Rule("required", message: "Kolom wajib diisi.")]
    public $nomor_pic;
    public $status = \App\Enums\ProjectStatus::ON_GOING;

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

        return $project;
    }
}
