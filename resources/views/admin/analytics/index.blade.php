<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Analytics Siswa</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <h1>
        Analytics Siswa
    </h1>

    <hr>

    {{-- OVERVIEW --}}

    <section>

        <h2>Overview</h2>

        <div>

            <div>
                <span>Total Siswa</span>

                <strong>
                    {{ $totalStudents }}
                </strong>
            </div>

            <div>
                <span>Total Penilaian</span>

                <strong>
                    {{ $totalAssessments }}
                </strong>
            </div>

            <div>
                <span>Rata-rata</span>

                <strong>
                    {{ $average }}
                </strong>
            </div>

            <div>
                <span>Status</span>

                <strong>
                    {{ $category }}
                </strong>
            </div>

        </div>

    </section>

    <hr>

    {{-- PERFORMANCE CHART --}}

    <section>

        <h2>
            Rata-rata Performa
        </h2>

        <div style="max-width: 800px;">

            <canvas id="performanceChart"></canvas>

        </div>

    </section>

    <hr>

    {{-- ASPECT DATA --}}

    <section>

        <h2>
            Rata-rata Setiap Aspek
        </h2>

        <ul>

            <li>
                Kedisiplinan:
                {{ $aspectAverages['discipline'] }}
            </li>

            <li>
                Tanggung Jawab:
                {{ $aspectAverages['responsibility'] }}
            </li>

            <li>
                Kerja Sama:
                {{ $aspectAverages['teamwork'] }}
            </li>

            <li>
                Komunikasi:
                {{ $aspectAverages['communication'] }}
            </li>

            <li>
                Inisiatif:
                {{ $aspectAverages['initiative'] }}
            </li>

            <li>
                Kualitas Kerja:
                {{ $aspectAverages['work_quality'] }}
            </li>

        </ul>

    </section>

    <hr>

    {{-- RANKING --}}

    <section>

        <h2>
            Top 5 Performa Siswa
        </h2>

        @forelse ($ranking as $index => $student)

            <div>

                <strong>
                    #{{ $index + 1 }}
                </strong>

                <span>
                    {{ $student['name'] }}
                </span>

                <span>
                    {{ $student['average'] }}
                </span>

                <span>
                    {{ $student['category'] }}
                </span>

                <br>

                <a
                    href="{{ route(
                        'admin.analytics.student',
                        $student['id']
                    ) }}"
                >
                    Lihat Detail
                </a>

            </div>

            <hr>

        @empty

            <p>
                Belum ada data siswa.
            </p>

        @endforelse

    </section>

    <hr>

    {{-- ALL STUDENTS --}}

    <section>

        <h2>
            Semua Siswa
        </h2>

        @forelse ($studentPerformance as $student)

            <div>

                <h3>
                    {{ $student['name'] }}
                </h3>

                <p>
                    NIS:
                    {{ $student['nis'] }}
                </p>

                <p>
                    Performa:
                    {{ $student['average'] }}
                </p>

                <p>
                    Status:
                    {{ $student['category'] }}
                </p>

                <a
                    href="{{ route(
                        'admin.analytics.student',
                        $student['id']
                    ) }}"
                >
                    Lihat Detail
                </a>

            </div>

            <hr>

        @empty

            <p>
                Belum ada data penilaian.
            </p>

        @endforelse

    </section>

    <br>

    <a href="{{ route('admin.dashboard.page') }}">
        ← Kembali ke Dashboard
    </a>

    <script>
        const chartData = @json($chartData);

        const ctx = document
            .getElementById('performanceChart');

        new Chart(ctx, {
            type: 'bar',

            data: {
                labels: chartData.labels,

                datasets: [
                    {
                        label: 'Rata-rata Nilai',

                        data: chartData.values,

                        borderWidth: 1
                    }
                ]
            },

            options: {
                responsive: true,

                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>

</body>

</html>