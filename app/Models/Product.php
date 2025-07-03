<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'stock',
        'image_path',
        'description'
    ];

    public function invoices() {
        return $this->belongsToMany(Invoice::class, 'invoice_products', 'product_id', 'invoice_code')
                    ->withPivot('quantity', 'cost')
                    ->withTimestamps();
    }

    public function users() {
        return $this->belongsToMany(User::class, 'product_favorites', 'product_id', 'user_id')
                    ->withTimestamps();
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
