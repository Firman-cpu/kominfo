<?php

namespace App\Http\Controllers;

class PublicProfileController extends Controller
{
    public function index()
    {
        $team = [
            [
                'name'   => 'Dinas Komunikasi dan Informatika',
                'short'  => 'DISKOMINFO',
                'kabupaten' => 'Kabupaten Pacitan',
                'address' => 'Jl. Jaksa Agung Suprapto No.8, Pacitan, Jawa Timur 63513',
                'email'  => 'diskominfo@pacitankab.go.id',
                'phone'  => '(0357) 881234',
                'website' => 'https://pacitankab.go.id',
                'vision' => 'Mewujudkan Pacitan yang maju, mandiri, dan sejahtera melalui penerapan teknologi informasi dan komunikasi yang merata dan berkeadilan.',
                'mission' => [
                    'Meningkatkan kualitas layanan informasi dan komunikasi kepada masyarakat.',
                    'Mengembangkan infrastruktur teknologi informasi pemerintah daerah.',
                    'Mendorong tata kelola pemerintahan berbasis elektronik (e-government).',
                    'Memberdayakan sumber daya manusia bidang TIK secara merata.',
                    'Mengoptimalkan pengelolaan data dan informasi publik secara transparan.',
                ],
            ],
        ];

        $faqs = [
            [
                'q' => 'Apa itu PRAKERIN?',
                'a' => 'Praktik Kerja Industri (PRAKERIN) adalah program pendidikan yang menempatkan siswa SMK di instansi atau perusahaan untuk mendapatkan pengalaman kerja nyata sesuai bidang keahlian mereka.',
            ],
            [
                'q' => 'Bagaimana cara mendaftar PRAKERIN di DISKOMINFO?',
                'a' => 'Pendaftaran dilakukan melalui sekolah masing-masing dengan menghubungi bagian kesiswaan atau langsung menghubungi DISKOMINFO Pacitan melalui email atau nomor telepon resmi.',
            ],
            [
                'q' => 'Berapa lama durasi PRAKERIN?',
                'a' => 'Durasi PRAKERIN umumnya berlangsung selama 3–6 bulan tergantung kurikulum sekolah masing-masing.',
            ],
            [
                'q' => 'Apa saja yang bisa dipelajari saat PRAKERIN di DISKOMINFO?',
                'a' => 'Siswa dapat mempelajari pengelolaan sistem informasi, pengembangan web, jaringan komputer, administrasi data, serta tata kelola layanan publik berbasis digital.',
            ],
            [
                'q' => 'Apakah ada sertifikat setelah PRAKERIN selesai?',
                'a' => 'Ya, setiap siswa yang menyelesaikan program PRAKERIN akan mendapatkan sertifikat keterangan dan nilai evaluasi dari DISKOMINFO Kabupaten Pacitan.',
            ],
        ];

        return view('public.profile', [
            'org'  => $team[0],
            'faqs' => $faqs,
        ]);
    }
}
