<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutTemps extends Model
{
    use HasFactory;

    protected $table = "checkout_temps";
    protected $guarded = [];
}
