<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'image', 'price', 'discount', 'sub_category_id'];
    protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = \Illuminate\Support\Str::slug($product->name . '-' . \Illuminate\Support\Str::random(5));
        });
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }
    public function scopeForCountry($query, $countryId)
    {
        return $query->whereHas('countries', function ($q) use ($countryId) {
            $q->where('countries.id', $countryId);
        });
    }


    // public function getImageAttribute($value)
    // {
    //     return $value ? asset('storage/' . $value) : null;
    // }
    public function getImageUrl()
    {
        // تحقق إذا كانت الصورة موجودة ثم أعرض رابط الصورة
        return  $this->image ? asset('storage/' .  $this->image) : null;
    }
    public function getImagePathAttribute()
    {
        return $this->getRawOriginal('image');
    }


    public function similarProducts($countryId = null)
    {
        return $this->where('sub_category_id', $this->sub_category_id)
            ->where('id', '!=', $this->id)
            ->when($countryId, function ($query) use ($countryId) {
                $query->whereHas('countries', function ($q) use ($countryId) {
                    $q->where('countries.id', $countryId);
                });
            })
            ->take(10)
            ->get();
    }
}
