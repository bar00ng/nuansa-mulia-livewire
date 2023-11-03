<?php

namespace App\Livewire;

use App\Models\Client;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
    use WithExport;
    use LivewireAlert;

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

           /** Example of custom column using a closure **/
            ->addColumn('kd_client_lower', fn (Client $model) => strtolower(e($model->kd_client)))

            ->addColumn('nama_client')
            ->addColumn('alamat_client')
            ->addColumn('nomor_telepon_client')
            ->addColumn('created_at_formatted', fn (Client $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Kd client', 'kd_client')
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
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    #[\Livewire\Attributes\On('delete')]
    public function destroy($rowId)
    {
        $this->alert('question', 'Apa kamu yakin ingin menghapus data client?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Ya',
            'onConfirmed' => 'confirmed',
            'showDenyButton' => true,
            'denyButtonText' => 'Tidak',
        ]);
    }

    public function getListeners(){
        return [
            'confirmed',
            'denied'
        ];
    }

    public function confirmed($data) {
        // $this->alert('success', $data);
        dd($data);
    }

    public function actions(\App\Models\Client $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id]),
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