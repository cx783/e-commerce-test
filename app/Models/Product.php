<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status'
    ];

    protected $casts = [
        'price' => 'double',
        'status' => 'boolean'
    ];

    public static function booted()
    {
        static::creating(fn (Product $product) => $product->slug = Str::slug($product->name));
    }
}
