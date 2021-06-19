<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FlashDealProduct
 *
 * @property int $id
 * @property int $flash_deal_id
 * @property int $product_id
 * @property float|null $discount
 * @property string|null $discount_type
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct whereFlashDealId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FlashDealProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FlashDealProduct extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');

    }
}
