<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    // use SearchableTrait;

    protected $table = 'products';

    public function productsLang()
    {
        return $this->hasMany(\App\Models\ProductLang::class);
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function options()
    {
        return $this->belongsToMany('App\Models\Option', 'product_option', 'product_id', 'option_id');
    }

    public function modes()
    {
        return $this->belongsToMany('App\Models\Mode', 'product_mode', 'product_id', 'mode_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'product_order', 'product_id', 'order_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'parent');
    }
}
