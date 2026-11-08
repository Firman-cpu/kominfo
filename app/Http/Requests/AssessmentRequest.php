<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssessmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $assessmentId = $this->route('assessment')?->id ?? $this->route('assessment');

        return [
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('assessments', 'student_id')->ignore($assessmentId),
            ],
            'assessment_date' => ['required', 'date'],
            'scores' => ['required', 'array', 'min:1'],
            'scores.*' => ['required', 'integer', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.unique' => 'Siswa / Mahasiswa ini sudah memiliki data penilaian. Setiap peserta hanya boleh memiliki 1 penilaian. Silakan edit nilai yang sudah ada.',
            'scores.*.min' => 'Nilai aspek minimal adalah 0.',
            'scores.*.max' => 'Nilai aspek maksimal adalah 100.',
        ];
    }
}
