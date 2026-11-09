<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Symfony\Component\HttpFoundation\Response;

class AdminPhotoController extends Controller
{
    public function show(Admin $admin): Response
    {
        if ($admin->photo_data && $admin->photo_mime) {
            // Retrieve raw blob — model hides it from serialization, but direct attribute access still works
            $data = $admin->getAttributes()['photo_data'] ?? $admin->photo_data;

            return response($data, 200, [
                'Content-Type' => $admin->photo_mime,
                'Cache-Control' => 'private, max-age=86400',
            ]);
        }

        // Fallback to UI Avatar
        $name = urlencode($admin->name ?? 'Admin');
        return redirect("https://ui-avatars.com/api/?name={$name}&background=1e3a8a&color=ffffff&bold=true");
    }
}
