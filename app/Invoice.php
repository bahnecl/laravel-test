<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use APP\Product;

class Invoice extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

    protected $dates = ['date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price', 'date', 'status', 'payment', 'payment_type', 'product_id',
    ];
}
