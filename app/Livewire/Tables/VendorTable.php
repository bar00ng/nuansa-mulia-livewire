<?php

namespace App\Livewire\Tables;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Vendor;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

final class VendorTable extends PowerGridComponent
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
        return Vendor::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('nama_vendor')

           /** Example of custom column using a closure **/
            ->addColumn('nama_vendor_lower', fn (Vendor $model) => strtolower(e($model->nama_vendor)))

            ->addColumn('created_at_formatted', fn (Vendor $model) => Carbon::parse($model->created_at)->format('d M Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
            ->sortable()
            ->searchable(),

        Column::make('Nama vendor', 'nama_vendor')
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
            Filter::inputText('id')->operators(['contains']),
            Filter::inputText('nama_vendor')->operators(['contains']),
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void {
        $this->confirm('Apa anda yakin ingin menghapus vendor?', [
            'toast' => false,
            'position' => 'center',
            'onConfirmed' => 'confirmed',
            'data' => [
                'vendor_id' => $rowId
            ],
        ]);
    }

    #[\Livewire\Attributes\On('confirmed')]
    public function confirmed($data) {
        $vendorId = $data['vendor_id'] ?? null;

        if ($vendorId) {
            try {
                DB::beginTransaction();

                $vendor = \App\Models\Vendor::find($vendorId);

                if($vendor) {
                    $vendor->delete();
                    DB::commit();

                    $this->alert('success', 'Vendor berhasil dihapus.');
                } else {
                    DB::rollBack();
                    Log::error("Tidak ditemukan vendor dengan ID = $vendorId.");

                    $this->alert('warning', "Terjadi kesalahan saat menghapus vendor");
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error("Throwable\t: $th");

                $this->alert('warning', "Terjadi kesalahan saat menghapus vendor");
            }
        } else {
            DB::rollBack();
            Log::error("Project ID cannot be null");

            $this->alert('warning', 'Terjadi kesalahan saat menghapus project.');
        }
    }

    public function actions(\App\Models\Vendor $row): array
    {
        return [
            Button::add('edit')->render(function (\App\Models\Vendor $vendor) {
                return Blade::render(
                    <<<HTML
                        <a href="{{ route('vendor.edit', '$vendor->uuid') }}" class="btn btn-warning" wire:navigate>Edit</a>
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
