<?php

namespace App\Livewire\Tables;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Project;
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

final class ProjectTable extends PowerGridComponent
{
    use WithExport, LivewireAlert;

    public ?string $client_id = null;

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
        $query = Project::query()
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->select(['projects.*', 'clients.nama_client as nama_client']);

        if ($this->client_id) {
            $query->where('client_id', $this->client_id);
        }

        return $query;
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
        ->addColumn('id')
        ->addColumn('kd_project')

       /** Example of custom column using a closure **/
        ->addColumn('kd_project_lower', fn (Project $model) => strtolower(e($model->kd_project)))

        ->addColumn('nama_client')
        ->addColumn('nama_project')
        ->addColumn('pekerjaan')
        ->addColumn('status', function (Project $project) {
            return \App\Enums\ProjectStatus::from($project->status)->labels();
        })
        ->addColumn('created_at_formatted', fn (Project $model) => Carbon::parse($model->created_at)->format('d M Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Kd project', 'kd_project')
                ->sortable()
                ->searchable(),

            Column::make('Nama project', 'nama_project'),
            Column::make('Client', 'nama_client'),

            Column::make('Pekerjaan', 'pekerjaan')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('kd_project')->operators(['contains']),
            Filter::inputText('nama_pic')->operators(['contains']),
            Filter::inputText('nomor_pic')->operators(['contains']),
            Filter::inputText('lokasi')->operators(['contains']),
            Filter::inputText('pekerjaan')->operators(['contains']),
            Filter::enumSelect('status', 'projects.status')
                ->dataSource(\App\Enums\ProjectStatus::cases())
                ->optionLabel('projects.status'),
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($rowId): void {
        $this->confirm('Apa anda yakin ingin menghapus project?', [
            'toast' => false,
            'position' => 'center',
            'onConfirmed' => 'confirmed',
            'data' => [
                'project_id' => $rowId
            ],
        ]);
    }

    #[\Livewire\Attributes\On('confirmed')]
    public function confirmed($data) {
        $projectId = $data['project_id'] ?? null;

        if ($projectId) {
            try {
                DB::beginTransaction();

                $project = \App\Models\Project::find($projectId);

                if($project) {
                    $project->delete();
                    DB::commit();

                    $this->alert('success', 'Project berhasil dihapus.');
                } else {
                    DB::rollBack();
                    Log::error("Tidak ditemukan project dengan ID = $projectId.");

                    $this->alert('warning', "Terjadi kesalahan saat menghapus project");
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error("Throwable\t: $th");

                $this->alert('warning', "Terjadi kesalahan saat menghapus project");
            }
        } else {
            DB::rollBack();
            Log::error("Project ID cannot be null");

            $this->alert('warning', 'Terjadi kesalahan saat menghapus project.');
        }
    }
    public function actions(\App\Models\Project $row): array
    {
        return [
            Button::add('edit')->render(function (\App\Models\Project $project) {
                return Blade::render(
                    <<<HTML
                        <a href="{{ route('project.show', '$project->uuid') }}" class="btn btn-success" wire:navigate>
                            <i class="bi bi-eye-fill"></i>
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
