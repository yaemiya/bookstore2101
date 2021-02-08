<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart;

class Book extends Model
{
    protected $dates = [
        'issue_date'
    ];

    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }
}
