<?php

namespace Corals\Modules\LicenceManager\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\LicenceManager\Models\Licence;

class LicenceTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('licence_manager.models.licence.resource_url');

        parent::__construct();
    }

    /**
     * @param Licence $licence
     * @return array
     * @throws \Throwable
     */
    public function transform(Licence $licence)
    {
        return [
            'id' => $licence->id,
            'code' => '<a href="' . $licence->getShowURL() . '">' . str_limit($licence->code, 50) . '</a>',
            'status' => trans(config('licence_manager.models.licence.status_options')[$licence->status]) ?? $licence->status,
            'licenceable' => '<a href="' . $licence->licenceable->getShowURL() . '">' . $licence->licenceable->getIdentifier() . '</a>',
            'parent' => $licence->parent ? '<a href="' . $licence->parent->getShowURL() . '">' . $licence->parent->getIdentifier('order_number') . '</a>' : '-',
            'expiry_period' => $licence->expiry_period,
            'expiration_date' => $licence->expiration_date,
            'created_at' => format_date($licence->created_at),
            'updated_at' => format_date($licence->updated_at),
            'action' => $this->actions($licence)
        ];
    }
}