<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class VideoPlayer extends Component
{
    public $video;
    public $courseVideos;
    public function mount($video)
    {
        $this->video = $video;
        $this->courseVideos = $video->course->videos;
    }
    public function render() : View
    {
        return view('livewire.video-player');
    }

    public function markVideoAsCompleted(): void
    {
        auth()->user()->videos()->attach($this->video);
    }

    public function markVideoAsNotCompleted(): void
    {
        auth()->user()->videos()->detach($this->video);
    }
}

