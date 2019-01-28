<?php

namespace Corals\Modules\Utility\Transformers\Wishlist;

use Corals\Foundation\Transformers\FractalPresenter;

class WishlistPresenter extends FractalPresenter
{

    /**
     * @return WishlistTransformer|\League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new WishlistTransformer();
    }
}