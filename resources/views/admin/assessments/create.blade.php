<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Penilaian</title>
</head>

<body>

    <h1>Tambah Penilaian Siswa</h1>

    @if ($errors->any())

        <div>

            <strong>Ada kesalahan:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <form
        action="{{ route('admin.assessments.store') }}"
        method="POST"
    >

        @csrf

        <div>
            <label for="student_id">
                Siswa
            </label>

            <select
                name="student_id"
                id="student_id"
                required
            >

                <option value="">
                    -- Pilih Siswa --
                </option>

                @foreach ($students as $student)

                    <option
                        value="{{ $student->id }}"
                        {{ old('student_id') == $student->id ? 'selected' : '' }}
                    >
                        {{ $student->name }} — {{ $student->nis }}
                    </option>

                @endforeach

            </select>
        </div>

        <br>

        <div>
            <label for="assessment_date">
                Tanggal Penilaian
            </label>

            <input
                type="date"
                name="assessment_date"
                id="assessment_date"
                value="{{ old('assessment_date', now()->format('Y-m-d')) }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="discipline">
                Kedisiplinan
            </label>

            <input
                type="number"
                name="discipline"
                id="discipline"
                min="0"
                max="100"
                value="{{ old('discipline') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="responsibility">
                Tanggung Jawab
            </label>

            <input
                type="number"
                name="responsibility"
                id="responsibility"
                min="0"
                max="100"
                value="{{ old('responsibility') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="teamwork">
                Kerja Sama
            </label>

            <input
                type="number"
                name="teamwork"
                id="teamwork"
                min="0"
                max="100"
                value="{{ old('teamwork') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="communication">
                Komunikasi
            </label>

            <input
                type="number"
                name="communication"
                id="communication"
                min="0"
                max="100"
                value="{{ old('communication') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="initiative">
                Inisiatif
            </label>

            <input
                type="number"
                name="initiative"
                id="initiative"
                min="0"
                max="100"
                value="{{ old('initiative') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="work_quality">
                Kualitas Kerja
            </label>

            <input
                type="number"
                name="work_quality"
                id="work_quality"
                min="0"
                max="100"
                value="{{ old('work_quality') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="notes">
                Catatan
            </label>

            <textarea
                name="notes"
                id="notes"
                rows="5"
            >{{ old('notes') }}</textarea>
        </div>

        <br>

        <button type="submit">
            Simpan Penilaian
        </button>

    </form>

    <br>

    <a href="{{ route('admin.assessments.index') }}">
        Kembali
    </a>

</body>
</html>