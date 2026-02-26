<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'status'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function memberships()
    {
        return $this->hasMany(MemberShip::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'membership')
            ->withPivot('role', 'joint_at', 'left_at')
            ->whereNull('membership.left_at');
    }

    public function payments()
    {
        return $this->belongsTo(Payment::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
