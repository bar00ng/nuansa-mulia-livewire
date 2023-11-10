<div>
    <x-page-header pageName="Edit Vendor" />

    <x-partials.flash />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit="update">
                        <div class="mb-3">
                            <label for="nama-client" class="form-label">Nama Vendor</label>
                            <input type="text" class="form-control @error('form.nama_vendor') is-invalid @enderror"
                                id="nama-client" wire:model="form.nama_vendor" placeholder="Company">
                            @error('form.nama_vendor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">
                            Submit
                            <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                        </button>
                        <a href="{{ route('vendor.index') }}" role="button" class="btn btn-danger" wire:navigate>
                            Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
