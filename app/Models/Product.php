<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'status'
    ];

    // Optional: Cast price to float
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer'
    ];

    // Optional: Mutators
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = number_format($value, 2);
    }
}