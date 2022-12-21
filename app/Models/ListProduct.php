<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListProduct extends Model
{
    use HasFactory;

    public $table = 'list_products';

    protected $guarded = ['id'];

    public function request_products()
    {
        return $this->belongsTo(RequestProduct::class, 'request_products_id', 'id');
    }
}
