<!DOCTYPE html>
<html>

<head>
    <title>Your Video is Ready</title>
</head>

<body>
    <h1>Your latest video has finished rendering!</h1>

    <p>You can view it here:</p>
    <p><a href="{{ route('series.show', [ 'series' => $video->series->id ]) }}">{{ route('series.show', [ 'series' => $video->series->id ]) }}</a></p>

    <p>You can also download it directly here:</p>
    <p><a href="{{ asset($video->video_url) }}" download>{{ asset($video->video_url) }}</a></p>

    <h2>Title:</h2>
    <p>{{ $video->title }}</p>

    <h2>Caption:</h2>
    <p>{{ $video->caption }}</p>

    <p>Cheers,<br>{{ config('app.name') }}</p>
</body>

</html>