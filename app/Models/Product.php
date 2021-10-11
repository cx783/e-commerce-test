<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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

    public function scopeFilter(Builder $builder, array $filters)
    {
        return $builder
            ->when($filters['name'] ?? null, function (Builder $query, $name) {
                return $query->where('name', 'like', "%$name%");
            })
            ->when($filters['trashed'] ?? null, function (Builder $query) {
                return $query->withTrashed()->whereNotNull('deleted_at');
            });
    }
}
