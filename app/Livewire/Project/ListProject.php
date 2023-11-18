<?php

namespace App\Livewire\Project;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('List Project')]

class ListProject extends Component
{
    public function render()
    {
        return view('livewire.project.list-project');
    }
}
