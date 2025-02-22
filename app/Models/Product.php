<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'sku',
        'name',
        'unit_price',
        'stock',
        'fl_status',
    ];

    public function scopeActive($query)
    {
        return $query->where('fl_status', true);
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProducts::class, 'product_id');
    }
}
