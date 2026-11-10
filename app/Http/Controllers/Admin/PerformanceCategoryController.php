<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerformanceCategoryRequest;
use App\Models\PerformanceCategory;
use Illuminate\Support\Facades\Cache;

class PerformanceCategoryController extends Controller
{
    public function index()
    {
        $categories = PerformanceCategory::orderByDesc('min_score')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function update(PerformanceCategoryRequest $request)
    {
        $data = $request->validated();

        foreach ($data['categories'] as $item) {
            PerformanceCategory::where('id', $item['id'])->update([
                'name' => $item['name'],
                'min_score' => $item['min_score'],
                'description' => $item['description'] ?? null,
            ]);
        }

        Cache::forget('performance_categories');

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Batas nilai dan kategori performa berhasil diperbarui.');
    }
}
