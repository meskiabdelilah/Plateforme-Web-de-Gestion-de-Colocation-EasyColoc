<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'payed_id');
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
}
