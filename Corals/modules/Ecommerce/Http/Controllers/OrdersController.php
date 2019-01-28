<?php

namespace Corals\Modules\Ecommerce\Http\Controllers;

use Corals\Foundation\DataTables\CoralsBuilder;
use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Ecommerce\Contracts\ShippingContract;
use Corals\Modules\Ecommerce\DataTables\MyOrdersDataTable;
use Corals\Modules\Ecommerce\DataTables\MyPrivatePagesDataTable;
use Corals\Modules\Ecommerce\DataTables\OrdersDataTable;
use Corals\Modules\Ecommerce\Http\Requests\ProductRequest;
use Corals\Modules\Ecommerce\Models\Order;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;

class OrdersController extends BaseController
{

    protected $shipping;

    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.order.resource_url');
        $this->title = 'Ecommerce::module.order.title';
        $this->title_singular = 'Ecommerce::module.order.title_singular';
        parent::__construct();
    }

    protected function canAccess($order)
    {
        $canAccess = false;

        if (user()->hasPermissionTo('Ecommerce::my_orders.access') && $order->user->id == user()->id) {
            $canAccess = true;
        } elseif (user()->hasPermissionTo('Ecommerce::orders.access')) {
            $canAccess = true;
        }

        if (!$canAccess) {
            abort(403);
        }
    }

    /**
     * @param Request $request
     * @param OrdersDataTable $dataTable
     * @return mixed
     */
    public function index(Request $request, OrdersDataTable $dataTable)
    {
        if (!user()->hasPermissionTo('Ecommerce::orders.access')) {
            abort(403);
        }

        return $dataTable->render('Ecommerce::orders.index');
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return $this
     */
    public function edit(Request $request, Order $order)
    {
        if (!user()->hasPermissionTo('Ecommerce::order.update')) {
            abort(403);
        }

        $order_statuses = trans(config('ecommerce.models.order.statuses'));
        $shippment_statuses = trans(config('ecommerce.models.order.shippment_statuses'));
        $payment_statuses = trans(config('ecommerce.models.order.payment_statuses'));

        $this->setViewSharedData(['title_singular' => trans('Ecommerce::module.order.update')]);

        return view('Ecommerce::orders.edit')->with(compact('order', 'order_statuses', 'shippment_statuses', 'payment_statuses'));
    }


    /**
     * @param Request $request
     * @param Order $order
     * @return $this
     */
    public function update(Request $request, Order $order)
    {
        if (!user()->hasPermissionTo('Ecommerce::order.update')) {
            abort(403);
        }

        $this->validate($request, ['status' => 'required']);

        try {
            $data = $request->all();

            $shipping = $order->shipping ?? [];

            if ($request->has('shipping')) {
                $shipping = array_replace_recursive($shipping, $data['shipping']);
            }

            $billing = $order->billing ?? [];

            if ($request->has('billing')) {
                $billing = array_replace_recursive($billing, $data['billing']);
            }

            $order->update([
                'status' => $data['status'],
                'shipping' => $shipping,
                'billing' => $billing,
            ]);

            if ($request->has('notify_buyer')) {
                event('notifications.e_commerce.order.updated', ['order' => $order]);

            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Order::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param Request $request
     * @param MyOrdersDataTable $dataTable
     * @return mixed
     */
    public function myOrders(Request $request, MyOrdersDataTable $dataTable)
    {
        if (!user()->hasPermissionTo('Ecommerce::my_orders.access')) {
            abort(403);
        }

        return $dataTable->render('Ecommerce::orders.index');
    }

    /**
     * @param Request $request
     * @param MyOrdersDataTable $dataTable
     * @return mixed
     */
    public function myPrivatePages(Request $request, MyPrivatePagesDataTable $dataTable)
    {
        if (!user()->hasPermissionTo('Ecommerce::my_orders.access')) {
            abort(403);
        }

        return $dataTable->render('Ecommerce::orders.private_pages');
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function myDownloads(Request $request)
    {
        CoralsBuilder::DataTableScripts();

        if (!user()->hasPermissionTo('Ecommerce::my_orders.access')) {
            abort(403);
        }

        $orders = Order::myOrders()->get();

        return view('Ecommerce::orders.downloads')->with(compact('orders'));
    }


    /**
     * @param Request $request
     * @param Order $order
     * @return $this
     */
    public function show(Request $request, Order $order)
    {
        $this->canAccess($order);

        return view('Ecommerce::orders.show')->with(compact('order'));
    }


    public function downloadFile(Request $request, Order $order, $hashed_id)
    {
        $this->canAccess($order);

        $id = hashids_decode($hashed_id);

        $media = Media::findOrfail($id);

        return response()->download(storage_path($media->getUrl()));
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return $this
     */
    public function track(Request $request, Order $order)
    {
        if (user()->hasPermissionTo('Ecommerce::orders.access') || user()->hasPermissionTo('Ecommerce::my_orders.access')) {
            try {
                $tracking = \Shipping::track($order);
                return view('Ecommerce::orders.track')->with(compact('order', 'tracking'));
            } catch
            (\Exception $exception) {
                log_exception($exception, 'OrderController', 'Track');
            }
        }

        abort(403);
    }

}