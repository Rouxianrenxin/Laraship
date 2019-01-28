<?php

namespace Corals\Modules\Ecommerce\Traits;

use Corals\Foundation\Facades\Actions;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;

trait EcommerceGallery
{

    /**
     * @param Request $request
     * @param $product
     * @return string
     * @throws \Throwable
     */
    public function gallery(Request $request, $product)
    {
        if ($request->is('*classified*')) {
            $product = \Corals\Modules\Classified\Models\Product::findByHash($product);
        } else {
            $product = \Corals\Modules\Ecommerce\Models\Product::findByHash($product);
        }
        $editable = true;
        return view('Ecommerce::products.gallery', compact('product', 'editable'))->render();
    }

    /**
     * @param Request $request
     * @param $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function galleryUpload(Request $request, $product)
    {
        if ($request->is('*classified*')) {
            $product = \Corals\Modules\Classified\Models\Product::findByHash($product);
        } else {
            $product = \Corals\Modules\Ecommerce\Models\Product::findByHash($product);
        }

        try {
            if ($request->has('file')) {

                $this->validate($request, [
                    'file' => 'mimes:jpg,jpeg,png|max:' . maxUploadFileSize(),
                ]);

                $product->addMedia($request->file('file'))->withCustomProperties(['root' => 'user_' . user()->hashed_id])->toMediaCollection($product->galleryMediaCollection);

                $message = ['level' => 'success', 'message' => trans(trans('Ecommerce::labels.product.image_upload'))];
            }
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, 'Gallery', 'destroy');
        }

        return response()->json($message);
    }

    /**
     * @param Request $request
     * @param $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function galleryItemDelete(Request $request, $media)
    {
        try {
            $media = Media::findOrFail($media);

            Actions::do_action('pre_update_gallery', $media);

            $media->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => trans('Ecommerce::module.product.media_title')])];
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, Media::class, 'destroy');
        }

        return response()->json($message);
    }

    public function galleryItemFeatured(Request $request, $media)
    {
        try {
            $media = Media::findOrFail($media);

            Actions::do_action('pre_update_gallery', $media);

            $product = $media->model()->first();

            $gallery = $product->getMedia($product->galleryMediaCollection);

            foreach ($gallery as $item) {
                $item->forgetCustomProperty('featured');
                $item->save();
            }

            $media->setCustomProperty('featured', true);

            $media->save();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.saved', ['item' => trans('Ecommerce::module.product.media_title')])];
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, Media::class, 'destroy');
        }

        return response()->json($message);
    }
}