<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand_id',
        'category_id',
        'purchase_price',
        'selling_price',
        'gst_percentage',
        'stock_quantity',
        'min_stock_alert',
        'image',
        'status',
        'created_by'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
