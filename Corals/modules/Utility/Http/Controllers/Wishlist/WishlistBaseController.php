<?php

namespace Corals\Modules\Utility\Http\Controllers\Wishlist;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Utility\Classes\Wishlist\WishlistManager;
use Corals\Modules\Utility\Models\Wishlist\Wishlist;
use Illuminate\Http\Request;

class WishlistBaseController extends BaseController
{
    protected $wishlistableClass = null;
    protected $redirectUrl = null;
    protected $addSuccessMessage = 'Utility::messages.wishlist.success.add';
    protected $deleteSuccessMessage = 'Utility::messages.wishlist.success.delete';

    public function __construct()
    {
        $this->setCommonVariables();

        $this->corals_middleware_except = array_merge($this->corals_middleware_except, ['setWishlist']);

        parent::__construct();
    }

    protected function setCommonVariables()
    {
        $this->wishlistableClass = null;
        $this->redirectUrl = null;
    }

    /**
     * @param Request $request
     * @param $wishlistable_hashed_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setWishlist(Request $request, $wishlistable_hashed_id)
    {
        try {
            if (is_null($this->wishlistableClass)) {
                abort(400);
            }

            $wishlistable = $this->wishlistableClass::findByHash($wishlistable_hashed_id);

            if (!$wishlistable) {
                abort(404);
            }

            if (!user()) {
                $message = ['level' => 'error', 'message' => trans('Utility::messages.wishlist.require_login', ['item' => class_basename($this->wishlistableClass)])];
            } else {
                $wishlistManager = new WishlistManager($wishlistable, user());

                $state = $wishlistManager->handleWishlistItem();

                if ($state == 'add') {
                    $message = ['level' => 'success', 'message' => trans($this->addSuccessMessage, ['item' => class_basename($this->wishlistableClass)]), 'action' => 'add', 'hashed_id' => $wishlistable->hashed_id];
                } else {
                    $message = ['level' => 'success', 'message' => trans($this->deleteSuccessMessage, ['item' => class_basename($this->wishlistableClass)]), 'action' => 'remove', 'hashed_id' => $wishlistable->hashed_id];
                }
            }

        } catch (\Exception $exception) {
            log_exception($exception, get_class($this), 'setWishlist');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        if ($request->ajax() || is_null($this->redirectUrl) || $request->wantsJson()) {
            return response()->json($message);
        } else {
            if ($message['level'] === 'success') {
                flash($message['message'])->success();
            } else {
                flash($message['message'])->error();
            }
            redirectTo($this->redirectUrl);
        }
    }


    /**
     * @param Request $request
     * @param Wishlist $wishlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Wishlist $wishlist)
    {
        try {
            if (!user()->can('Utility::my_wishlist.access')) {
                abort(403);
            }

            $wishlist->delete();

            $message = ['level' => 'success', 'message' => trans($this->deleteSuccessMessage, ['item' => class_basename($this->wishlistableClass)])];
        } catch (\Exception $exception) {
            log_exception($exception, get_class($this), 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}