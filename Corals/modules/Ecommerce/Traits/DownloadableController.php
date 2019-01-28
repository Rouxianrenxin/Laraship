<?php

namespace Corals\Modules\Ecommerce\Traits;


use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;

trait DownloadableController
{
    /**
     * @param Request $request
     * @param $model
     */
    protected function handleDownloads(Request $request, $model)
    {
        $collectionName = 'product-downloads';

        foreach ($request->get('downloads', []) as $index => $download) {
            if ($request->hasFile("downloads.$index.file")) {
                $model->addMedia($request->file("downloads.$index.file"))
                    ->withCustomProperties([
                        'root' => 'user_' . user()->hashed_id,
                        'description' => $request->input("downloads.$index.description")
                    ])->toMediaCollection($collectionName, 'secure_media');
            }
        }

        foreach ($request->get('cleared_downloads', []) as $hashedId) {
            $media = Media::find(hashids_decode($hashedId));
            if ($media) {
                $media->delete();

            }
        }
    }
}