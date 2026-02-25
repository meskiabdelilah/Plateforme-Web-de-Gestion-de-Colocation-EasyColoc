<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberShip extends Model
{
    protected $table = 'membership';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
}
