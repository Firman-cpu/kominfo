<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Siswa</title>
</head>

<body>

    <h1>Tambah Siswa PKL</h1>

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

    <form action="{{ route('admin.students.store') }}" method="POST">

        @csrf

        <div>
            <label for="nis">NIS</label>

            <input
                type="text"
                id="nis"
                name="nis"
                value="{{ old('nis') }}"
            >
        </div>

        <br>

        <div>
            <label for="name">Nama</label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
            >
        </div>

        <br>

        <div>
            <label for="major">Jurusan</label>

            <input
                type="text"
                id="major"
                name="major"
                value="{{ old('major') }}"
            >
        </div>

        <br>

        <div>
            <label for="class">Kelas</label>

            <input
                type="text"
                id="class"
                name="class"
                value="{{ old('class') }}"
            >
        </div>

        <br>

        <div>
            <label for="start_date">Tanggal Mulai</label>

            <input
                type="date"
                id="start_date"
                name="start_date"
                value="{{ old('start_date') }}"
            >
        </div>

        <br>

        <div>
            <label for="end_date">Tanggal Selesai</label>

            <input
                type="date"
                id="end_date"
                name="end_date"
                value="{{ old('end_date') }}"
            >
        </div>

        <br>

        <div>
            <label for="status">Status</label>

            <select id="status" name="status">
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>
                    Selesai
                </option>

                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                    Tidak Aktif
                </option>
            </select>
        </div>

        <br>

        <button type="submit">
            Simpan Siswa
        </button>

    </form>

    <br>

    <a href="{{ route('students.index') }}">
        Kembali ke Data Siswa
    </a>

</body>
</html>