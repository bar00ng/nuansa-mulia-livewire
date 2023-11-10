<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('List Client')]

class ListClient extends Component
{
    public function render()
    {
        return view('livewire.clients.list-client');
    }

    public function destroy($clientId)
    {
        try {
            DB::beginTransaction();

            Client::find($clientId)
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
