<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSettings extends Model
{
    protected $fillable = [
        'custom_payment_enabled',
        'batch',
        'multiple_payments_enabled',
        'multiple_payments'
    ];

    protected $casts = [
        'custom_payment_enabled' => 'boolean',
        'multiple_payments_enabled' => 'boolean',
        'multiple_payments' => 'array'
    ];

    // لمنع إنشاء أكثر من سجل
    protected static function boot()
{
    parent::boot();

    static::created(function () {
        if (self::count() > 1) {
            self::latest()->first()->delete();
        }
    });
}
}