<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Siswa</title>
</head>

<body>

    <h1>Data Siswa PKL</h1>

    @if (session('success'))
        <p>
            {{ session('success') }}
        </p>
    @endif

    <hr>

    @if ($students->isEmpty())

        <p>Belum ada data siswa.</p>

    @else

        <ul>

            @foreach ($students as $student)

<li>
    <strong>{{ $student->name }}</strong>
    -
    {{ $student->major }}
    -
    {{ $student->status }}

</li>

            @endforeach

        </ul>

    @endif

</body>
</html>