<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubSubcategory extends Model
{
    protected $guarded = [];

    public function subcategory()
    {
        return $this->belongsTo('App\Model\Subcategory', 'sub_category_id');
    }
}
