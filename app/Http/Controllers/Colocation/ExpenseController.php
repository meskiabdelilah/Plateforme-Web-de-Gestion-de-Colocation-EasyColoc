<?php

namespace App\Http\Controllers\Colocation;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Colocation $colocation)
    {
        if (!$colocation->members->contains(auth()->id())) {
            abort(403, 'Vous n\'avez pas accès à cette colocation.');
        }

        $expenses = $colocation->expenses()->with('user', 'category')->get();

        return view('colocation.expenses.index', compact('colocation', 'expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Colocation $colocation)
    {
        if (!$colocation->members->contains(auth()->id())) {
            abort(403, 'Vous n\'avez pas accès à cette colocation.');
        }

        // Get global and colocation-specific categories
        $categories = Category::where(function ($query) use ($colocation) {
            $query->whereNull('colocation_id')
                ->orWhere('colocation_id', $colocation->id);
        })->get();

        return view('colocation.expenses.create', compact('colocation', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Colocation $colocation)
    {
        if (!$colocation->members->contains(auth()->id())) {
            abort(403, 'Vous n\'avez pas accès à cette colocation.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Verify category belongs to global or this colocation
        $category = Category::find($validated['category_id']);
        if ($category->colocation_id && $category->colocation_id !== $colocation->id) {
            abort(403, 'Cette catégorie n\'est pas disponible.');
        }

        $expense = $colocation->expenses()->create([
            ...$validated,
            'payed_id' => auth()->id(),
        ]);

        return redirect()->route('expenses.index', $colocation)
            ->with('success', 'Dépense ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation, Expense $expense)
    {
        if (!$colocation->members->contains(auth()->id())) {
            abort(403, 'Vous n\'avez pas accès à cette colocation.');
        }

        if ($expense->colocation_id !== $colocation->id) {
            abort(404, 'Dépense non trouvée.');
        }

        $expense->load('user', 'category');

        return view('colocation.expenses.show', compact('colocation', 'expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation, Expense $expense)
    {
        if (!$colocation->members->contains(auth()->id())) {
            abort(403, 'Vous n\'avez pas accès à cette colocation.');
        }

        if ($expense->colocation_id !== $colocation->id) {
            abort(404, 'Dépense non trouvée.');
        }

        // Only the user who created the expense can edit it
        if (auth()->id() !== $expense->payed_id) {
            abort(403, 'Vous ne pouvez modifier que vos propres dépenses.');
        }

        // Get global and colocation-specific categories
        $categories = Category::where(function ($query) use ($colocation) {
            $query->whereNull('colocation_id')
                ->orWhere('colocation_id', $colocation->id);
        })->get();

        return view('colocation.expenses.edit', compact('colocation', 'expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation, Expense $expense)
    {
        if (!$colocation->members->contains(auth()->id())) {
            abort(403, 'Vous n\'avez pas accès à cette colocation.');
        }

        if ($expense->colocation_id !== $colocation->id) {
            abort(404, 'Dépense non trouvée.');
        }

        if (auth()->id() !== $expense->payed_id) {
            abort(403, 'Vous ne pouvez modifier que vos propres dépenses.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Verify category belongs to global or this colocation
        $category = Category::find($validated['category_id']);
        if ($category->colocation_id && $category->colocation_id !== $colocation->id) {
            abort(403, 'Cette catégorie n\'est pas disponible.');
        }

        $expense->update($validated);

        return redirect()->route('expenses.show', [$colocation, $expense])
            ->with('success', 'Dépense mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation, Expense $expense)
    {
        if (!$colocation->members->contains(auth()->id())) {
            abort(403, 'Vous n\'avez pas accès à cette colocation.');
        }

        if ($expense->colocation_id !== $colocation->id) {
            abort(404, 'Dépense non trouvée.');
        }

        // Only the user who created the expense or owner can delete it
        if (auth()->id() !== $expense->payed_id && auth()->id() !== $colocation->owner_id) {
            abort(403, 'Vous ne pouvez supprimer que vos propres dépenses.');
        }

        $expense->delete();

        return redirect()->route('expenses.index', $colocation)
            ->with('success', 'Dépense supprimée avec succès !');
    }
}
