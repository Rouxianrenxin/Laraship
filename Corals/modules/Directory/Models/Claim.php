<?php

namespace Corals\Modules\Directory\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Claim extends BaseModel implements HasMedia
{
    use PresentableTrait, HasMediaTrait, LogsActivity;

    public $mediaCollectionName = 'directory-listing-claim';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'directory.models.claim';

    protected $guarded = ['id'];

    protected $table = 'directory_listings_claim';

    protected static $logAttributes = ['brief_desctiption'];

    public function getClaimFileAttribute()
    {
        $media = $this->getFirstMedia($this->mediaCollectionName);

        if ($media) {
            return $media;
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }


    public function canBeDeclined()
    {
        return in_array($this->status, ['approved', 'pending']);
    }

    public function canBeApproved()
    {
        return in_array($this->status, ['declined', 'pending']);
    }

    public function canBePending()
    {
        return in_array($this->status, ['declined', 'approved']);
    }
}
