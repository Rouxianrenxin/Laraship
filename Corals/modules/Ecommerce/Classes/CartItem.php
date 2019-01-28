<?php

namespace Corals\Modules\Ecommerce\Classes;

use Corals\Modules\Ecommerce\Exceptions\ModelNotFound;
use Corals\Modules\Ecommerce\Traits\CartOptionsMagicMethodsTrait;

/**
 * Class CartItem.
 *
 * @property int id
 * @property int qty
 * @property float tax
 * @property float price
 * @property string name
 * @property array options
 * @property bool taxable
 */
class CartItem
{
    const ITEM_ID = 'id';
    const ITEM_QTY = 'qty';
    const ITEM_TAX = 'tax';
    const ITEM_NAME = 'name';
    const ITEM_PRICE = 'price';
    const ITEM_TAXABLE = 'taxable';
    const ITEM_OPTIONS = 'options';

    use CartOptionsMagicMethodsTrait;

    protected $itemHash;
    protected $itemModel;
    protected $itemModelRelations;

    public $locale;
    public $lineItem;
    public $discount = 0;
    public $active = true;
    public $subItems = [];
    public $couponInfo = [];
    public $internationalFormat;

    /**
     * CartItem constructor.
     *
     * @param $id
     * @param $name
     * @param int $qty
     * @param string $price
     * @param array $options
     * @param bool $taxable
     * @param bool|false $lineItem
     */
    public function __construct($id, $name, $qty, $price, $options = [], $taxable = true, $lineItem = false)
    {
        $this->id = $id;
        $this->qty = $qty;
        $this->name = $name;
        $this->taxable = $taxable;
        $this->lineItem = $lineItem;
        $this->price = floatval($price);
        $this->tax = config('shoppingcart.tax');
        $this->itemModel = config('shoppingcart.item_model', null);
        $this->itemModelRelations = config('shoppingcart.item_model_relations', []);

        foreach ($options as $option => $value) {
            $this->$option = $value;
        }
    }

    /**
     * Generates a hash based on the cartItem array.
     *
     * @param bool $force
     *
     * @return string itemHash
     */
    public function generateHash($force = false)
    {
        if ($this->lineItem === false) {
            $this->itemHash = null;

            $cartItemArray = (array)$this;

            unset($cartItemArray['options']['qty']);

            ksort($cartItemArray['options']);

            $this->itemHash = md5(json_encode($cartItemArray));
        } elseif ($force || empty($this->itemHash) === true) {
            $this->itemHash = str_random(40);
        }

        app('events')->dispatch(
            'shoppingcart.updateItem', [
                'item' => $this,
                'newHash' => $this->itemHash,
            ]
        );

        return $this->itemHash;
    }

    /**
     * Gets the hash for the item.
     *
     * @return mixed
     */
    public function getHash()
    {
        return $this->itemHash;
    }

    /**
     * Search for matching options on the item.
     *
     * @return mixed
     */
    public function find($data)
    {
        foreach ($data as $key => $value) {
            if ($this->$key !== $value) {
                return false;
            }
        }

        return $this;
    }

    /**
     * Finds a sub item by its hash.
     *
     * @param $subItemHash
     *
     * @return mixed
     */
    public function findSubItem($subItemHash)
    {
        return array_get($this->subItems, $subItemHash);
    }

    /**
     * Adds an sub item to a item.
     *
     * @param array $subItem
     * @param bool $autoUpdate
     *
     * @return CartSubItem
     */
    public function addSubItem(array $subItem, $autoUpdate = true)
    {
        $subItem = new CartSubItem($subItem);

        $this->subItems[$subItem->getHash()] = $subItem;

        $this->generateHash();

        if ($autoUpdate) {
            app('shoppingcart')->update();
        }

        return $subItem;
    }

    /**
     * Removes a sub item from the item.
     *
     * @param $subItemHash
     */
    public function removeSubItem($subItemHash)
    {
        unset($this->subItems[$subItemHash]);

        $this->generateHash();
    }

