<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function list_products()
    {
        return $this->belongsTo(ListProduct::class, 'list_products_id', 'id');
    }
}
