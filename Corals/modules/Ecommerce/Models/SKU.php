<?php

namespace Corals\Modules\Ecommerce\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Ecommerce\Traits\DownloadableModel;
use Corals\Modules\Payment\Traits\GatewayStatusTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class SKU extends BaseModel implements HasMedia
{
    use PresentableTrait, LogsActivity, HasMediaTrait, GatewayStatusTrait, DownloadableModel;

    protected $table = 'ecommerce_sku';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'ecommerce.models.sku';

    protected static $logAttributes = ['regular_price', 'sale_price'];

    protected $guarded = ['id'];

    protected $appends = ['price'];

    protected $casts = [
        'shipping' => 'array'
    ];

    public function options()
    {
        return $this->hasMany(SKUOption::class, 'sku_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return string
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function getImageAttribute()
    {
        $media = $this->getFirstMedia('ecommerce-sku-image');
        if ($media) {
            return $media->getUrl();
        } else {
            return optional($this->product)->image ?? asset(config($this->config . '.default_image'));
        }
    }

    public function getPriceAttribute()
    {
        $regularPrice = $this->attributes['regular_price'];

        $salePrice = $this->attributes['sale_price'];

        if ($salePrice && $salePrice < $regularPrice) {
            return min($regularPrice, $salePrice);
        } else {
            return $regularPrice;
        }
    }

    public function getDiscountAttribute()
    {
        $regularPrice = $this->attributes['regular_price'];

        $salePrice = $this->attributes['sale_price'];

        if ($salePrice && $salePrice < $regularPrice) {
            $discount = (1 - ($salePrice / $regularPrice)) * 100;
            return number_format($discount, 0, '.', '');
        } else {
            return 0;
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getStockStatusAttribute()
    {
        $inventory = $this->checkInventory(1, false);

        $inventory = \Filters::do_filter('sku_pre_stock_status', $inventory, $this);
        
        if ($inventory) {
            return 'in_stock';
        } else {
            return 'out_of_stock';
        }
    }

    public function getCurrencyAttribute()
    {
        $currency = \Payments::admin_currency_code();

        return $currency;
    }

    public function getCurrencyIconAttribute()
    {
        $currency = $this->currency;

        return 'fa fa-fw fa-' . strtolower($currency);
    }

    public function scopeVisible($query)
    {
        return $query->whereHas('product', function ($query) {
            $query->where('status', '<>', 'deleted');
        });
    }

    public function scopeActive($query)
    {
        $query->where('status', 'active');
    }

    /**
     * @param int $quantity
     * @param bool $throw_error
     * @return bool
     * @throws \Exception
     */
    public function checkInventory($quantity = 1, $throw_error = false)
    {
        $available = null;
        $available_quantity = 0;
        switch ($this->inventory) {
            case 'infinite':
                $available = true;
                break;
            case 'bucket':
                if ($this->inventory_value == "out_of_stock") {
                    $available = false;
                } else {
                    $available = true;
                }
                break;

            case 'finite':
                if ($quantity <= $this->inventory_value) {
                    $available = true;

                } else {
                    $available_quantity = $this->inventory_value;
                    $available = false;
                }
                break;
            default:
                $available = false;

        }

        if (!$available) {

            if ($throw_error) {

                if ($available_quantity) {
                    throw new \Exception(trans('Ecommerce::exception.sku.item_has_only_quantity', ['quantity' => $available_quantity]));

                } else {
                    throw new \Exception(trans('Ecommerce::exception.sku.item_current_out'));

                }
            } else {
                return false;
            }
        } else {
            return true;
        }

    }
}
