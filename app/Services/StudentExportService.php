<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\AssessmentAspect;
use App\Models\Student;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentExportService
{
    /**
     * Sanitasi formula injection Excel (=, +, -, @)
     */
    protected function sanitizeValue(mixed $value): mixed
    {
        if (is_string($value) && strlen($value) > 0) {
            $firstChar = $value[0];
            if (in_array($firstChar, ['=', '+', '-', '@'], true)) {
                return "'" . $value;
            }
        }

        return $value;
    }

    /**
     * Generate export file stream response
     */
    public function export(array $filters, string $dataset = 'both'): StreamedResponse
    {
        $filename = 'export_prakerin_' . date('Ymd_His') . '.xlsx';

        return new StreamedResponse(function () use ($filters, $dataset) {
            $writer = new Writer();
            $writer->openToBrowser('export.xlsx');

            // Sheet 1: Data Siswa & Mahasiswa
            if (in_array($dataset, ['students', 'both'], true)) {
                $sheet = $writer->getCurrentSheet();
                $sheet->setName('Siswa & Mahasiswa');

                $headers = [
                    'No',
                    'Tipe',
                    'NIS / NIM',
                    'Nama Lengkap',
                    'Asal Sekolah / Kampus',
                    'Jurusan / Prodi',
                    'Kelas / Fakultas',
                    'Bidang Penempatan',
                    'Tanggal Mulai',
                    'Tanggal Selesai',
                    'Status',
                ];
                $writer->addRow(Row::fromValues($headers));

                $query = Student::with('department')->orderBy('name');

                if (!empty($filters['year'])) {
                    $query->whereYear('start_date', $filters['year']);
                }
                if (!empty($filters['type'])) {
                    $query->where('type', $filters['type']);
                }
                if (!empty($filters['department_id'])) {
                    $query->where('department_id', $filters['department_id']);
                }
                if (!empty($filters['status'])) {
                    $query->where('status', $filters['status']);
                }

                $no = 1;
                $query->chunk(200, function ($students) use ($writer, &$no) {
                    foreach ($students as $s) {
                        $row = [
                            $no++,
                            $s->type_label,
                            $this->sanitizeValue($s->identity_number),
                            $this->sanitizeValue($s->name),
                            $this->sanitizeValue($s->institution ?? '-'),
                            $this->sanitizeValue($s->major ?? '-'),
                            $this->sanitizeValue($s->type === 'magang' ? ($s->faculty ?? '-') : ($s->class ?? '-')),
                            $this->sanitizeValue($s->department?->name ?? '-'),
                            $s->start_date ? $s->start_date->format('d/m/Y') : '-',
                            $s->end_date ? $s->end_date->format('d/m/Y') : '-',
                            $s->status_label,
                        ];
                        $writer->addRow(Row::fromValues($row));
                    }
                });
            }

            // Sheet 2: Data Penilaian
            if (in_array($dataset, ['assessments', 'both'], true)) {
                if ($dataset === 'both') {
                    $sheet2 = $writer->addNewSheetAndMakeItCurrent();
                    $sheet2->setName('Data Penilaian');
                } else {
                    $writer->getCurrentSheet()->setName('Data Penilaian');
                }

                // Ambil semua aspek aktif
                $aspects = AssessmentAspect::orderBy('sort_order')->get();

                $headers = [
                    'No',
                    'Tipe',
                    'NIS / NIM',
                    'Nama Siswa / Mahasiswa',
                    'Sekolah / Kampus',
                    'Bidang',
                    'Tanggal Penilaian',
                ];

                foreach ($aspects as $aspect) {
                    $headers[] = $aspect->name;
                }

                $headers[] = 'Rata-rata Nilai';
                $headers[] = 'Kategori Performa';
                $headers[] = 'Catatan Pembimbing';

                $writer->addRow(Row::fromValues($headers));

                $query = Assessment::with(['student.department', 'scores.aspect'])
                    ->whereHas('student', function ($sq) use ($filters) {
                        if (!empty($filters['year'])) {
                            $sq->whereYear('start_date', $filters['year']);
                        }
                        if (!empty($filters['type'])) {
                            $sq->where('type', $filters['type']);
                        }
                        if (!empty($filters['department_id'])) {
                            $sq->where('department_id', $filters['department_id']);
                        }
                        if (!empty($filters['status'])) {
                            $sq->where('status', $filters['status']);
                        }
                    });

                $no = 1;
                $query->chunk(200, function ($assessments) use ($writer, $aspects, &$no) {
                    foreach ($assessments as $a) {
                        $scoresMap = $a->scores->pluck('score', 'aspect_id')->toArray();

                        $row = [
                            $no++,
                            $a->student?->type_label ?? '-',
                            $this->sanitizeValue($a->student?->identity_number ?? '-'),
                            $this->sanitizeValue($a->student?->name ?? '-'),
                            $this->sanitizeValue($a->student?->institution ?? '-'),
                            $this->sanitizeValue($a->student?->department?->name ?? '-'),
                            $a->assessment_date ? $a->assessment_date->format('d/m/Y') : '-',
                        ];

                        foreach ($aspects as $aspect) {
                            $row[] = $scoresMap[$aspect->id] ?? '-';
                        }

                        $avg = $a->average_score;
                        $cat = $a->category?->name ?? '-';

                        $row[] = $avg;
                        $row[] = $cat;
                        $row[] = $this->sanitizeValue($a->notes ?? '-');

                        $writer->addRow(Row::fromValues($row));
                    }
                });
            }

            $writer->close();
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
