<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Invoice;

class Product extends Model
{
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'image', 'invoice_id', 'price',
    ];
}
