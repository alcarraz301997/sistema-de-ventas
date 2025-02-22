<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProducts extends Model
{
    use HasFactory;

    protected $table = 'sale_products';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'fl_status',
    ];

    public function scopeActive($query)
    {
        return $query->where('fl_status', true);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
