<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('student')?->id ?? $this->route('student');

        return [
            'type' => ['required', 'in:prakerin,magang'],
            'identity_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students')->where(function ($query) {
                    return $query->where('type', $this->input('type'));
                })->ignore($studentId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'faculty' => ['nullable', 'string', 'max:255'],
            'class' => ['nullable', 'string', 'max:100'],
            'department_id' => ['required', 'exists:departments,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'identity_number.unique' => 'Nomor Identitas (NIS/NIM) untuk tipe ini sudah terdaftar di sistem.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'department_id.required' => 'Bidang penempatan wajib dipilih.',
            'photo.max' => 'Ukuran foto profil tidak boleh melebihi 2 MB.',
            'photo.image' => 'File harus berupa gambar (JPEG, PNG, JPG, WEBP).',
        ];
    }
}
