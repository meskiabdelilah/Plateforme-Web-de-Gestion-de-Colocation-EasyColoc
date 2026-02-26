<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    protected $fillable = [
        'colocation_id',
        'payed_id',
        'category_id',
        'amount',
        'description',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'payed_id');
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
