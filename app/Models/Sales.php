<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'code',
        'customer_name',
        'customer_id_type',
        'customer_id_number',
        'customer_email',
        'user_id',
        'total_amount',
        'sale_date',
        'fl_status',
    ];

    public function scopeActive($query)
    {
        return $query->where('fl_status', true);
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProducts::class, 'sale_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalProductsAttribute()
    {
        return $this->saleProducts->sum('quantity');
    }
}
