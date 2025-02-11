<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku', 'price', 'description', 'image', 'slug'];

    // ✅ Slug Generate Karne ke liye Boot Method
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }
}
