<?php

namespace App\Livewire\Vendors;

use App\Livewire\Forms\VendorForm;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;

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

            flash('Berhasil mengubah data vendor.', 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            flash('Terjadi kesalahan saat mengubah data vendor..', 'danger');

        } catch (QueryException $ex) {
            Log::error($ex);
            DB::rollBack();

            flash('Terjadi kesalahan saat mengubah data vendor..', 'danger');

        }
    }

    public function render()
    {
        return view('livewire.vendors.update-vendor')
            ->title($this->vendor->nama_vendor);
    }
}
