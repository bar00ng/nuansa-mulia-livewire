<?php

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('List Vendor')]

class ListVendor extends Component
{
    #[On('vendor-deleted')]
    public function setMessage($message) {
        if ($message == 'success') {
            flash('Data vendor berhasil dihapus.', $message);
        } else {
            flash('Gagal menghapus data vendor.', $message);
        }
    }

    public function render()
    {
        return view('livewire.vendors.list-vendor');
    }
}
