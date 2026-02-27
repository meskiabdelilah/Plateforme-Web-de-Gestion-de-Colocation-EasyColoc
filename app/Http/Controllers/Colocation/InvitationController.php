<?php

namespace App\Http\Controllers\Colocation;

use App\Http\Controllers\Controller;
use App\Mail\InvitationMail;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\MemberShip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function invite(Request $request, Colocation $colocation)
    {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        $email = $validated['email'];

        $isMember = $colocation->members()->where('email', $email)->exists();
        if ($isMember) {
            return back()->with('error', 'cette personne est déjà membre !');
        }

        $hasPendingInvitation = $colocation->invitations()
            ->where('email', $email)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->exists();

        if ($hasPendingInvitation) {
            return back()->with('error', 'Une invitation est déjà en cours pour cet email.');
        }


        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => Str::random(40),
                'status' => 'pending',
                'expires_at' => now()->addDays(2),
        ]);

        Mail::to($email)->send(new InvitationMail($invitation));
        return back()->with('success', 'Invitation envoyée avec succès !');
    }

    public function join($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        return view('colocation.join', compact('invitation'));
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->firstOrFail();
        $user = auth()->user();
        
        if ($user->email !== $invitation->email) {
            return redirect()->route('dashboard')->with('error', 'Cet email ne correspond pas à l\'invitation.');
        }

        DB::transaction(function() use($invitation, $user)
        {
            $invitation->update(['status' => 'accepted']);

            MemberShip::create([
                'user_id' => $user->id,
                'colocation_id' => $invitation->colocation_id,
                'role' => 'member',
                'joint_at' => now(),
            ]);
        });

        return redirect()->route('colocation.show', $invitation->colocation_id)->with('success', 'Bienvenue dans la colocation !');
    }

    public function reject($token)
    {
        $invitation = Invitation::where('token', $token)
        ->where('status', 'pending')
        ->firstOrFail();

        $invitation->update([
            'status'=> 'expired'
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Invitation refusée.');
    }

}
