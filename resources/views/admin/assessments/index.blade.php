<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penilaian Siswa</title>
</head>

<body>

    <h1>Penilaian Siswa</h1>

    @if (session('success'))
        <p>
            {{ session('success') }}
        </p>
    @endif

    <a href="{{ route('admin.assessments.create') }}">
        + Tambah Penilaian
    </a>

    <hr>

    @forelse ($assessments as $assessment)

        <div>

            <h3>
                {{ $assessment->student->name }}
            </h3>

            <p>
                Tanggal:
                {{ $assessment->assessment_date->format('d-m-Y') }}
            </p>

            <p>
                Disiplin:
                {{ $assessment->discipline }}
            </p>

            <p>
                Tanggung Jawab:
                {{ $assessment->responsibility }}
            </p>

            <p>
                Kerja Sama:
                {{ $assessment->teamwork }}
            </p>

            <p>
                Komunikasi:
                {{ $assessment->communication }}
            </p>

            <p>
                Inisiatif:
                {{ $assessment->initiative }}
            </p>

            <p>
                Kualitas Kerja:
                {{ $assessment->work_quality }}
            </p>

            @if ($assessment->notes)
                <p>
                    Catatan:
                    {{ $assessment->notes }}
                </p>
                <a href="{{ route('admin.assessments.edit', $assessment) }}">
    Edit
</a>

<form
    action="{{ route('admin.assessments.destroy', $assessment) }}"
    method="POST"
    style="display: inline;"
>
    @csrf
    @method('DELETE')

    <button
        type="submit"
        onclick="return confirm('Hapus penilaian ini?')"
    >
        Hapus
    </button>
</form>
            @endif

        </div>

        <hr>

    @empty

        <p>
            Belum ada penilaian.
        </p>

    @endforelse

    <a href="{{ route('admin.dashboard.page') }}">
        Kembali ke Dashboard
    </a>

</body>
</html>