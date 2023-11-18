<div>
    <x-page-header pageName="Client" />

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="m-0 font-weight-bold text-primary">List Client</h4>
                    <a href={{ route('client.create') }} class="btn btn-primary" wire:navigate>
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Client</span>
                    </a>
                </div>
                <div class="card-body">
                    <livewire:tables.client-table />
                </div>
            </div>
        </div>
    </div>
</div>
