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
    <p>Released: {{ $course->released_at->format('Y-m-d') }}</p>
    <p>{{ $course->tagline }}</p>
    <ul>
        @foreach($course->learnings as $learning)
            <li>{{ $learning }}</li>
        @endforeach
    </ul>
    <img src="{{ asset("images/{$course->image_name}") }}" alt="{{ $course->title }}">
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
    <script type="text/javascript">
        Paddle.Setup({ vendor: {{ config('services.paddle.vendor_id') }} });
    </script>
    <a href="#" class="paddle-buy" data-product="{{ $course->paddle_product_id }}">Buy Now</a>

</body>
</html>
