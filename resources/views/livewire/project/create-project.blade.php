<div>
    <x-page-header pageName="Tambah Project" />

    <x-partials.flash />

    <form wire:submit="onSave">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card shadow-lg">
                    <div class="card-header py-3 d-flex flex-row align-items-center">
                        <h4 class="m-0 font-weight-bold text-primary">Project Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kode-project" class="form-label">Kode Project</label>
                            <input type="text" id="kode-project"
                                class="form-control @error('form.kd_project') is-invalid @enderror"
                                wire:model="form.kd_project" readonly>
                            @error('form.kd_project')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div id="kode-project-help" class="form-text">Auto generated setelah pilih client</div>
                        </div>

                        <div class="mb-3">
                            <label for="nama-project" class="form-label">Nama Project</label>
                            <input type="text" id="nama-project"
                                class="form-control @error('form.nama_project') is-invalid @enderror"
                                wire:model="form.nama_project" placeholder="Project X">
                            @error('form.nama_project')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lokasi-project" class="form-label">Lokasi</label>
                            <textarea wire:model="form.lokasi" id="lokasi-project" class="form-control @error('form.lokasi') is-invalid @enderror"
                                placeholder="Jl. Kemakmuran"></textarea>
                            @error('form.lokasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pekerjaan-project" class="form-label">Pekerjaan</label>
                            <input type="text" id="pekerjaan-project"
                                class="form-control @error('form.pekerjaan') is-invalid @enderror"
                                wire:model="form.pekerjaan" placeholder="Signage">
                            @error('form.pekerjaan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="card shadow-lg">
                    <div class="card-header py-3 d-flex flex-row align-items-center">
                        <h4 class="m-0 font-weight-bold text-primary">Client Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="client-project" class="form-label">Client</label>
                            <select wire:model="form.client_id" id="client-project"
                                class="form-control @error('form.client_id') is-invalid @enderror"
                                wire:change="generateKodeProject">
                                <option value="">-- PILIH CLIENT</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nama_client }}</option>
                                @endforeach
                            </select>
                            @error('form.client_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pic-client" class="form-label">PIC Project</label>
                            <input type="text" class="form-control @error('form.nama_pic') is-invalid @enderror"
                                id="pic" wire:model="form.nama_pic" placeholder="John Doe">
                            @error('form.nama_pic')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pic-client" class="form-label">Nomor Telepon Client</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="number" class="form-control @error('form.nomor_pic') is-invalid @enderror"
                                    id="pic" wire:model="form.nomor_pic" placeholder="000-000-000">
                                @error('form.nomor_pic')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-lg">
                    <div
                        class="card-header py-3 d-flex flex-row flex-md-row flex-sm-column align-items-md-center align-items-sm-start gap-2 justify-content-md-between">
                        <h4 class="m-0 font-weight-bold text-primary">Job Details</h4>
                        <button class="btn btn-success" type="button" wire:click="addRow">
                            <i class="bi bi-node-plus-fill"></i>
                            Add Row
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Ukuran</th>
                                    <th>Keterangan</th>
                                    <th>Harga Penawaran</th>
                                    <th></th>
                                </tr>
                            </thead>

                            @if (count($form->job_details) < 1)
                                <tbody>
                                    <tr>
                                        <td class="text-center fst-italic" colspan="10">Detail Pekerjaan Kosong</td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    @foreach ($form->job_details as $index => $job_detail)
                                        <tr>
                                            <td>
                                                <input type="text"
                                                    wire:model='form.job_details.{{ $index }}.item'
                                                    placeholder="Item"
                                                    class="form-control @error('form.job_details.' . $index . '.item') is-invalid @enderror">
                                                @error('form.job_details.' . $index . '.item')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                    wire:model='form.job_details.{{ $index }}.ukuran'
                                                    class="form-control @error('form.job_details.' . $index . '.ukuran') is-invalid @enderror"
                                                    placeholder="0x0, p=0cm, l=0cm">
                                                @error('form.job_details.' . $index . '.ukuran')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text"
                                                    wire:model='form.job_details.{{ $index }}.keterangan'
                                                    class="form-control @error('form.job_details.' . $index . '.keterangan') is-invalid @enderror"
                                                    placeholder="Keterangan Item">
                                                @error('form.job_details.' . $index . '.keterangan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-text">Rp</div>
                                                    <input type="text"
                                                        wire:model='form.job_details.{{ $index }}.harga_penawaran'
                                                        class="form-control @error('form.job_details.' . $index . '.harga_penawaran') is-invalid @enderror"
                                                        placeholder="00.00">
                                                    @error('form.job_details.' . $index . '.harga_penawaran')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" type="button"
                                                    wire:click='removeRow({{ $index }})' {{ count($form->job_details) <= 1 ? 'disabled' : ''}}>
                                                    <i class="bi bi-node-minus-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <div class="col">
                <button class="btn btn-primary" type="submit">
                    Submit
                    <span class="spinner-border spinner-border-sm" aria-hidden="true" wire:loading></span>
                </button>
                <a href="{{ route('project.index') }}" role="button" class="btn btn-danger" wire:navigate>
                    Back
                </a>
            </div>
        </div>
    </form>
</div>
