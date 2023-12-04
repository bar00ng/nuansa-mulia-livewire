<div>
    <x-page-header pageName="{{ $project->nama_project }} - Dashboard" />

    <div class="row">
        <div class="col">
            <div class="card shadow-lg">
                <div class="card-body">
                    <x-tab :projectId="$project->id" />
                </div>
            </div>
        </div>
    </div>

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
                                    {{ \App\Enums\ProjectStatus::from($project->status)->labels() }}
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

    <div class="row">

        <style>
            .card {
                height: 300px;
            }

            .list-group-item {
                overflow-y: auto;
                max-height: 200px;
            }

            .list-group-item-divider {
                border-bottom: 1px solid #dee2e6;
                padding-bottom: 5px;
                margin-bottom: 5px;
            }

            .card-footer {
                position: absolute;
                bottom: 0;
                width: 100%;
            }
        </style>

        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    Todo
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($todos as $todo)
                        @if ($todo->status === 'todo')
                            <li class="list-group-item">

                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $todo->title }}</span>
                                    <div>
                                        <a href="{{ route('project.todo', $todo->project_id) }}"
                                            class="btn btn-primary btn-sm mr-2">
                                            Edit
                                        </a>
                                        <button class="btn btn-danger btn-sm">
                                            &times;
                                        </button>
                                    </div>
                                </div>
                                <div class="list-group-item-divider"></div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="card-footer card-footer-bottom">
                    <button class="btn btn-primary btn-sm ">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    Progress
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($todos as $todo)
                        @if ($todo->status === 'progress')
                            <li class="list-group-item">
                                <div class="list-group-item-divider"></div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $todo->title }}</span>
                                    <div>
                                        <a href="{{ route('project.todo', $todo->project_id) }}"
                                            class="btn btn-warning btn-sm mr-2">
                                            Edit
                                        </a>
                                        <button class="btn btn-danger btn-sm">
                                            &times;
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="card-footer card-footer-bottom">
                    <button class="btn btn-warning btn-sm add-button">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    Completed
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($todos as $todo)
                        @if ($todo->status === 'progress')
                            <li class="list-group-item">
                                <div class="list-group-item-divider"></div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $todo->title }}</span>
                                    <div>
                                        <a href="{{ route('project.todo', $todo->project_id) }}"
                                            class="btn btn-success btn-sm mr-2">
                                            Edit
                                        </a>
                                        <button class="btn btn-danger btn-sm">
                                            &times;
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="card-footer card-footer-bottom">
                    <button class="btn btn-success btn-sm add-button">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>



    </div>

    {{-- Job Detail Table --}}
    <form wire:submit="updateJobDetail">
        <div class="row">
            <div class="col">
                <div class="card shadow-lg">
                    <div
                        class="card-header py-3 d-flex flex-row flex-md-row flex-sm-column align-items-md-center align-items-sm-start gap-2 justify-content-md-between">
                        <h4 class="m-0 font-weight-bold text-primary">Job Details</h4>
                        <button class="btn btn-warning" type="button" wire:click="updateJobDetails"
                            {{ $jobDetailForm->job_details ? '' : 'disabled' }}>
                            <i class="bi bi-floppy-fill"></i>
                            Save Changes
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                    @foreach ($job_details as $detail)
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
                                                    wire:click="deleteJobDetail({{ $detail->id }})">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </td>
                                    @endforeach
                                    @if ($jobDetailForm->job_details)
                                        @foreach ($jobDetailForm->job_details as $index => $job_detail)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        wire:model='jobDetailForm.job_details.{{ $index }}.item'
                                                        placeholder="Item"
                                                        class="form-control @error('jobDetailForm.job_details.' . $index . '.item') is-invalid @enderror">
                                                    @error('jobDetailForm.job_details.' . $index . '.item')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        wire:model='jobDetailForm.job_details.{{ $index }}.ukuran'
                                                        class="form-control @error('jobDetailForm.job_details.' . $index . '.ukuran') is-invalid @enderror"
                                                        placeholder="0x0, p=0cm, l=0cm">
                                                    @error('jobDetailForm.job_details.' . $index . '.ukuran')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        wire:model='jobDetailForm.job_details.{{ $index }}.keterangan'
                                                        class="form-control @error('jobDetailForm.job_details.' . $index . '.keterangan') is-invalid @enderror"
                                                        placeholder="Keterangan Item">
                                                    @error('jobDetailForm.job_details.' . $index . '.keterangan')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-text">Rp</div>
                                                        <input type="text"
                                                            wire:model='jobDetailForm.job_details.{{ $index }}.harga_penawaran'
                                                            class="form-control @error('jobDetailForm.job_details.' . $index . '.harga_penawaran') is-invalid @enderror"
                                                            placeholder="00.00">
                                                        @error('jobDetailForm.job_details.' . $index .
                                                            '.harga_penawaran')
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
                                            <button class="btn w-100 btn-success" type="button"
                                                wire:click="addJobDetail">
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
        </div>
    </form>

    {{-- RAB Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow-lg">
                <div class="card-header py-3 d-flex flex-row align-items-center">
                    <h4 class="m-0 font-weight-bold text-primary">RAB Items</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    @foreach ($vendor_attached as $vendor)
                                        <th>{{ $vendor->nama_vendor }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($job_details as $job_detail)
                                    <tr>
                                        <td>
                                            {{ $job_detail->nama_job }}
                                        </td>
                                        @foreach ($job_detail->vendors as $vendor)
                                            <td>
                                                @if ($vendor->pivot->rab_item_id)
                                                    <a href="{{ route('project.rab', ['job_detail' => $job_detail->id, 'vendor' => $vendor->id, 'readonly' => true]) }}"
                                                        wire:navigate>
                                                        <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('project.rab', ['job_detail' => $job_detail->id, 'vendor' => $vendor->id]) }}"
                                                        wire:navigate>
                                                        <i class="bi bi-x-circle-fill fs-3 text-danger"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>

                            {{-- Akan Muncul ketika $isRabFilled jadi true --}}
                            @if ($isRabFilled)
                                <tfoot>
                                    <tr>
                                        <th>
                                            &nbsp;
                                        </th>
                                        @foreach ($vendor_attached as $vendor)
                                            <td>
                                                <a href="{{ route('report', ['project' => $project->id, 'vendor' => $vendor->id]) }}"
                                                    class="text-success link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
                                                    <i class="bi bi-download"></i>
                                                    Report
                                                </a>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow-lg">
                <div class="card-header py-3 d-flex flex-row align-items-center">
                    <h4 class="m-0 font-weight-bold text-primary">Summary RAB</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    @foreach ($vendor_attached as $vendor)
                                        <th colspan="3">{{ $vendor->nama_vendor }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>
                                        &nbsp;
                                    </th>
                                    @foreach ($vendor_attached as $vendor)
                                        <th>RAB</th>
                                        <th>Profit</th>
                                        <th>%</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($job_details as $job_detail)
                                    <tr>
                                        <td>
                                            {{ $job_detail->nama_job }}
                                        </td>
                                        @foreach ($job_detail->vendors as $vendor)
                                            @php
                                                $grandTotal = $vendor->pivot->rab_item->grand_total ?? 0;
                                                $profit = $job_detail->harga_penawaran_job - $grandTotal;
                                                $percent = ($job_detail->harga_penawaran_job - $grandTotal) / $job_detail->harga_penawaran_job;
                                            @endphp
                                            <td>
                                                {{ number_format($grandTotal) }}
                                            </td>
                                            <td
                                                class="@if ($profit > 0) text-success
                                            @else
                                                text-danger @endif">
                                                {{ number_format($profit) }}
                                            </td>
                                            <td
                                                class="@if ($percent > 0) text-success
                                                @else
                                                    text-danger @endif">
                                                {{ number_format($percent) . '%' }}
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

    @if ($isRabFilled)
        <div class="row">
            <div class="col">
                <div class="card shadow-lg">
                    <div class="card-header py-3 d-flex flex-row align-items-center">
                        <h4 class="m-0 font-weight-bold text-primary">Alokasi Vendor</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form wire:submit="alocateVendor">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Vendor</th>
                                            <th>RAB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($job_details as $job_detail)
                                            <tr>
                                                <td>
                                                    {{ $job_detail->nama_job }}
                                                </td>
                                                <td>
                                                    @if ($job_detail->vendor_id)
                                                        {{ $job_detail->selectedVendor->nama_vendor }}
                                                    @else
                                                        <div class="input-group">
                                                            <select
                                                                class="form-control @error('vendorAlocationForm.alokasi_vendor.' . $job_detail->id . '.vendor') is-invalid @enderror"
                                                                wire:model.live="vendorAlocationForm.alokasi_vendor.{{ $job_detail->id }}.vendor">
                                                                <option value="">-- PILIH VENDOR --</option>
                                                                @foreach ($vendor_attached as $vendor)
                                                                    <option value="{{ $vendor->id }}">
                                                                        {{ $vendor->nama_vendor }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('vendorAlocationForm.alokasi_vendor.' .
                                                                $job_detail->id . '.vendor')
                                                                <div class="invalid-feedback text-start">
                                                                    {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- TODO: Tampilkan RAB dari vendor yang terpilih -->
                                                    -
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if (!$project->job_details->first()->selectedVendor)
                                            <tr>
                                                <td colspan="6">
                                                    <button class="btn w-100 btn-success" type="submit">
                                                        <i class="bi bi-node-plus-fill"></i>
                                                        Simpan Data
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
