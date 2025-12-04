<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class ProductLang extends Model
{
    use Searchable;

    protected $table = 'products_lang';

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.barcode' => 5,
            'products_lang.title' => 10,
            'products_lang.description' => 10,
            'products_lang.characteristic' => 10,
        ],
        'joins' => [
            'products' => ['products_lang.product_id', 'products.id'],
        ],
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
}
