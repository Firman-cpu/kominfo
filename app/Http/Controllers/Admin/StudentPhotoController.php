<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class StudentPhotoController extends Controller
{
    public function show(Student $student): Response
    {
        // Priority 1: serve from DB blob
        $photoData = $student->getAttributes()['photo_data'] ?? $student->photo_data;
        if ($photoData && $student->photo_mime) {
            return response($photoData, 200, [
                'Content-Type' => $student->photo_mime,
                'Cache-Control' => 'private, max-age=86400',
            ]);
        }

        // Priority 2: serve from filesystem
        if ($student->photo_path && Storage::disk('local')->exists($student->photo_path)) {
            $path = Storage::disk('local')->path($student->photo_path);

            return response()->file($path, [
                'Cache-Control' => 'private, max-age=86400',
            ]);
        }

        // Final fallback: redirect to UI Avatar
        $name = urlencode($student->name);
        return redirect("https://ui-avatars.com/api/?name={$name}&background=1e3a8a&color=ffffff&bold=true");
    }
}
