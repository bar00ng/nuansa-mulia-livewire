<div>
    <x-page-header pageName="Project" />

    <x-partials.flash />

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="m-0 font-weight-bold text-primary">List Project</h4>
                    <a href={{ route('project.create') }} class="btn btn-primary" wire:navigate>
                        <i class="bi bi-clipboard2-plus-fill"></i>
                        <span>Project</span>
                    </a>
                </div>
                <div class="card-body">
                    <livewire:tables.project-table />
                </div>
            </div>
        </div>
    </div>
</div>
