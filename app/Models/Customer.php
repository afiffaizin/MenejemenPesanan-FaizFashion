<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'phone',
        'address'
    ];

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


  
}
