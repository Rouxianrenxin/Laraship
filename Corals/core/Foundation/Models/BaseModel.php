<?php

namespace Corals\Foundation\Models;

use Corals\Foundation\Traits\HashTrait;
use Corals\Foundation\Traits\Hookable;
use Corals\Foundation\Traits\Language\Translatable;
use Corals\Foundation\Traits\ModelHelpersTrait;
use Corals\Settings\Traits\CustomFieldsModelTrait;
use Corals\Settings\Traits\HasSettings;
use Corals\Foundation\Traits\BaseRelations;
use Illuminate\Database\Eloquent\Model;
use Yajra\Auditable\AuditableTrait;


class BaseModel extends Model
{
    use HashTrait, AuditableTrait, Hookable, CustomFieldsModelTrait, ModelHelpersTrait, Translatable, HasSettings, BaseRelations;

    protected static function boot()
    {
        parent::boot();
    }

    /**
     * BaseModel constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->initialize();

        return parent::__construct($attributes);
    }

    /**
     * init model
     */
    public function initialize()
    {
        $config = config($this->config);

        if ($config) {
            if (isset($config['presenter'])) {
                $this->setPresenter(new $config['presenter']);
                unset($config['presenter']);
            }

            foreach ($config as $key => $val) {
                if (property_exists(get_called_class(), $key)) {
                    $this->$key = $val;
                }
            }
        }
    }

    /**
     * @return null|string
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function getThumbnailAttribute()
    {
        $media = $this->getFirstMedia($this->mediaCollectionName);

        if ($media) {
            return $media->getFullUrl();
        } else {
            return asset(config($this->config . '.default_image'));
        }
    }



}
