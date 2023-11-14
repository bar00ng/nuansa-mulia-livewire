<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class JobDetailForm extends Form
{
    public $job_details = [];

    public function rules()
    {
        return [
            'job_details' => 'required',
            'job_details.*.item' => 'required|string|min:3',
            'job_details.*.ukuran' => 'required|string|min:2',
            'job_details.*.keterangan' => 'required|string|min:1',
            'job_details.*.harga_penawaran' => 'required|string|min:0',
        ];
    }

    public function messages()
    {
        return [
            'job_details.*.item.required' => 'Item wajib diisi',
            'job_details.*.ukuran.required' => 'Ukuran wajib diisi',
            'job_details.*.keterangan.required' => 'Keterangan wajib diisi',
            'job_details.*.harga_penawaran.required' => 'Harga penawaran wajib diisi',
        ];
    }

    public function save($project)
    {
        $dataExist = false;

        if (\App\Models\JobDetailVendor::where('project_id', $project->id)->count() > 1) {
            $dataExist = true;
        }

        if ($dataExist) {
            $vendorData = \App\Models\JobDetailVendor::where('project_id', $project->id)
                ->distinct()
                ->select('vendor_id')
                ->get();
        } else {
            $vendorData = \App\Models\Vendor::select('id as vendor_id')->get();
        }

        foreach ($this->job_details as $job_detail) {
            $detail = $project->job_details()->create([
                'nama_job' => $job_detail['item'],
                'ukuran_job' => $job_detail['ukuran'],
                'keterangan_job' => $job_detail['keterangan'],
                'harga_penawaran_job' => $job_detail['harga_penawaran'],
                'project_id' => $project->id,
            ]);

            foreach ($vendorData as $vendor) {
                $detail->refresh();
                $detail->vendors()->attach($vendor->vendor_id,['project_id' => $project->id]);
            }
        }
    }
}
