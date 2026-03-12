<?php

namespace App\Livewire\Web;

use App\Models\Position;
use Livewire\Component;

class Advertisement extends Component
{
    public function render()
    {
        $advertisements = Position::find(5)->advertisements;
        return view('livewire.web.advertisement',compact('advertisements'));
    }
}
