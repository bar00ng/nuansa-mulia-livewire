<?php

namespace App\Livewire\Vendors;

use App\Livewire\Forms\VendorForm;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UpdateVendor extends Component
{
    public VendorForm $form;

    public \App\Models\Vendor $vendor;

    use LivewireAlert;

    public function mount() {
        $this->form->nama_vendor = $this->vendor->nama_vendor;
    }

    public function update() {
        $this->form->validate();
        try {
            DB::beginTransaction();

            $this->form->update($this->vendor->id);
            DB::commit();

            $this->alert('success', 'Berhasil mengubah data vendor.');
        } catch (\Throwable $th) {
            Log::error("Throwable\t: $th");
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat mengubah data vendor');

        } catch (QueryException $ex) {
            Log::error("Query Exception\t: $ex");
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat mengubah data vendor');

        }
    }

    public function render()
    {
        return view('livewire.vendors.update-vendor')
            ->title($this->vendor->nama_vendor);
    }
}
