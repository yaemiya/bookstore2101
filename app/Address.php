<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['name', 'email', 'postal_code', 'region', 'address', 'building', 'tel', 'user_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
