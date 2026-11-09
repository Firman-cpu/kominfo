<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
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

        $createData = [
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => 'operator',
            'is_primary' => false,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        // Handle photo upload — store as BLOB in DB
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $createData['photo_data'] = file_get_contents($file->getRealPath());
            $createData['photo_mime'] = $file->getMimeType();
        }

        $operator = Admin::create($createData);

        return redirect()
            ->route('admin.operators.index')
            ->with('success', "Akun operator '{$operator->name}' ({$operator->username}) berhasil dibuat.");
    }

    public function edit(Admin $operator)
    {
        if ($operator->isAdministrator()) {
            abort(403, 'Akun Administrator tidak dapat diedit melalui manajemen operator.');
        }

        return view('admin.operators.edit', compact('operator'));
    }

    public function update(OperatorRequest $request, Admin $operator)
    {
        if ($operator->isAdministrator()) {
            abort(403, 'Akun Administrator tidak dapat diubah melalui manajemen operator.');
        }

        $data = $request->validated();

        $updateData = [
            'name' => $data['name'],
            'username' => $data['username'],
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        // Handle photo upload — store as BLOB in DB
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $updateData['photo_data'] = file_get_contents($file->getRealPath());
            $updateData['photo_mime'] = $file->getMimeType();
        }

        $operator->update($updateData);

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
