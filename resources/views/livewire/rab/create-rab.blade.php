<div>
    <x-page-header pageName="{{ $job_detail->nama_job }} - RAB Form" />

    <div class="row">
        <div class="col">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="table-responsive">
                        <form wire:submit="onSave">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Satuan</th>
                                        <th>Quantity</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {{-- Material Section --}}
                                    @foreach ($form->materials as $index => $material)
                                        <tr>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" placeholder="Plat Baja"
                                                        wire:model="form.materials.{{ $index }}.item"
                                                        class="form-control  @error('form.materials.' . $index . '.item') is-invalid @enderror">
                                                    @error('form.materials.' . $index . '.item')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" placeholder="Cm"
                                                        wire:model="form.materials.{{ $index }}.satuan"
                                                        class="form-control @error('form.materials.' . $index . '.satuan')
                                                            is-invalid
                                                        @enderror">
                                                    @error('form.materials.' . $index . '.satuan')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" placeholder="0"
                                                        wire:model="form.materials.{{ $index }}.quantity"
                                                        class="form-control @error('form.materials.' . $index . '.quantity') is-invalid @enderror">
                                                    @error('form.materials.' . $index . '.quantity')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-text">Rp</div>
                                                    <input type="text"
                                                        wire:model='form.materials.{{ $index }}.harga_satuan'
                                                        class="form-control @error('form.materials.' . $index . '.harga_satuan') is-invalid @enderror"
                                                        placeholder="00.00">
                                                    @error('form.materials.' . $index . '.harga_satuan')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>

                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-text">Rp</div>
                                                    <input type="text"
                                                        wire:model='form.materials.{{ $index }}.total'
                                                        class="form-control @error('form.materials.' . $index . '.total') is-invalid @enderror"
                                                        placeholder="00.00" readonly>
                                                    @error('form.materials.' . $index . '.total')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>

                                            <td>
                                                <button class="btn btn-danger" type="button"
                                                    {{ count($form->materials) <= 1 ? 'disabled' : '' }}
                                                    wire:click="removeMaterial({{ $index }})">
                                                    <i class="bi bi-node-minus-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7">
                                            <button class="btn w-100 btn-success" wire:click="addMaterial"
                                                type="button">
                                                <i class="bi bi-node-plus-fill"></i>
                                                Tambah Material
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Production Cost Section --}}
                                    <tr>
                                        <td class="text-start">
                                            Ongkos Produksi
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" wire:model="form.ongkos_produksi_satuan" placeholder="ls"
                                                    class="form-control @error('form.ongkos_produksi_satuan') is-invalid @enderror">
                                                @error('form.ongkos_produksi_satuan')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" wire:model="form.ongkos_produksi_quantity" placeholder="0"
                                                    class="form-control @error('form.ongkos_produksi_quantity') is-invalid @enderror">
                                                @error('form.ongkos_produksi_quantity')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="number" wire:model="form.ongkos_produksi_harga_satuan" placeholder="0.00"
                                                    class="form-control @error('form.ongkos_produksi_harga_satuan') is-invalid @enderror">
                                                @error('form.ongkos_produksi_harga_satuan')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="number" wire:model="form.ongkos_produksi_total" placeholder="0.00"
                                                    class="form-control @error('form.ongkos_produksi_total') is-invalid @enderror">
                                                @error('form.ongkos_produksi_total')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Other Cost Section --}}
                                    <tr>
                                        <td class="text-start">
                                            Transport, Koordinasi, Alat bantu dll
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" wire:model="form.other_cost_satuan" placeholder="ls"
                                                    class="form-control @error('form.other_cost_satuan') is-invalid @enderror">
                                                @error('form.other_cost_satuan')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" wire:model="form.other_cost_quantity" placeholder="0"
                                                    class="form-control @error('form.other_cost_quantity') is-invalid @enderror">
                                                @error('form.other_cost_quantity')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="number" wire:model="form.other_cost_harga_satuan" placeholder="0.00"
                                                    class="form-control @error('form.other_cost_harga_satuan') is-invalid @enderror">
                                                @error('form.other_cost_harga_satuan')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="number" wire:model="form.other_cost_total" placeholder="0.00"
                                                    class="form-control @error('form.other_cost_total') is-invalid @enderror">
                                                @error('form.other_cost_total')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Subtottal Material Section --}}
                                    <tr>
                                        <td class="text-start" colspan="2">
                                            Subtotal Material
                                        </td>
                                        <td colspan="4">
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="text" wire:model="form.subtotal_material" placeholder="0.00"
                                                    class="form-control @error('form.subtotal_material') is-invalid @enderror">
                                                @error('form.subtotal_material')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Subtottal Material Section --}}
                                    <tr>
                                        <td class="text-start" colspan="2">
                                            Subtotal Ongkos Kerja
                                        </td>
                                        <td colspan="4">
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="text" wire:model="form.subtotal_ongkos_kerja" placeholder="0.00"
                                                    class="form-control @error('form.subtotal_ongkos_kerja') is-invalid @enderror">
                                                @error('form.subtotal_ongkos_kerja')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Total Section --}}
                                    <tr>
                                        <td class="text-start" colspan="2">
                                            Total
                                        </td>
                                        <td colspan="4">
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="text" wire:model="form.total" placeholder="0.00"
                                                    class="form-control @error('form.total') is-invalid @enderror">
                                                @error('form.total')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Total Section --}}
                                    <tr>
                                        <td class="text-start" colspan="2">
                                            Lain- lain
                                        </td>
                                        <td colspan="2">
                                            <div class="input-group">
                                                <input type="text" wire:model="form.total" placeholder="0.00"
                                                class="form-control @error('form.total') is-invalid @enderror">
                                                @error('form.total')
                                                <div class="invalid-feedback text-start">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                <div class="input-group-text">%</div>
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="text" wire:model="form.total" placeholder="0.00"
                                                    class="form-control @error('form.total') is-invalid @enderror">
                                                @error('form.total')
                                                    <div class="invalid-feedback text-start">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <button class="btn w-100 btn-primary" type="submit">
                                                Submit
                                                <span class="spinner-border spinner-border-sm" aria-hidden="true"
                                                    wire:loading></span>
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
