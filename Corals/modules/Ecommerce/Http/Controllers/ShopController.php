<?php

namespace Corals\Modules\Ecommerce\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Ecommerce\Facades\Shop;
use Corals\Modules\Ecommerce\Models\Product;
use Illuminate\Http\Request;

class ShopController extends BaseController
{
    /**
     * CartController constructor.
     */
    public function __construct()
    {
        $this->title = 'Ecommerce::module.shop.title';
        $this->title_singular = 'Ecommerce::module.shop.title';

        parent::__construct();
    }

    /**
     * @param $permission
     */
    private function canAccess($permission)
    {
        if (!user()->hasPermissionTo($permission)) {
            abort(403);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->canAccess('Ecommerce::shop.access');

        $grid_items = Shop::getProducts($request);

        $grid_item_view = 'Ecommerce::shop.grid_item';

        return view('Ecommerce::shop.grid')->with(compact('grid_item_view', 'grid_items'));
    }

    public function show(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            abort(404);

        }
        $this->canAccess('Ecommerce::shop.access');

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $product->name])]);

        return view('Ecommerce::shop.show')->with(compact('product'));
    }

    public function settings(Request $request)
    {
        $this->canAccess('Ecommerce::settings.access');

        $this->setViewSharedData(['title_singular' => 'eCommerce Settings']);

        $settings = config('ecommerce.settings');

        return view('Ecommerce::shop.settings')->with(compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        try {
            $this->canAccess('Ecommerce::settings.access');

            $settings = $request->except('_token');

            foreach ($settings as $key => $value) {
                \Settings::set($key, $value, 'Ecommerce');
            }

            flash(trans('Corals::messages.success.saved', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, 'eCommerceSettings', 'savedSettings');
        }

        return redirectTo('e-commerce/settings');
    }
}