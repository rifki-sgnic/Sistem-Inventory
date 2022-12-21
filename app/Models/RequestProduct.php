<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProduct extends Model
{
    use HasFactory;

    public $table = 'request_products';

    protected $guarded = ['id'];

    public function list_products()
    {
        return $this->hasOne(ListProduct::class, 'request_products_id');
    }

    public function request_product_detail()
    {
        return $this->hasMany(RequestProductDetail::class, 'request_products_id');
    }
}
