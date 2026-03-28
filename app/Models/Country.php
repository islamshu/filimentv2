<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'flag',
        'currency'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
