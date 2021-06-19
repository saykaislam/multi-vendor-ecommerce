<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }
}
