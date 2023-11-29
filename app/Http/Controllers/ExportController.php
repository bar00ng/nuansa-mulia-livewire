<?php

namespace App\Http\Controllers;

use App\Exports\RabExport;
use App\Models\Project;
use App\Models\Vendor;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function RabExport(Project $project, Vendor $vendor) {
        $fileName = 'RAB_' . $project->nama_project . '_' . $vendor->nama_vendor . '_' . Carbon::now()->timestamp . '.xlsx';

        return Excel::download(new RabExport($project->id, $vendor->id), $fileName);
    }
}
