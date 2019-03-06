<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'lm', 'category_id', 'name', 'free_shipping', 'description', 'price'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'lm' => 'integer',
        'category_id' => 'integer',
        'free_shipping' => 'boolean',
        'price' => 'float'
    ];

    /**
    * The attributes that should be the primary key.
    *
    * @var string
    */
    protected $primaryKey = 'lm';

    /**
    * Indicates if the primary key should have incrementing.
    *
    * @var bool
    */
    public $incrementing = false;

    /**
    * Get the category that owns the product.
    */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
