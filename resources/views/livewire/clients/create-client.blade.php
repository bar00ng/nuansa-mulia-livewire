<div>
    <x-page-header pageName="Tambah Client" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit="storeData">
                        <div class="mb-3">
                            <label for="nama-client" class="form-label">Nama Client</label>
                            <input type="text" class="form-control @error('form.nama_client') is-invalid @enderror"
                                id="nama-client" wire:model="form.nama_client" placeholder="Company">
                            @error('form.nama_client')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kd-client" class="form-label">Kode Client</label>
                            <input type="text" class="form-control @error('form.kd_client') is-invalid @enderror"
                                id="kd-client" wire:model="form.kd_client" placeholder="CPNY">
                            @error('form.kd_client')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamat-client" class="form-label">Alamat Client</label>
                            <textarea wire:model="form.alamat_client" id="alamat-client"
                                class="form-control @error('form.alamat_client') is-invalid @enderror" placeholder="Jl. Kemakmuran No. 10"></textarea>
                            @error('form.alamat_client')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nomor-telepon-client" class="form-label">Kode Client</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="number"
                                    class="form-control @error('form.nomor_telepon_client') is-invalid @enderror"
                                    id="nomor-telepon-client" wire:model="form.nomor_telepon_client"
                                    placeholder="000-000-000">
                                @error('form.nomor_telepon_client')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">
                            Submit
                            <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                        </button>
                        <a href="{{ route('client.index') }}" role="button" class="btn btn-danger" wire:navigate>
                            Back
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
