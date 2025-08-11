<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Player extends Component
{
    public Lesson $lesson;
    public int $lastValid = 0;

    public function mount(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function render()
    {
        return view('livewire.player');
    }
}


