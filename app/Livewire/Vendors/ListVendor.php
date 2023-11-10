<?php

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('List Vendor')]

class ListVendor extends Component
{
    public function render()
    {
        return view('livewire.vendors.list-vendor');
    }

    public function destroy($vendorId)
    {
        try {
            DB::beginTransaction();

            Vendor::find($vendorId)
                ->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
        } catch (QueryException $ex) {
            DB::rollBack();
            Log::error($ex);
        }
    }
}
