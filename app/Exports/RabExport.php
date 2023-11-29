<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RabExport implements FromView, WithColumnFormatting, ShouldAutoSize
{
    protected $projectId, $vendorId;

    public function __construct(int $projectId, $vendorId) {
        $this->projectId = $projectId;
        $this->vendorId = $vendorId;
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function view(): View
    {
        $projectData = Project::findOrFail($this->projectId);

        $collection = [
            'kode_proyek' => $projectData->kode_proyek,
            'nama_proyek' => $projectData->nama_proyek,
            'jobDetails' => $projectData->job_details->map(function ($detail) {
                $pivotTable = \App\Models\JobDetailVendor::where('job_detail_id', $detail->id)
                    ->where('vendor_id', $this->vendorId)
                    ->first();
                $rabData = $pivotTable ? $pivotTable->rab_item : null;
                return [
                    'jobDetail_id' => $detail->id,
                    'jobDetail_name' => $detail->nama_job,
                    'jobDetail_rab' => $rabData !== null ? [
                        'material' => $rabData->materialDetails->map(function ($material) {
                            return [
                                '_name' => $material->material,
                                '_satuan' => $material->satuan,
                                '_quantity' => $material->quantity,
                                '_harga_satuan' => $material->harga_satuan,
                                '_total' => $material->total_harga,
                            ];
                        }),
                        'production_cost' => $rabData->productionCost,
                        'other_cost' => $rabData->otherCost,
                        'subtotal_material' => $rabData->subtotal_material,
                        'subtotal_ongkos_kerja' => $rabData->subtotal_ongkos_kerja,
                        'total_biaya' => $rabData->total_biaya,
                        'lain_lain' => $rabData->lain_lain,
                        'jasa_kontraktor' => $rabData->jasa_kontraktor,
                        'grand_total' => $rabData->grand_total,
                    ] : null,
                ];
            }),
        ];
        return view('exports.rab-export', [
            'data' => $collection
        ]);
    }
}
