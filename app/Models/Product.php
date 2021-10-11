<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

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

    public function getImagesAttribute()
    {
        return $this->loadMedia('default')->map(function (Media $media) {
            return [
                'id' => $media->id,
                'url' => $media->getFullUrl()
            ];
        });
    }
}
