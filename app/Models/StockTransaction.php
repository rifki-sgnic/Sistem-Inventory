<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    public $table = 'stock_transactions';

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
