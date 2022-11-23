<?php

namespace App\Models;

use App\Models\Receive;
use App\Models\Transaction;
use App\Models\StockTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public $table = 'products';

    protected $guarded = ['id'];

    public function receives()
    {
        return $this->hasMany(Receive::class, 'products_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'products_id');
    }

    public function stock_transactions()
    {
        return $this->hasMany(StockTransaction::class, 'products_id');
    }
}
