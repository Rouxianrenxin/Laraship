<?php

namespace Corals\Modules\Utility\Http\Controllers\Gallery;

use Corals\Foundation\Facades\Actions;
use Corals\Foundation\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;


class GalleryController extends BaseController
{
    /**
     * @param Request $request
     * @param $galleryModelHashedId
     * @return string
     * @throws \Throwable
     */
    public function gallery(Request $request, $galleryModelHashedId)
    {
        try {
            $modelClass = $request->get('model_class');

            $galleryModel = $this->getGalleryModelByHash($modelClass, $galleryModelHashedId);

            $editable = true;

            return view('Utility::gallery.gallery', compact('galleryModel', 'editable'))->render();
        } catch (\Exception $exception) {
            return '';
        }
    }

    protected function getGalleryModelByHash($modelClass, $galleryModelHashedId)
    {
        $galleryModel = null;

        if (class_exists($modelClass)) {
            $galleryModel = $modelClass::findByHash($galleryModelHashedId);
        }

        if (!$galleryModel) {
            throw new ModelNotFoundException();
        }

        return $galleryModel;
    }

    /**
     * @param Request $request
     * @param $galleryModelHashedId
     * @return \Illuminate\Http\JsonResponse
     */
    public function galleryUpload(Request $request, $galleryModelHashedId)
    {
        try {
            if ($request->has('file')) {

                $this->validate($request, [
                    'file' => 'mimes:jpg,jpeg,png|max:' . maxUploadFileSize(),
                    'model_class' => 'required'
                ]);

                $modelClass = $request->get('model_class');

                $galleryModel = $this->getGalleryModelByHash($modelClass, $galleryModelHashedId);

                $galleryModel->addMedia($request->file('file'))
                    ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                    ->toMediaCollection($galleryModel->galleryMediaCollection);

                $message = ['level' => 'success', 'message' => trans('Utility::messages.gallery.success.upload')];
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

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => trans('Utility::module.gallery.media.title')])];
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

            $galleryModel = $media->model()->first();

            $gallery = $galleryModel->getMedia($galleryModel->galleryMediaCollection);

            foreach ($gallery as $item) {
                $item->forgetCustomProperty('featured');
                $item->save();
            }

            $media->setCustomProperty('featured', true);

            $media->save();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.saved', ['item' => trans('Utility::module.gallery.media.title')])];
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, Media::class, 'destroy');
        }

        return response()->json($message);
    }
}