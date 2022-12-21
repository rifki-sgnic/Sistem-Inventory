<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProductDetail extends Model
{
    use HasFactory;

    public $table = 'request_product_detail';

    protected $guarded = ['id'];

    public function request_products()
    {
        return $this->belongsTo(RequestProduct::class, 'request_products_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
