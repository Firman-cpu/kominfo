<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Bidang / Departemen Penempatan Siswa & Mahasiswa
    |--------------------------------------------------------------------------
    */
    'departments' => [
        [
            'name' => 'Sekretariat',
            'code' => 'SEKRETARIAT',
            'sort_order' => 1,
            'description' => 'Bidang Kesekretariatan dan Administrasi Umum Dinas Kominfo',
        ],
        [
            'name' => 'Teknologi Informasi (TI)',
            'code' => 'TI',
            'sort_order' => 2,
            'description' => 'Bidang Tata Kelola dan Infrastruktur Teknologi Informasi',
        ],
        [
            'name' => 'Statistik',
            'code' => 'STATISTIK',
            'sort_order' => 3,
            'description' => 'Bidang Pengelolaan Data dan Statistik Sektoral',
        ],
        [
            'name' => 'Informasi dan Komunikasi Publik (Infokom)',
            'code' => 'INFOKOM',
            'sort_order' => 4,
            'description' => 'Bidang Pengelolaan Informasi dan Komunikasi Publik',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Informasi Jam Kerja & Layanan Publik
    |--------------------------------------------------------------------------
    */
    'office_hours' => [
        'workdays' => 'Senin - Jumat',
        'monday_thursday' => '07.30 - 16.00 WIB',
        'friday' => '07.30 - 15.00 WIB',
        'weekend' => 'Sabtu & Minggu Tutup',
    ],
];
