<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class StudentPhotoController extends Controller
{
    public function show(Student $student): Response
    {
        // Raw query untuk hindari $hidden / stale cache
        $row = DB::table('students')
            ->where('id', $student->id)
            ->select('photo_data', 'photo_mime', 'photo_path')
            ->first();

        // Priority 1: DB blob
        if ($row && $row->photo_data && $row->photo_mime) {
            return response($row->photo_data, 200, [
                'Content-Type'  => $row->photo_mime,
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma'        => 'no-cache',
                'Expires'       => '0',
            ]);
        }

        // Priority 2: filesystem fallback
        $photoPath = $row?->photo_path ?? $student->photo_path;
        if ($photoPath && Storage::disk('local')->exists($photoPath)) {
            return response()->file(Storage::disk('local')->path($photoPath), [
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            ]);
        }

        // Final fallback: UI Avatar
        $name = urlencode($student->name);
        return redirect("https://ui-avatars.com/api/?name={$name}&background=1e3a8a&color=ffffff&bold=true");
    }
}
