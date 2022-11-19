<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receive extends Model
{
    use HasFactory;

    public $table = 'receives';

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'suppliers_id', 'id');
    }
}
