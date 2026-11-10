<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    public function index()
    {
        $operators = Admin::where('role', 'operator')->orderByDesc('id')->paginate(15);
        $adminCount = Admin::where('role', 'administrator')->count();

        return view('admin.operators.index', compact('operators', 'adminCount'));
    }

    public function create()
    {
        return view('admin.operators.create');
    }

    public function store(OperatorRequest $request)
    {
        $data = $request->validated();

        // ── Buat operator (tanpa foto dulu, hindari binary di LogsActivity) ──
        $operator = Admin::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => 'operator',
            'is_primary' => false,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // ── Simpan foto via DB::table() ──────────────────────────────────
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            DB::table('admins')->where('id', $operator->id)->update([
                'photo_data' => file_get_contents($file->getRealPath()),
                'photo_mime' => $file->getMimeType() ?: 'image/jpeg',
                'updated_at' => now(),
            ]);
        }

        return redirect()
            ->route('admin.operators.index')
            ->with('success', "Akun operator '{$operator->name}' ({$operator->username}) berhasil dibuat.");
    }

    public function edit(Admin $operator)
    {
        if ($operator->isAdministrator()) {
            abort(403, 'Akun Administrator tidak dapat diedit melalui manajemen operator.');
        }

        // Fresh load agar tampilkan foto terbaru di form edit
        return view('admin.operators.edit', ['operator' => $operator->fresh()]);
    }

    public function update(OperatorRequest $request, Admin $operator)
    {
        if ($operator->isAdministrator()) {
            abort(403, 'Akun Administrator tidak dapat diubah melalui manajemen operator.');
        }

        $data = $request->validated();

        // ── Susun field yang akan di-update ──────────────────────────────
        $updateFields = [
            'name' => $data['name'],
            'username' => $data['username'],
            'is_active' => $request->boolean('is_active'),
            'updated_at' => now(),
        ];

        if (! empty($data['password'])) {
            $updateFields['password'] = Hash::make($data['password']);
        }

        // ── Tambahkan foto jika ada upload baru ──────────────────────────
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $updateFields['photo_data'] = file_get_contents($file->getRealPath());
            $updateFields['photo_mime'] = $file->getMimeType() ?: 'image/jpeg';
        }

        // ── Satu UPDATE tunggal via DB::table() — bebas dari binary blob error ──
        DB::table('admins')->where('id', $operator->id)->update($updateFields);

        return redirect()
            ->route('admin.operators.index')
            ->with('success', "Data operator '{$operator->name}' berhasil diperbarui.");
    }

    public function destroy(Admin $operator)
    {
        if ($operator->isAdministrator()) {
            abort(403, 'Akun Administrator tidak dapat dihapus.');
        }

        $name = $operator->name;
        $operator->delete();

        return redirect()
            ->route('admin.operators.index')
            ->with('success', "Akun operator '{$name}' berhasil dihapus.");
    }
}
