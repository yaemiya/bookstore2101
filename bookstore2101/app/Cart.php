<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;

class Cart extends Model
{
    protected $fillable = ['name', 'quantity', 'price', 'user_id', 'session_id', 'book_id'];


    // public function users()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
