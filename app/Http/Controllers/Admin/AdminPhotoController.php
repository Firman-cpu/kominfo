<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdminPhotoController extends Controller
{
    public function show(Admin $admin): Response
    {
        // Ambil photo_data langsung via raw query untuk menghindari:
        // 1) $hidden filtering pada Eloquent model
        // 2) Stale cached model di session / in-memory object
        $row = DB::table('admins')
            ->where('id', $admin->id)
            ->select('photo_data', 'photo_mime')
            ->first();

        if ($row && $row->photo_data && $row->photo_mime) {
            return response($row->photo_data, 200, [
                'Content-Type'  => $row->photo_mime,
                // no-store: browser selalu fetch ulang, tidak pernah cache
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma'        => 'no-cache',
                'Expires'       => '0',
            ]);
        }

        // Fallback ke UI Avatar
        $name = urlencode($admin->name ?? 'Admin');
        return redirect("https://ui-avatars.com/api/?name={$name}&background=1e3a8a&color=ffffff&bold=true");
    }
}
