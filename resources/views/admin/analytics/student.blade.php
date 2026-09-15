<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $student->name }} - Analytics
    </title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

    {{-- HEADER --}}

    <header>

        <h1>
            {{ $student->name }}
        </h1>

        <p>
            NIS:
            {{ $student->nis }}
        </p>

        <p>
            Jurusan:
            {{ $student->major }}
        </p>

        <p>
            Kelas:
            {{ $student->class }}
        </p>

    </header>

    <hr>

    {{-- OVERALL PERFORMANCE --}}

    <section>

        <h2>
            Overall Performance
        </h2>

        <h3>
            {{ $average }} / 100
        </h3>

        <p>
            {{ $category }}
        </p>

        <p>
            {{ $description }}
        </p>

    </section>

    <hr>

    {{-- INSIGHT --}}

    <section>

        <h2>
            Performance Insight
        </h2>

        <h3>
            Kekuatan Utama
        </h3>

        @if ($strongestAspect)

            <p>
                {{ $strongestAspect['label'] }}

                —

                {{ $strongestAspect['score'] }}
            </p>

        @else

            <p>
                Belum ada data.
            </p>

        @endif

        <h3>
            Perlu Perhatian
        </h3>

        @if ($weakestAspect)

            <p>
                {{ $weakestAspect['label'] }}

                —

                {{ $weakestAspect['score'] }}
            </p>

        @else

            <p>
                Belum ada data.
            </p>

        @endif

    </section>

    <hr>

    {{-- RADAR CHART --}}

    <section>

        <h2>
            Performance Analysis
        </h2>

        <div style="max-width: 650px;">

            <canvas id="radarChart"></canvas>

        </div>

    </section>

    <hr>

    {{-- LINE CHART --}}

    <section>

        <h2>
            Performance History
        </h2>

        <div style="max-width: 900px;">

            <canvas id="historyChart"></canvas>

        </div>

    </section>

    <hr>

    {{-- ASPECT DETAILS --}}

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

    {{-- ASSESSMENT HISTORY --}}

    <section>

        <h2>
            Riwayat Penilaian
        </h2>

        @forelse ($assessments as $assessment)

            <article>

                <h3>
                    {{ $assessment->assessment_date->format('d M Y') }}
                </h3>

                <p>
                    Kedisiplinan:
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

                @endif

            </article>

            <hr>

        @empty

            <p>
                Belum ada penilaian.
            </p>

        @endforelse

    </section>

    <br>

    <a href="{{ route('admin.analytics.index') }}">
        ← Kembali ke Analytics
    </a>

    <script>
        const personalChartData =
            @json($personalChartData);

        const radarChartData =
            @json($radarChartData);

        /*
        |--------------------------------------------------------------------------
        | Radar Chart
        |--------------------------------------------------------------------------
        */

        const radarCanvas =
            document.getElementById('radarChart');

        new Chart(radarCanvas, {

            type: 'radar',

            data: {

                labels:
                    radarChartData.labels,

                datasets: [
                    {
                        label: 'Performa',

                        data:
                            radarChartData.values,

                        borderWidth: 2,

                        pointRadius: 4,

                        fill: true
                    }
                ]
            },

            options: {

                responsive: true,

                scales: {

                    r: {

                        min: 0,

                        max: 100,

                        ticks: {
                            stepSize: 20
                        }

                    }

                }

            }

        });


        /*
        |--------------------------------------------------------------------------
        | Performance History
        |--------------------------------------------------------------------------
        */

        const historyCanvas =
            document.getElementById('historyChart');

        new Chart(historyCanvas, {

            type: 'line',

            data: {

                labels:
                    personalChartData.labels,

                datasets: [
                    {
                        label: 'Performance Score',

                        data:
                            personalChartData.values,

                        borderWidth: 3,

                        tension: 0.35,

                        pointRadius: 5,

                        fill: false
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