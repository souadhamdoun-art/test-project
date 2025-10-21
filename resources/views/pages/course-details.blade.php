<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }}</title>
</head>
<body>
    <h1>{{ $course->title }}</h1>
    <p>{{ $course->description }}</p>
    <p>{{ $course->videos_count }} videos</p>

    @if($course->released_at)
        <p>Released: {{ $course->released_at->format('Y-m-d') }}</p>
    @endif

    @if($course->image_name)
        <img src="{{ asset("images/{$course->image_name}") }}" alt="{{ $course->title }}">
    @endif

    @if($course->tagline)
        <p>{{ $course->tagline }}</p>
    @endif

    @if($course->learnings)
        <ul>
            @foreach($course->learnings as $learning)
                <li>{{ $learning }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>
