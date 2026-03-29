<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'code',
        'name',
        'phone',
        'email',
        'location',
        'street',
        'home',
        'zip',
        'city',
        'country',
        'payment',
        'first_batch',
        'phone2',
        'note',
        'whatsapp',
        'code',
        'order_currancy'
    ];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
