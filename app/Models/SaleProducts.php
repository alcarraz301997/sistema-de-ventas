<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProducts extends Model
{
    use HasFactory;

    protected $table = 'sale_products';

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
}
