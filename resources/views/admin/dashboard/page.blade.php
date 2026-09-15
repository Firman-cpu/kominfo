<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>
</head>

<body>

    <h1>Admin Dashboard</h1>

    <p>
        Selamat datang,
        {{ session('admin_username') }}
    </p>

    <hr>

    <h2>Statistik Siswa</h2>

    <div>
        <h3>Total Siswa</h3>
        <p>{{ $totalStudents }}</p>
    </div>

    <div>
        <h3>Siswa Aktif</h3>
        <p>{{ $activeStudents }}</p>
    </div>

    <div>
        <h3>Selesai PKL</h3>
        <p>{{ $completedStudents }}</p>
    </div>

    <div>
        <h3>Tidak Aktif</h3>
        <p>{{ $inactiveStudents }}</p>
    </div>

    <hr>

    <a href="{{ route('admin.students.index') }}">
        Kelola Data Siswa
    </a>

    <br><br>

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</body>
</html>