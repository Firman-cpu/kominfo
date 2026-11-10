<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Department;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Sinkronisasi status otomatis secara ringan saat membuka daftar siswa
        Student::where('status', 'active')
            ->whereNotNull('end_date')
            ->whereDate('end_date', '<', Carbon::today())
            ->update(['status' => 'completed']);

        $query = Student::with(['department', 'assessment'])->orderByDesc('id');

        // Pencarian (Nama, NIS/NIM, Asal Sekolah/Kampus, Jurusan)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('identity_number', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%")
                    ->orWhere('major', 'like', "%{$search}%");
            });
        }

        // Filter Tahun
        if ($year = $request->input('year')) {
            $query->whereYear('start_date', $year);
        }

        // Filter Tipe (Prakerin / Magang)
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Filter Bidang
        if ($departmentId = $request->input('department_id')) {
            $query->where('department_id', $departmentId);
        }

        // Filter Status (active / completed)
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $students = $query->paginate(15)->withQueryString();
        $departments = Department::orderBy('sort_order')->get();
        $availableYears = Student::getAvailableYears();

        return view('admin.students.index', compact('students', 'departments', 'availableYears'));
    }

    public function create()
    {
        $departments = Department::orderBy('sort_order')->get();

        return view('admin.students.create', compact('departments'));
    }

    public function store(StudentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            // Store in DB as blob
            $data['photo_data'] = file_get_contents($file->getRealPath());
            $data['photo_mime'] = $file->getMimeType();
            // Also keep filesystem copy for backward compat
            $filename = Str::random(32).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('private/students', $filename, 'local');
            $data['photo_path'] = $path;
        }

        // Tentukan status awal berdasarkan end_date
        $endDate = Carbon::parse($data['end_date']);
        $data['status'] = $endDate->endOfDay()->isPast() ? 'completed' : 'active';

        $student = Student::create($data);

        return redirect()
            ->route('admin.students.index')
            ->with('success', "Data {$student->type_label} '{$student->name}' berhasil ditambahkan.");
    }

    public function show(Student $student)
    {
        $student->load(['department', 'assessment.scores.aspect']);

        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $departments = Department::orderBy('sort_order')->get();

        return view('admin.students.edit', compact('student', 'departments'));
    }

    public function update(StudentRequest $request, Student $student)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($student->photo_path && Storage::disk('local')->exists($student->photo_path)) {
                Storage::disk('local')->delete($student->photo_path);
            }

            $file = $request->file('photo');
            // Store in DB as blob
            $data['photo_data'] = file_get_contents($file->getRealPath());
            $data['photo_mime'] = $file->getMimeType();
            // Also keep filesystem copy for backward compat
            $filename = Str::random(32).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('private/students', $filename, 'local');
            $data['photo_path'] = $path;
        }

        // Sinkronisasi status berdasarkan end_date
        $endDate = Carbon::parse($data['end_date']);
        $data['status'] = $endDate->endOfDay()->isPast() ? 'completed' : ($data['status'] ?? 'active');

        $student->update($data);

        return redirect()
            ->route('admin.students.index')
            ->with('success', "Data {$student->type_label} '{$student->name}' berhasil diperbarui.");
    }

    public function destroy(Student $student)
    {
        $name = $student->name;
        $typeLabel = $student->type_label;

        if ($student->photo_path && Storage::disk('local')->exists($student->photo_path)) {
            Storage::disk('local')->delete($student->photo_path);
        }

        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', "Data {$typeLabel} '{$name}' berhasil dihapus.");
    }
}
