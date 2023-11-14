<?php

namespace App\Livewire\Project;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('List Project')]

class ListProject extends Component
{
    #[On('project-deleted')]
    public function setMessage($message) {
        if ($message == 'success') {
            flash('Data project berhasil dihapus.', $message);
        } else {
            flash('Gagal menghapus data project.', $message);
        }
    }

    public function render()
    {
        return view('livewire.project.list-project');
    }
}
