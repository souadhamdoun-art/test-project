<?php

namespace App\Livewire;

use App\Models\Video;
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
        auth()->user()->watchedVideos()->attach($this->video);
    }

    public function markVideoAsNotCompleted(): void
    {
        auth()->user()->watchedVideos()->detach($this->video);
    }


    public function isCurrentVideo(Video $videoToCheck): bool
    {
        return $this->video->is($videoToCheck);
    }
}

