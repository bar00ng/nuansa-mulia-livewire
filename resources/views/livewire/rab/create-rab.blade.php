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
                                        <th class="@if ($readonly) d-none @endif">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {{-- Material Section --}}
                                    @foreach ($form->materials as $index => $material)
                                        <tr>
                                            <td>
                                                @if ($readonly)
                                                    {{ $material['item'] }}
                                                @else
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
                                                @endif
                                            </td>
                                            <td>
                                                @if ($readonly)
                                                    {{ $material['satuan'] }}
                                                @else
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
                                                @endif
                                            </td>
                                            <td>
                                                @if ($readonly)
                                                    {{ number_format($material['quantity']) }}
                                                @else
                                                    <div class="input-group">
                                                        <input type="number" placeholder="0"
                                                            wire:model="form.materials.{{ $index }}.quantity"
                                                            class="form-control @error('form.materials.' . $index . '.quantity') is-invalid @enderror"
                                                            wire:kedown="calcMaterialTotal({{ $index }})">
                                                        @error('form.materials.' . $index . '.quantity')
                                                            <div class="invalid-feedback text-start">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($readonly)
                                                    {{ 'Rp. ' . number_format($material['harga_satuan']) }}
                                                @else
                                                    <div class="input-group">
                                                        <div class="input-group-text">Rp.</div>
                                                        <input type="text"
                                                            wire:model='form.materials.{{ $index }}.harga_satuan'
                                                            class="form-control @error('form.materials.' . $index . '.harga_satuan') is-invalid @enderror"
                                                            placeholder="00.00"
                                                            wire:keydown="calcMaterialTotal({{ $index }})">
                                                        @error('form.materials.' . $index . '.harga_satuan')
                                                            <div class="invalid-feedback text-start">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                @endif
                                            </td>

                                            <td class="text-start">
                                                {{ 'Rp. ' . number_format($form->materials[$index]['total']) }}
                                            </td>

                                            <td class="@if ($readonly) d-none @endif">
                                                <button class="btn btn-danger" type="button"
                                                    {{ count($form->materials) <= 1 ? 'disabled' : '' }}
                                                    wire:click="removeMaterial({{ $index }})">
                                                    <i class="bi bi-node-minus-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="@if ($readonly) d-none @endif">
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
                                        <th class="text-start">
                                            Ongkos Produksi
                                        </th>
                                        <td>
                                            @if ($readonly)
                                                {{ $form->production_cost_satuan ?? '-' }}
                                            @else
                                                <div class="input-group">
                                                    <input type="text" wire:model="form.production_cost_satuan"
                                                        placeholder="ls"
                                                        class="form-control @error('form.production_cost_satuan') is-invalid @enderror">
                                                    @error('form.production_cost_satuan')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($readonly)
                                                {{ $form->production_cost_quantity ?? '-' }}
                                            @else
                                                <div class="input-group">
                                                    <input type="number" wire:model="form.production_cost_quantity"
                                                        placeholder="0"
                                                        class="form-control @error('form.production_cost_quantity') is-invalid @enderror"
                                                        wire:keydown="calcProductionCostTotal">
                                                    @error('form.production_cost_quantity')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($readonly)
                                                {{ 'Rp. ' . number_format($form->production_cost_harga_satuan) }}
                                            @else
                                                <div class="input-group">
                                                    <div class="input-group-text">Rp.</div>
                                                    <input type="number" wire:model="form.production_cost_harga_satuan"
                                                        placeholder="0.00"
                                                        class="form-control @error('form.production_cost_harga_satuan') is-invalid @enderror"
                                                        wire:keydown="calcProductionCostTotal">
                                                    @error('form.production_cost_harga_satuan')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </td>
                                        <td colspan="2" class="text-start">
                                            {{ 'Rp. ' . number_format($form->production_cost_total) }}
                                        </td>
                                    </tr>

                                    {{-- Other Cost Section --}}
                                    <tr>
                                        <th class="text-start">
                                            Transport, Koordinasi, Alat bantu dll
                                        </th>
                                        <td>
                                            @if ($readonly)
                                                {{ $form->other_cost_satuan ?? '-' }}
                                            @else
                                                <div class="input-group">
                                                    <input type="text" wire:model="form.other_cost_satuan"
                                                        placeholder="ls"
                                                        class="form-control @error('form.other_cost_satuan') is-invalid @enderror">
                                                    @error('form.other_cost_satuan')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($readonly)
                                                {{ $form->other_cost_quantity ?? '-' }}
                                            @else
                                                <div class="input-group">
                                                    <input type="number" wire:model="form.other_cost_quantity"
                                                        placeholder="0"
                                                        class="form-control @error('form.other_cost_quantity') is-invalid @enderror"
                                                        wire:keydown="calcOtherCostTotal">
                                                    @error('form.other_cost_quantity')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($readonly)
                                                {{ 'Rp. ' . number_format($form->other_cost_harga_satuan) }}
                                            @else
                                                <div class="input-group">
                                                    <div class="input-group-text">Rp.</div>
                                                    <input type="number" wire:model="form.other_cost_harga_satuan"
                                                        placeholder="0.00"
                                                        class="form-control @error('form.other_cost_harga_satuan') is-invalid @enderror"
                                                        wire:keydown="calcOtherCostTotal">
                                                    @error('form.other_cost_harga_satuan')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </td>
                                        <td colspan="2" class="text-start">
                                            {{ 'Rp. ' . number_format($form->other_cost_total) }}
                                        </td>
                                    </tr>

                                    {{-- Subtottal Material Section --}}
                                    <tr>
                                        <td class="text-start" colspan="2">
                                            <div class="d-flex flex-column">
                                                <span>
                                                    <strong>Subtotal Material <span
                                                            class="text-danger">*</span></strong>
                                                </span>
                                                <span class="fst-italic text-sm">
                                                    Sum of Material
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-start" colspan="4">
                                            {{ 'Rp. ' . number_format($form->subtotal_material) }}
                                        </td>
                                    </tr>

                                    {{-- Subtottal Material Section --}}
                                    <tr>
                                        <td class="text-start" colspan="2">
                                            <div class="d-flex flex-column">
                                                <span>
                                                    <strong>Subtotal Ongkos Kerja</strong>
                                                </span>
                                                <span class="fst-italic text-sm">
                                                    Sum of Ongkos Kerja
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-start" colspan="4">
                                            {{ 'Rp. ' . number_format($form->subtotal_other_cost) }}
                                        </td>
                                    </tr>

                                    {{-- Total Section --}}
                                    <tr>
                                        <td class="text-start" colspan="2">
                                            <div class="d-flex flex-column">
                                                <span>
                                                    <strong>Total <span class="text-danger">*</span></strong>
                                                </span>
                                                <span class="fst-italic text-sm">
                                                    (Subtotal Material + Subtotal Ongkos Kerja)
                                                </span>
                                            </div>
                                        </td>
                                        <td colspan="4" class="text-start">
                                            {{ 'Rp. ' . number_format($form->total_biaya) }}
                                        </td>
                                    </tr>

                                    {{-- Lain- lain Section --}}
                                    <tr>
                                        <th class="text-start" colspan="2">
                                            Lain- lain
                                        </th>
                                        <td colspan="2">
                                            @if ($readonly)
                                                {{ $form->lain_lain_percent ?? 0 . '%' }}
                                            @else
                                                <div class="input-group">
                                                    <input type="text" wire:model="form.lain_lain_percent"
                                                        placeholder="0.00"
                                                        class="form-control @error('form.lain_lain_percent') is-invalid @enderror"
                                                        wire:keydown="convertLainLainPercent">
                                                    @error('form.lain_lain_percent')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            @endif
                                        </td>
                                        <td colspan="2" class="text-start">
                                            {{ 'Rp. ' . number_format($form->lain_lain_converted) }}
                                        </td>
                                    </tr>

                                    {{-- Jasa Kontraktor section --}}
                                    <!-- TODO: Converted value belum ter update secara otomatis -->
                                    <tr>
                                        <th class="text-start" colspan="2">
                                            Jasa Kontraktor
                                        </th>
                                        <td colspan="2">
                                            @if ($readonly)
                                                {{ $form->jasa_kontraktor_percent ?? 0 . '%' }}
                                            @else
                                                <div class="input-group">
                                                    <input type="text" wire:model="form.jasa_kontraktor_percent"
                                                        placeholder="0.00"
                                                        class="form-control @error('form.jasa_kontraktor_percent') is-invalid @enderror"
                                                        wire:keydown="convertJasaKontraktoRp.ercent">
                                                    @error('form.jasa_kontraktor_percent')
                                                        <div class="invalid-feedback text-start">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            @endif
                                        </td>
                                        <td colspan="2" class="text-start">
                                            {{ 'Rp. ' . number_format($form->jasa_kontraktor_converted) }}
                                        </td>
                                    </tr>

                                    {{-- Grand Total Section --}}
                                    <tr>
                                        <td class="text-start" colspan="2">
                                            <div class="d-flex flex-column">
                                                <span>
                                                    <strong>Grand Total <span class="text-danger">*</span></strong>
                                                </span>
                                                <span class="fst-italic text-sm">
                                                    (Total + Lain- lain + Jasa Kontraktor)
                                                </span>
                                            </div>
                                        </td>
                                        <td colspan="7" class="text-start">
                                            {{ 'Rp. ' . number_format($form->grand_total) }}
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot class="@if ($readonly) d-none @endif">
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
