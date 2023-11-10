<?php

namespace App\Livewire\Vendors;

use App\Livewire\Forms\VendorForm;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\Component;

#[Title('Tambah Vendor')]

class CreateVendor extends Component
{
    public VendorForm $form;

    public function storeData() {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->form->store();
            DB::commit();
            $this->form->reset();

            flash('Berhasil menambahkan vendor.', 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            flash('Terjadi kesalahan saat menambahkan vendor.', 'danger');
        } catch (QueryException $ex) {
            Log::error($ex);
            DB::rollBack();

            flash('Terjadi kesalahan saat menambahkan vendor.', 'danger');
        }
    }

    public function render()
    {
        return view('livewire.vendors.create-vendor');
    }
}
