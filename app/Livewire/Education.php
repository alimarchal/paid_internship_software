<?php

namespace App\Livewire;

use Livewire\Component;

class Education extends Component
{

    public $name;

    public function render()
    {
        return view('livewire.education');
    }

    public function updatedName($value)
    {
        dd('update');
        // Debugging: Log or perform an action when 'name' is updated
        logger('Name updated to: ' . $value);
    }
}
