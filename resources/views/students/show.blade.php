<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $student->name }} — PRAKERIN
    </title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;

            background: #08080d;

            color: white;

            min-height: 100vh;

            padding: 40px 20px;
        }

        .container {
            max-width: 900px;

            margin: auto;
        }

        .back {
            display: inline-block;

            margin-bottom: 30px;

            color: #a1a1aa;

            text-decoration: none;
        }

        .back:hover {
            color: white;
        }

        .profile {
            padding: 40px;

            border-radius: 32px;

            background:
                linear-gradient(
                    145deg,
                    rgba(124, 58, 237, 0.15),
                    rgba(6, 182, 212, 0.05)
                );

            border: 1px solid
                rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(20px);
        }

        .avatar {
            width: 80px;
            height: 80px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 24px;

            background:
                linear-gradient(
                    135deg,
                    #7c3aed,
                    #06b6d4
                );

            font-size: 30px;

            font-weight: bold;

            margin-bottom: 24px;
        }

        h1 {
            font-size: 42px;

            margin-bottom: 8px;
        }

        .major {
            color: #a1a1aa;

            margin-bottom: 35px;
        }

        .grid {
            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(200px, 1fr));

            gap: 15px;
        }

        .item {
            padding: 20px;

            border-radius: 18px;

            background:
                rgba(255, 255, 255, 0.05);
        }

        .label {
            display: block;

            color: #71717a;

            font-size: 13px;

            margin-bottom: 8px;
        }

        .value {
            font-size: 17px;

            font-weight: bold;
        }

        .status {
            display: inline-block;

            margin-top: 30px;

            padding: 9px 15px;

            border-radius: 999px;

            background:
                rgba(34, 197, 94, 0.12);

            color: #4ade80;
        }
    </style>

</head>

<body>

    <main class="container">

        <a
            class="back"
            href="{{ route('students.index') }}"
        >
            ← Kembali ke Data Siswa
        </a>

        <section class="profile">

            <div class="avatar">
                {{ strtoupper(
                    substr($student->name, 0, 1)
                ) }}
            </div>

            <h1>
                {{ $student->name }}
            </h1>

            <p class="major">
                {{ $student->major }}
            </p>

            <div class="grid">

                <div class="item">

                    <span class="label">
                        NIS
                    </span>

                    <span class="value">
                        {{ $student->nis }}
                    </span>

                </div>

                <div class="item">

                    <span class="label">
                        Kelas
                    </span>

                    <span class="value">
                        {{ $student->class }}
                    </span>

                </div>

                <div class="item">

                    <span class="label">
                        Mulai PKL
                    </span>

                    <span class="value">
                        {{ $student->start_date?->format('d M Y') }}
                    </span>

                </div>

                <div class="item">

                    <span class="label">
                        Selesai PKL
                    </span>

                    <span class="value">
                        {{ $student->end_date?->format('d M Y') }}
                    </span>

                </div>

            </div>

            <span class="status">
                {{ ucfirst($student->status) }}
            </span>

        </section>

    </main>

</body>

</html>
