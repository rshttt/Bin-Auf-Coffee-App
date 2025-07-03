<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['code', 'delivery_cost', 'status', 'user_id'];

    public function products() {
        return $this->belongsToMany(Product::class, 'invoice_products', 'invoice_code', 'product_id')
                    ->withPivot('quantity', 'cost')
                    ->withTimestamps();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
