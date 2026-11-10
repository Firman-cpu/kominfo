<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAspect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssessmentAspectController extends Controller
{
    public function index()
    {
        $aspects = AssessmentAspect::withCount('scores')->orderBy('sort_order')->get();

        return view('admin.aspects.index', compact('aspects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $key = Str::slug($validated['name'], '_');
        $originalKey = $key;
        $counter = 1;
        while (AssessmentAspect::where('key', $key)->exists()) {
            $key = $originalKey.'_'.$counter++;
        }

        $aspect = AssessmentAspect::create([
            'name' => $validated['name'],
            'key' => $key,
            'sort_order' => $validated['sort_order'] ?? (AssessmentAspect::max('sort_order') + 1),
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.aspects.index')
            ->with('success', "Aspek penilaian '{$aspect->name}' berhasil ditambahkan.");
    }

    public function update(Request $request, AssessmentAspect $aspect)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $aspect->update([
            'name' => $validated['name'],
            'sort_order' => $validated['sort_order'] ?? $aspect->sort_order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.aspects.index')
            ->with('success', "Aspek penilaian '{$aspect->name}' berhasil diperbarui.");
    }

    public function destroy(AssessmentAspect $aspect)
    {
        if (! $aspect->canBeDeleted()) {
            return back()->withErrors([
                'error' => "Aspek '{$aspect->name}' tidak dapat dihapus karena sudah memiliki rekaman nilai. Anda dapat menonaktifkannya agar tidak muncul pada penilaian baru.",
            ]);
        }

        $name = $aspect->name;
        $aspect->delete();

        return redirect()
            ->route('admin.aspects.index')
            ->with('success', "Aspek penilaian '{$name}' berhasil dihapus.");
    }
}
