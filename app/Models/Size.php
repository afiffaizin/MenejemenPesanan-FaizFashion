<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'customer_id',
        'category_id',
        'panjang',
        'lingkar_badan',
        'lingkar_pinggang',
        'punggung',
        'panjang_lengan',
        'panjang_pinggang',
        'pinggul',
        'pisak',
        'pangkal_paha',
        'keterangan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
