<?php

namespace App\Http\Controllers\Colocation;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\MemberShip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;

class ColocationController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $activeColocations = $user->colocations()
            ->wherePivot('left_at', null)
            ->get();


        $historyColocations = $user->colocations()
            ->wherePivotNotNull('left_at')
            ->get();

        return view('dashboard', compact('activeColocations', 'historyColocations'));
    }

    public function show(Colocation $colocation)
    {
        if (!$colocation->members->contains(auth()->id())) {
            abort(403, 'Vous n\'avez pas accès à cette colocation.');
        }

        $colocation->load(['members', 'expenses.user', 'categories']);

        return view('colocation.show', compact('colocation'));
    }

    
    public function store(Request $request)
    {
        $user = auth()->user();
        
        $hasActiveColocation = $user->colocations()
            ->wherePivot('left_at', null)
            ->exists();

        if ($hasActiveColocation) {
            return back()->with('error', 'Vous avez déjà une colocation active. Quittez-la pour en créer une nouvelle.');
        }
        $request->validate([
            'name' => 'required|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $colocation = Colocation::create([
                'name' => $request->name,
                'owner_id' => Auth::id(),
                'status' => 'active',
            ]);

            MemberShip::create([
                'user_id' => Auth::id(),
                'colocation_id' => $colocation->id,
                'role' => 'owner',
                'joint_at' => now(),
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Colocation créée avec succès !');
    }
}
