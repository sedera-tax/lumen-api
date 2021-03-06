<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductItems extends Model
{
    protected $primaryKey = 'product_items_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity', 'product_id', 'expired_date',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
