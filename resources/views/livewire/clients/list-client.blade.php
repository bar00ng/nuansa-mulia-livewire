<div>
    <x-page-header pageName="Client" />

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">List Client</h6>
                    <a href={{ route('client.create') }} class="btn btn-sm btn-primary" wire:navigate>
                        <i class="fas fa-fw fa-plus"></i>
                        <span>Client</span>
                    </a>
                </div>
                <div class="card-body">
                    @livewire('client-table')
                </div>
            </div>
        </div>
    </div>
</div>
