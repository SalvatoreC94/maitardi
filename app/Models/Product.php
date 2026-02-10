<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_cents',
        'sku',
        'is_visible',
        'images',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'images' => 'array',
    ];

    protected $appends = ['image_url', 'image_urls'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        $first = is_array($this->images) && count($this->images) ? $this->images[0] : null;
        return $first ? url('storage/' . ltrim($first, '/')) : 'https://picsum.photos/800/600?blur=2';
    }

    public function getImageUrlsAttribute(): array
    {
        if (!is_array($this->images) || empty($this->images)) {
            return [$this->image_url];
        }

        return array_map(fn ($p) => url('storage/' . ltrim($p ?? '', '/')), $this->images);
    }
}
