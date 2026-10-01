<section class="hero-section">

    <div class="container hero-grid">

        <div class="hero-content">

            <div class="hero-kicker">

                <span class="kicker-line"></span>

                <span>
                    PRAKERIN MONITORING SYSTEM
                </span>

            </div>


            <h1 class="hero-title">

                Praktik kerja.

                <span>
                    Dibuat terukur.
                </span>

            </h1>


            <p class="hero-description">

                Platform monitoring siswa Praktik Kerja Lapangan
                untuk mengelola data, memantau perkembangan,
                dan melihat kondisi siswa secara terstruktur.

            </p>


            <div class="hero-actions">

                <a
                    href="{{ route('students.index') }}"
                    class="btn btn-primary"
                >

                    <i data-lucide="arrow-up-right"></i>

                    <span>
                        Lihat Data Siswa
                    </span>

                </a>


                <a
                    href="#features"
                    class="btn btn-ghost"
                >

                    <i data-lucide="layers-3"></i>

                    <span>
                        Explore System
                    </span>

                </a>

            </div>


            <div class="hero-meta">

                <div>

                    <span>
                        DATABASE
                    </span>

                    <strong>
                        LIVE
                    </strong>

                </div>


                <div>

                    <span>
                        SYSTEM
                    </span>

                    <strong>
                        STABLE
                    </strong>

                </div>


                <div>

                    <span>
                        VERSION
                    </span>

                    <strong>
                        1.0
                    </strong>

                </div>

            </div>

        </div>


        <x-landing.hero-dashboard
            :total-students="$totalStudents"
            :active-students="$activeStudents"
        />

    </div>

</section>
