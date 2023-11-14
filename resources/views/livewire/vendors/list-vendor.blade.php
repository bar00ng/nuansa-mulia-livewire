<div>
    <x-page-header pageName="Vendor" />

    <x-partials.flash />

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="m-0 font-weight-bold text-primary">List Vendor</h4>
                    <a href={{ route('vendor.create') }} class="btn btn-primary" wire:navigate>
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Vendor</span>
                    </a>
                </div>
                <div class="card-body">
                    <livewire:tables.vendor-table />
                </div>
            </div>
        </div>
    </div>
</div>

