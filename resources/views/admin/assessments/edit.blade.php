<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Penilaian</title>
</head>

<body>

    <h1>Edit Penilaian</h1>

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
        action="{{ route('admin.assessments.update', $assessment) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div>
            <label for="student_id">
                Siswa
            </label>

            <select
                name="student_id"
                id="student_id"
                required
            >

                @foreach ($students as $student)

                    <option
                        value="{{ $student->id }}"
                        {{ old('student_id', $assessment->student_id) == $student->id ? 'selected' : '' }}
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
                value="{{ old('assessment_date', $assessment->assessment_date->format('Y-m-d')) }}"
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
                value="{{ old('discipline', $assessment->discipline) }}"
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
                value="{{ old('responsibility', $assessment->responsibility) }}"
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
                value="{{ old('teamwork', $assessment->teamwork) }}"
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
                value="{{ old('communication', $assessment->communication) }}"
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
                value="{{ old('initiative', $assessment->initiative) }}"
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
                value="{{ old('work_quality', $assessment->work_quality) }}"
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
            >{{ old('notes', $assessment->notes) }}</textarea>
        </div>

        <br>

        <button type="submit">
            Simpan Perubahan
        </button>

    </form>

    <br>

    <a href="{{ route('admin.assessments.index') }}">
        Batal
    </a>

</body>
</html>