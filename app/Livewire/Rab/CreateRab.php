<?php

namespace App\Livewire\Rab;

use App\Livewire\Forms\RabForm;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateRab extends Component
{
    public \App\Models\JobDetail $job_detail;
    public \App\Models\Vendor $vendor;

    public RabForm $form;

    public function mount() {
        $this->form->materials[] = [
            'item' => '',
            'satuan' => '',
            'quantity' => '',
            'harga_satuan' => '',
            'total' => ''
        ];
    }

    public function onSave() {
        $this->validate();

        try {
            DB::beginTransaction();
            $this->form->store($this->job_detail->id, $this->vendor->id);

            DB::commit();
            $this->form->reset();

            flash('Berhasil membuat RAB.' , 'success');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());

            flash('Terjadi kesalahan saat membuat RAB.' , 'danger');
        } catch (QueryException $qex) {
            DB::rollBack();
            Log::error($qex->getMessage());

            flash('Terjadi kesalahan saat membuat RAB.' , 'danger');
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

    public function addMaterial() {
        $this->form->materials[] = [
            'item' => '',
            'satuan' => '',
            'quantity' => '',
            'harga_satuan' => '',
            'total' => ''
        ];
    }

    public function removeMaterial($index) {
        unset($this->form->materials[$index]);
        $this->form->materials = array_values($this->form->materials);

        $this->calcSubtotalMaterial();
        $this->calcTotalBiaya();
    }

    public function render()
    {
        return view('livewire.rab.create-rab')
            ->title("RAB - " .  $this->job_detail->nama_job);
    }
}
