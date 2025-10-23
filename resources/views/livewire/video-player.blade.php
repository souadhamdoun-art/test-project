<div>
    {{-- Video Player Component --}}
    <div class="video-player">
        <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}"></iframe>
        <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
        <p>{{ $video->description }}</p>
    </div>
    <ul>
        @foreach ($courseVideos as $courseVideo)
        <a href="{{ route('pages.course-videos',$courseVideo) }}">
            <li>{{ $courseVideo->title }}</li>
        </a>
        @endforeach
    </ul>
</div>
