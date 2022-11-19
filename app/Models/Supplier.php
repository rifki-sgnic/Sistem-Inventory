<?php

namespace App\Models;

use App\Models\Receive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    public $table = 'suppliers';

    protected $guarded = ['id'];

    public function receives()
    {
        return $this->hasMany(Receive::class, 'suppliers_id');
    }
}
