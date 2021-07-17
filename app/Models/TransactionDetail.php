<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table = "transaction_details";
    protected $guarded = [];

    public function product_images()
    {
      return $this->hasMany(ProductImages::class);
    }
}
