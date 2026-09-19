<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('status')
            ->orderBy('id')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('categories.create', compact('statuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name',
            'status_id'     => 'required|integer|exists:status,id',
        ]);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    public function show(string $id): View
    {
        $category = Category::with(['status', 'subCategories.status'])
            ->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function edit(string $id): View
    {
        $category = Category::findOrFail($id);
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('categories.edit', compact('category', 'statuses'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name,' . $id,
            'status_id'     => 'required|integer|exists:status,id',
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        try {
            $category->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene subcategorías asociadas.');
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
