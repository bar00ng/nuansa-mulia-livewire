<div>
    <x-page-header pageName="{{ $project->nama_project }} - Dashboard" />

    {{-- Project Info --}}
    <div class="row">
        <div class="col">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <dl class="row gap-3">
                                <dt class="col-sm-4">Kode Project</dt>
                                <dd class="col-sm-6">
                                    {{ $project->kd_project }}
                                </dd>

                                <dt class="col-sm-4">Nama Project</dt>
                                <dd class="col-sm-6">
                                    {{ $project->nama_project }}
                                </dd>

                                <dt class="col-sm-4">Lokasi</dt>
                                <dd class="col-sm-6">
                                    {{ $project->lokasi }}
                                </dd>

                                <dt class="col-sm-4">Pekerjaan</dt>
                                <dd class="col-sm-6">
                                    {{ $project->pekerjaan }}
                                </dd>

                                <dt class="col-sm-4">Status</dt>
                                <dd class="col-sm-6">
                                    {{ $project->status }}
                                </dd>

                                <dt class="col-sm-4">Budget RAB</dt>
                                <dd class="col-sm-6">
                                    {{ $project->budget_rab ?? 'Rp ' . number_format(0) }}
                                </dd>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <dl class="row gap-3">
                                <dt class="col-sm-4">Client</dt>
                                <dd class="col-sm-6">
                                    {{ $project->client->nama_client }}
                                </dd>

                                <dt class="col-sm-4">PIC Project</dt>
                                <dd class="col-sm-6">
                                    {{ $project->nama_pic }}
                                </dd>

                                <dt class="col-sm-4">Nomor Telepon PIC</dt>
                                <dd class="col-sm-6">
                                    {{ $project->nomor_pic }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Job Detail Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow-lg">
                <div
                    class="card-header py-3 d-flex flex-row flex-md-row flex-sm-column align-items-md-center align-items-sm-start gap-2 justify-content-md-between">
                    <h4 class="m-0 font-weight-bold text-primary">Job Details</h4>
                    <button class="btn btn-warning" type="button" wire:click="addRow" {{ $job_details ? '' : 'disabled' }}
                        >
                        <i class="bi bi-floppy-fill"></i>
                        Save Changes
                    </button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Ukuran</th>
                                <th>Keterangan</th>
                                <th>Harga Penawaran</th>
                                <th></th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @foreach ($project->job_details as $detail)
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        {{ $detail->nama_job }}
                                    </td>
                                    <td>
                                        {{ $detail->ukuran_job }}
                                    </td>
                                    <td>
                                        {{ $detail->keterangan_job }}
                                    </td>
                                    <td>
                                        {{ number_format($detail->harga_penawaran_job) }}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button"
                                            wire:click="deleteJobDetail({{ $detail->id }})" disabled>
                                            <i class="bi bi-node-minus-fill"></i>
                                        </button>
                                    </td>
                            @endforeach
                            @if ($job_details)
                                @foreach ($job_details as $index => $job_detail)
                                    <tr>
                                        <td>
                                            {{ $no++ }}
                                        </td>
                                        <td>
                                            <input type="text" wire:model='job_details.{{ $index }}.item'
                                                placeholder="Item"
                                                class="form-control @error('job_details.' . $index . '.item') is-invalid @enderror">
                                            @error('job_details.' . $index . '.item')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" wire:model='job_details.{{ $index }}.ukuran'
                                                class="form-control @error('job_details.' . $index . '.ukuran') is-invalid @enderror"
                                                placeholder="0x0, p=0cm, l=0cm">
                                            @error('job_details.' . $index . '.ukuran')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text"
                                                wire:model='job_details.{{ $index }}.keterangan'
                                                class="form-control @error('job_details.' . $index . '.keterangan') is-invalid @enderror"
                                                placeholder="Keterangan Item">
                                            @error('job_details.' . $index . '.keterangan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-text">Rp</div>
                                                <input type="text"
                                                    wire:model='job_details.{{ $index }}.harga_penawaran'
                                                    class="form-control @error('job_details.' . $index . '.harga_penawaran') is-invalid @enderror"
                                                    placeholder="00.00">
                                                @error('job_details.' . $index . '.harga_penawaran')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" type="button"
                                                wire:click='removeJobDetail({{ $index }})'>
                                                <i class="bi bi-node-minus-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="6">
                                    <button class="btn w-100 btn-success" wire:click="addJobDetail">
                                        <i class="bi bi-node-plus-fill"></i>
                                        Tambah Job Detail
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- RAB Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow-lg">
                <div class="card-header py-3 d-flex flex-row align-items-center">
                    <h4 class="m-0 font-weight-bold text-primary">RAB Items</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>...</th>
                                <th>...</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($project->job_details as $job_detail)
                                <tr>
                                    <td>
                                        {{ $job_detail->nama_job }}
                                    </td>
                                    @foreach ($job_detail->vendors as $vendor)
                                        <td>
                                            @if ($vendor->pivot->rab_item_id)
                                                <a href="{{ route('project.rab', ['job_detail' => '$job_detail->uuid'])}}">
                                                    <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('project.rab', ['job_detail' => $job_detail->uuid])}}" wire:navigate>
                                                    <i class="bi bi-x-circle-fill fs-3 text-danger"></i>
                                                </a>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>