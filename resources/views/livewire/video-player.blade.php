<div>
    {{-- Video Player Component --}}
    <div class="video-player">
        <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}"></iframe>
        <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
        <p>{{ $video->description }}</p>
    </div>
    <ul>
        @foreach ($courseVideos as $courseVideo)
            @if($this->isCurrentVideo($courseVideo))
                <li>{{ $courseVideo->title }}</li>
            @else
                <a href="{{ route('pages.course-videos',[$courseVideo->course,$courseVideo]) }}">
                    {{ $courseVideo->title }}
                </a>
            @endif
        @endforeach
    </ul>
</div>
