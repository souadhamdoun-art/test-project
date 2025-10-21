@foreach ($courses as $course)
    <p>{{ $course->title }}</p>
    <p>{{ $course->description }}</p>
@endforeach

