<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'colocation_id'];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function scopeGlobal($query)
    {
        return $query->whereNull('colocation_id');
    }

    public function scopeForColocation($query, $colocationId)
    {
        return $query->where('colocation_id', $colocationId);
    }
}
