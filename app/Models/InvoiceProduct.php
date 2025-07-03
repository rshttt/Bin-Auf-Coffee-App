<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $table = 'invoice_products';

    protected $fillable = [
        'invoice_code',
        'product_id',
        'quantity'
    ];

    public $timestamps = true;

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_code', 'code');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    protected static function booted() {
        static::saving(function ($invoice_product) {
            $product = $invoice_product->product;

            if($product) {
                $invoice_product->cost = $product->price * $invoice_product->quantity;
            }
        });
        static::saved(function ($invoice_product) {
            $invoice = $invoice_product->invoice;

            if ($invoice) {
                $total = $invoice->products->sum(fn($product) => $product->pivot->cost);
                $invoice->total_cost = $total + $invoice->delivery_cost;
                $invoice->saveQuietly();
            }
        });
    }
}
