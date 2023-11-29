<?php

namespace App\Livewire\Project\Cashflows;

use Livewire\Component;

class ListCashflow extends Component
{
    public \App\Models\Project $project;

    public function render()
    {
        return view('livewire.project.cashflows.list-cashflow');
    }
}
