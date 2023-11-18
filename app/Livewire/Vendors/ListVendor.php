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
    public function render()
    {
        return view('livewire.vendors.list-vendor');
    }
}
