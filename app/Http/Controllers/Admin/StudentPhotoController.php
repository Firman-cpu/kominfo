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
        if (!$student->photo_path || !Storage::disk('local')->exists($student->photo_path)) {
            $name = urlencode($student->name);
            return redirect("https://ui-avatars.com/api/?name={$name}&background=1e3a8a&color=ffffff&bold=true");
        }

        $path = Storage::disk('local')->path($student->photo_path);

        return response()->file($path, [
            'Cache-Control' => 'private, max-age=86400',
        ]);
    }
}