    /**
     * Gets the price of the item with or without tax, with the proper format.
     *
     * @param bool $format
     * @param bool $taxedItemsOnly
     * @param bool $withTax
     *
     * @return string
     */
    public function price($format = true, $taxedItemsOnly = false, $withTax = false)
    {
        $total = 0;

        if ($this->active) {
            $total = $this->price + $this->subItemsTotal(false, $taxedItemsOnly);

            if ($withTax) {
                $total += $this->tax * $total;
            }
        }

        return ShoppingCart::formatMoney(
            $total,
            $this->locale,
            $this->internationalFormat, $format
        );
    }

    /**
     * Gets the sub total of the item based on the qty with or without tax in the proper format.
     *
     * @param bool $format
     * @param bool $withDiscount
     * @param bool $taxedItemsOnly
     * @param bool $withTax
     *
     * @return string
     */
    public function subTotal($format = true, $withDiscount = true, $taxedItemsOnly = false, $withTax = false)
    {
        $total = $this->price(false, $taxedItemsOnly) * $this->qty;

        if ($withDiscount) {
            $total -= $this->getDiscount(false);
        }

        if ($withTax) {
            $total += $this->tax();
        }

        return ShoppingCart::formatMoney($total, $this->locale, $this->internationalFormat, $format);
    }

    /**
     * Gets the totals for the options.
     *
     * @param bool $format
     * @param bool $taxedItemsOnly
     * @param bool $withTax
     *
     * @return string
     */
    public function subItemsTotal($format = true, $taxedItemsOnly = false, $withTax = false)
    {
        $total = 0;

        foreach ($this->subItems as $subItem) {
            $total += $subItem->price(false, $taxedItemsOnly) * ($subItem->qty ?: 1);
        }

        if ($withTax) {
            $total += $this->tax * $total;
        }

        return ShoppingCart::formatMoney($total, $this->locale, $this->internationalFormat, $format);
    }

    /**
     * Gets the discount of an item.
     *
     * @param bool $format
     *
     * @return string
     */
    public function getDiscount($format = true)
    {
        $amount = 0;

        if (app('shoppingcart')->findCoupon($this->code)) {
            $amount = $this->discount;
        }

        return ShoppingCart::formatMoney(
            $amount,
            $this->locale,
            $this->internationalFormat,
            $format
        );
    }

    /**
     * Gets the tax for the item.
     *
     * @param int $amountNotTaxable
     *
     * @return int|mixed
     */
    public function tax($amountNotTaxable = 0)
    {
        if (!$this->taxable) {
            $amountNotTaxable = $this->price * $this->qty;
        }

        if (config('shoppingcart.tax_by_item')) {
            $itemCount = 0;
            $totalTax = 0;
            while ($itemCount < $this->qty) {
                $totalTax += round($this->price * $this->tax, 2);
                $itemCount++;
            }

            return $totalTax - $amountNotTaxable;
        }

        return $this->tax * ($this->subTotal(false, !config('shoppingcart.discountTaxable', false), true) - $amountNotTaxable);
    }

    /**
     * Sets the related model to the item.
     *
     * @param $itemModel
     * @param array $relations
     *
     * @throws ModelNotFound
     */
    public function setModel($itemModel, $relations = [])
    {
        if (!class_exists($itemModel)) {
            throw new ModelNotFound(trans('Ecommerce::exception.cart.not_find_relation'));
        }

        $this->itemModel = $itemModel;
        $this->itemModelRelations = $relations;
    }

    /**
     * Returns a Model.
     *
     * @throws ModelNotFound
     */
    public function getModel()
    {
        $itemModel = (new $this->itemModel())->with($this->itemModelRelations)->find($this->id);

        if (empty($itemModel)) {
            throw new ModelNotFound(trans('Ecommerce::exception.cart.not_find model',['arg' => $this->id]));
        }

        return $itemModel;
    }

    /**
     *  A way to find sub items.
     *
     * @param $data
     *
     * @return array
     */
    public function searchForSubItem($data)
    {
        $matches = [];

        foreach ($this->subItems as $subItem) {
            if ($subItem->find($data)) {
                $matches[] = $subItem;
            }
        }

        return $matches;
    }

    public function disable()
    {
        $this->active = false;
        app('shoppingcart')->update();
    }

    public function enable()
    {
        $this->active = true;
        app('shoppingcart')->update();
    }
}
