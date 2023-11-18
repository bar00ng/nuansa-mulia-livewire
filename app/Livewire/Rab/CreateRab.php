<?php

namespace App\Livewire\Rab;

use App\Livewire\Forms\RabForm;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateRab extends Component
{
    use LivewireAlert;
    public \App\Models\JobDetail $job_detail;
    public \App\Models\Vendor $vendor;
    public RabForm $form;

    public $readonly;

    public function mount($readonly = false)
    {
        if ($readonly) {
            $rab_item = \App\Models\JobDetailVendor::with('rabItem')
                ->where('job_detail_id', $this->job_detail->id)
                ->where('vendor_id', $this->vendor->id)
                ->first()->rabItem;

            $this->form->subtotal_material = $rab_item->subtotal_material;
            $this->form->subtotal_other_cost = $rab_item->subtotal_ongkos_kerja;
            $this->form->total_biaya = $rab_item->total_biaya;
            $this->form->lain_lain_percent = $rab_item->lain_lain;
            $this->form->lain_lain_converted = ((float) $this->form->lain_lain_percent / 100) * (float) $this->form->total_biaya;
            $this->form->jasa_kontraktor_percent = $rab_item->jasa_kontraktor;
            $this->form->jasa_kontraktor_converted = ((float) $this->form->jasa_kontraktor_percent / 100) * (float) $this->form->total_biaya;
            $this->form->grand_total = $rab_item->grand_total;

            $this->form->production_cost_satuan = $rab_item->productionCost->satuan ?? null;
            $this->form->production_cost_quantity = $rab_item->productionCost->quantity ?? null;
            $this->form->production_cost_harga_satuan = $rab_item->productionCost->harga_satuan ?? null;
            $this->form->production_cost_total = $rab_item->productionCost->total_harga ?? null;

            $this->form->other_cost_satuan = $rab_item->otherCost->satuan ?? null;
            $this->form->other_cost_quantity = $rab_item->otherCost->quantity ?? null;
            $this->form->other_cost_harga_satuan = $rab_item->otherCost->harga_satuan ?? null;
            $this->form->other_cost_total = $rab_item->otherCost->total_harga ?? null;
        }

        if ($readonly) {
            foreach ($rab_item->materialDetails as $material) {
                $this->form->materials[] = [
                    'item' => $material->material,
                    'satuan' => $material->satuan,
                    'quantity' => $material->quantity,
                    'harga_satuan' => $material->harga_satuan,
                    'total' => $material->total_harga,
                ];
            }
        } else {
            $this->form->materials[] = [
                'item' => null,
                'satuan' => null,
                'quantity' => null,
                'harga_satuan' => null,
                'total' => null,
            ];
        }

        $this->readonly = $readonly;
    }

    public function onSave()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            $this->form->store($this->job_detail->id, $this->vendor->id);

            DB::commit();
            $this->form->reset();

            // TODO Tambahkan redirect ke project dashboard

            $this->alert('success', 'Berhasil membuat RAB.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Exception\t: $e");

            $this->alert('warning', 'Terjadi kesalahan saat membuat RAB.');
        } catch (QueryException $ex) {
            DB::rollBack();
            Log::error("Query Exception\t: $ex");

            $this->alert('warning', 'Terjadi kesalahan saat membuat RAB.');
        }
    }

    public function calcMaterialTotal($index)
    {
        $qty = $this->form->materials[$index]['quantity'] ?? 0;
        $hargaSatuan = $this->form->materials[$index]['harga_satuan'] ?? 0;
        $total = (int) $qty * (int) $hargaSatuan;

        $this->form->materials[$index]['total'] = $total;

        $this->calcSubtotalMaterial();
        $this->calcTotalBiaya();
    }

    public function calcSubtotalMaterial()
    {
        $this->form->subtotal_material = array_reduce(
            $this->form->materials,
            function ($carry, $material) {
                return $carry + $material['total'];
            },
            0,
        );
    }

    public function calcTotalBiaya()
    {
        $subtotalMaterial = $this->form->subtotal_material ?? 0;
        $subtotalOthers = $this->form->subtotal_other_cost ?? 0;
        $totalBiaya = (int) $subtotalMaterial + (int) $subtotalOthers;

        $this->form->total_biaya = $totalBiaya;

        $this->convertLainLainPercent();
        $this->convertJasaKontraktorPercent();
        $this->calcGrandTotal();
    }

    public function calcSubtotalOngkosKerja()
    {
        $productionCost = $this->form->production_cost_total ?? 0;
        $otherCost = $this->form->other_cost_total ?? 0;
        $subtotal = (int) $productionCost + (int) $otherCost;

        $this->form->subtotal_other_cost = $subtotal;
    }

    public function calcGrandTotal()
    {
        $totalBiaya = $this->form->total_biaya ?? 0;
        $lainLainConverted = $this->form->lain_lain_converted ?? 0;
        $jasaKontraktorConverted = $this->form->jasa_kontraktor_converted ?? 0;
        $grandTotal = (float) $totalBiaya + (float) $lainLainConverted + (float) $jasaKontraktorConverted;

        $this->form->grand_total = $grandTotal;
    }

    public function convertPercent($percent, &$convertedVal)
    {
        $totalBiaya = $this->form->total_biaya ?? 0;
        $convertedVal = ((float) $percent / 100) * (float) $totalBiaya;
    }

    public function calcProductionCostTotal()
    {
        $qty = $this->form->production_cost_quantity ?? 0;
        $hargaSatuan = $this->form->production_cost_harga_satuan ?? 0;
        $total = (int) $qty * (int) $hargaSatuan;

        $this->form->production_cost_total = $total;

        $this->calcSubtotalOngkosKerja();
        $this->calcTotalBiaya();
    }

    public function calcOtherCostTotal()
    {
        $qty = $this->form->other_cost_quantity ?? 0;
        $hargaSatuan = $this->form->other_cost_harga_satuan ?? 0;
        $total = (int) $qty * (int) $hargaSatuan;

        $this->form->other_cost_total = $total;

        $this->calcSubtotalOngkosKerja();
        $this->calcTotalBiaya();
    }

    public function convertLainLainPercent()
    {
        $this->convertPercent($this->form->lain_lain_percent, $this->form->lain_lain_converted);
        $this->calcGrandTotal();
    }

    public function convertJasaKontraktorPercent()
    {
        $this->convertPercent($this->form->jasa_kontraktor_percent, $this->form->jasa_kontraktor_converted);
        $this->calcGrandTotal();
    }

    public function addMaterial()
    {
        $this->form->materials[] = [
            'item' => null,
            'satuan' => null,
            'quantity' => null,
            'harga_satuan' => null,
            'total' => null,
        ];
    }

    public function removeMaterial($index)
    {
        unset($this->form->materials[$index]);
        $this->form->materials = array_values($this->form->materials);

        $this->calcSubtotalMaterial();
        $this->calcTotalBiaya();
    }

    public function render()
    {
        return view('livewire.rab.create-rab')->title('RAB - ' . $this->job_detail->nama_job);
    }
}
