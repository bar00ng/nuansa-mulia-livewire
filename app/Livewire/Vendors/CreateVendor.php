<?php

namespace App\Livewire\Vendors;

use App\Livewire\Forms\VendorForm;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Tambah Vendor')]

class CreateVendor extends Component
{
    use LivewireAlert;

    public VendorForm $form;

    public function storeData() {
        $this->validate();
        try {
            DB::beginTransaction();

            $this->form->store();
            DB::commit();
            $this->form->reset();

            $this->alert('success', 'Berhasil menambahkan vendor baru.');
        } catch (\Throwable $th) {
            Log::error("Throwable\t: $th");
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat menghapus vendor.');
        } catch (QueryException $ex) {
            Log::error("Query Exception\t: $ex");
            DB::rollBack();

            $this->alert('warning', 'Terjadi kesalahan saat menghapus vendor.');
        }
    }

    public function render()
    {
        return view('livewire.vendors.create-vendor');
    }
}
