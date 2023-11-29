<?php

namespace App\Livewire\Tables;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Client;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class ClientTable extends PowerGridComponent
{
    use WithExport, LivewireAlert;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Client::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('kd_client')

            ->addColumn('nama_client')
            ->addColumn('alamat_client')
            ->addColumn('nomor_telepon_client')
            ->addColumn('created_at_formatted', fn (Client $model) => Carbon::parse($model->created_at)->format('d M Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Kode client', 'kd_client')
                ->sortable()
                ->searchable(),

            Column::make('Nama client', 'nama_client')
                ->sortable()
                ->searchable(),

            Column::make('Alamat client', 'alamat_client')
                ->sortable()
                ->searchable(),

            Column::make('Nomor telepon client', 'nomor_telepon_client')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('kd_client')->operators(['contains']),
            Filter::inputText('nama_client')->operators(['contains']),
            Filter::inputText('nomor_telepon_client')->operators(['contains']),
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void {
        $this->confirm('Apa anda yakin ingin menghapus client?', [
            'toast' => false,
            'position' => 'center',
            'onConfirmed' => 'confirmed',
            'data' => [
                'client_id' => $rowId
            ],
        ]);
    }

    #[\Livewire\Attributes\On('confirmed')]
    public function confirmed($data) {
        $clientId = $data['client_id'] ?? null;

        if ($clientId) {
            try {
                DB::beginTransaction();

                $client = \App\Models\Client::find($clientId);

                if($client) {
                    $client->delete();
                    DB::commit();

                    $this->alert('success', 'Client berhasil dihapus');
                } else {
                    DB::rollBack();
                    Log::error("Tidak ditemukan client dengan ID = $clientId");

                    $this->alert('warning', "Terjadi kesalahan saat menghapus client");
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error("Throwable\t: $th");

                $this->alert('warning', "Terjadi kesalahan saat menghapus client");
            }
        } else {
            DB::rollBack();
            Log::error("Client ID cannot be null");

            $this->alert('warning', 'Terjadi kesalahan saat menghapus client.');
        }
    }

    public function actions(\App\Models\Client $row): array
    {
        return [
            Button::add('edit')->render(function (\App\Models\Client $client) {
                return Blade::render(
                    <<<HTML
                     <a href="{{ route('client.edit', '$client->id') }}" class="btn btn-warning" wire:navigate>
                        <i class="bi bi-pencil-square"></i>
                     </a>
                    HTML
                    ,
                );
            }),
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('delete', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
