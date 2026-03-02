<?php

namespace App\Http\Controllers\Colocation;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $colocationId = $request->query('colocation_id');

        // Global categories (where colocation_id is null)
        $globalCategories = Category::global()->get();

        // Colocation-specific categories (if colocation_id is provided)
        $colocationCategories = collect();
        $colocation = null;

        if ($colocationId) {
            $colocationCategories = Category::forColocation($colocationId)->get();
            $colocation = Colocation::findOrFail($colocationId);
        }

        return view('colocation.categories.index', compact('globalCategories', 'colocationCategories', 'colocation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|unique:categories,name',
            'colocation_id' => 'nullable|exists:colocations,id'
        ]);

        Category::create($validated);

        return redirect()
            ->route('colocation.show', $request->colocation_id)
            ->with('success', 'Catégorie ajoutée avec succès !');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|unique:categories,name,' . $category->id
        ]);

        $category->update($validated);

        return back()->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Catégorie supprimée !');
    }
}
