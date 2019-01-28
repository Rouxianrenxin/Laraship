<?php
/**
 * PayPal Item bag
 */

namespace Corals\Modules\Payment\PayPal;

use Corals\Modules\Payment\Common\ItemBag;
use Corals\Modules\Payment\Common\ItemInterface;

/**
 * Class PayPalItemBag
 *
 * @package Corals\Modules\Payment\PayPal
 */
class PayPalItemBag extends ItemBag
{
    /**
     * Add an item to the bag
     *
     * @see Item
     *
     * @param ItemInterface|array $item An existing item, or associative array of item parameters
     */
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new PayPalItem($item);
        }
    }
}
