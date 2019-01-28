<?php

namespace Corals\User\Models;

use Corals\Foundation\Traits\Hookable;
use Corals\Foundation\Traits\HashTrait;
use Corals\Foundation\Traits\Language\Translatable;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Settings\Traits\CustomFieldsModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;
use Yajra\Auditable\AuditableTrait;
use Corals\Foundation\Traits\ModelPropertiesTrait;


class Role extends SpatieRole
{
    use PresentableTrait, LogsActivity, HashTrait, AuditableTrait, Hookable, CustomFieldsModelTrait, Translatable, ModelPropertiesTrait;
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'user.models.role';

    protected static $logAttributes = ['name'];
}