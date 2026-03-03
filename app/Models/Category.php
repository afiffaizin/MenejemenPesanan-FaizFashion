<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'nameCategory'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
}
