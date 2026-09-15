```blade
<div class="hero-dashboard-wrapper">

    <div class="dashboard-glow"></div>


    <div class="dashboard-window">

        <div class="window-header">

            <div class="window-controls">

                <span></span>
                <span></span>
                <span></span>

            </div>

            <div class="window-title">

                prakerin / dashboard

            </div>

            <i data-lucide="ellipsis"></i>

        </div>


        <div class="dashboard-body">


            <aside class="dashboard-sidebar">

                <div class="sidebar-label">
                    MONITOR
                </div>


                <div class="dashboard-menu active">

                    <i data-lucide="layout-dashboard"></i>

                    Dashboard

                </div>


                <div class="dashboard-menu">

                    <i data-lucide="users"></i>

                    Students

                </div>


                <div class="dashboard-menu">

                    <i data-lucide="clipboard-check"></i>

                    Assessment

                </div>


                <div class="dashboard-menu">

                    <i data-lucide="activity"></i>

                    Activity

                </div>

            </aside>


            <div class="dashboard-content">

                <div class="dashboard-heading">

                    <div>

                        <span>
                            OVERVIEW
                        </span>

                        <h3>
                            Monitoring siswa
                        </h3>

                    </div>


                    <div class="live-badge">

                        <span></span>

                        LIVE

                    </div>

                </div>


                <div class="dashboard-stat-grid">

                    <div class="dashboard-stat">

                        <span>
                            TOTAL STUDENTS
                        </span>

                        <strong>
                            {{ $totalStudents }}
                        </strong>

                        <small>
                            Registered
                        </small>

                    </div>


                    <div class="dashboard-stat">

                        <span>
                            ACTIVE
                        </span>

                        <strong>
                            {{ $activeStudents }}
                        </strong>

                        <small>
                            Currently active
                        </small>

                    </div>

                </div>


                <div class="dashboard-chart">

                    <div class="chart-header">

                        <span>
                            ACTIVITY
                        </span>

                        <i data-lucide="trending-up"></i>

                    </div>


                    <div class="chart-bars">

                        <span style="height:35%"></span>
                        <span style="height:52%"></span>
                        <span style="height:42%"></span>
                        <span style="height:68%"></span>
                        <span style="height:55%"></span>
                        <span style="height:78%"></span>
                        <span style="height:91%"></span>
                        <span style="height:72%"></span>

                    </div>

                </div>


                <div class="dashboard-footer">

                    <span>
                        Database connected
                    </span>

                    <span>
                        <i data-lucide="database"></i>
                        MySQL
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>
```
