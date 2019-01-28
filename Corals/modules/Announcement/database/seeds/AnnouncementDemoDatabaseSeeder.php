<?php

namespace Corals\Modules\Announcement\database\seeds;

use Corals\Modules\Announcement\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementDemoDatabaseSeeder extends Seeder
{
    /**
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    public function run()
    {
        \DB::table('announcements')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title' => 'This Popup is a Demo of Laraship Announcement Module',
                    'link_title' => 'GO TO STORE',
                    'link' => 'https://www.laraship.com/store/',
                    'content' => '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cp-text-container">
                                    <div>
                                    <div class="cp-image-container" style="text-align: center;"><img class="cp-image" src="https://d2wvoz3xcmywg9.cloudfront.net/wp-content/uploads/2018/07/main_logo.png" style="left:0px;top:0px;max-width:305px;" /></div>
                                    
                                    <div class="cp-image-container" style="text-align: center;">&nbsp;</div>
                                    </div>
                                    
                                    <div class="cp-title-container 
                                    ">
                                    <h2 class="cp-title cp_responsive" data-font-size-init="45px" data-line-height-init="45px" style="line-height: 45px; font-size: 45px; text-align: center;">UP TO 100% OFF</h2>
                                    </div>
                                    
                                    <div class="cp-short-desc-container cp-clear  
                                    ">
                                    <div class="cp-short-description cp_responsive cp-clear " data-font-size-init="20px" data-line-height-init="20px" style="line-height: 20px; font-size: 20px; text-align: center;">LIMITED TIME OFFER</div>
                                    </div>
                                    
                                    <div class="form-main cp-form-layout-4" style="text-align: center;">&nbsp;</div>
                                    
                                    <div class="form-main cp-form-layout-4" style="text-align: center;"><strong><span style="font-size: 10px;">Offer Expires August 31</span></strong></div>
                                    </div>',
                    'starts_at' => '2018-08-02',
                    'ends_at' => '2020-08-10',
                    'show_immediately' => 1,
                    'is_public' => 1,
                    'show_in_url' => NULL,
                    'properties' => NULL,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_at' => NULL,
                    'created_at' => '2018-08-09 07:01:48',
                    'updated_at' => '2018-08-09 08:58:24',
                ),
            1 =>
                array(
                    'id' => 2,
                    'title' => '50% Discount Summer Sale on All Laraship Products',
                    'link_title' => 'Claim Your Discount',
                    'link' => 'https://www.laraship.com/store/',
                    'content' => '<div class="" style="background-image:url(https://d2wvoz3xcmywg9.cloudfront.net/wp-content/uploads/2018/06/black.jpg);background-repeat: repeat;background-position: center;background-size: auto;border-radius: 10px;min-height: 444px;">


<div class="cp-row">
<div class="">
<div>
<p style="text-align: center;"><a><img class="cp-image" src="https://d2wvoz3xcmywg9.cloudfront.net/wp-content/uploads/2018/06/ComingSoon.png" style="max-width:150px;margin-top: 25px;"></a></p>
</div>

<div class="cp-title-container 
">
<h2 class="cp-title cp_responsive" data-font-size-init="45px" data-line-height-init="45px" style="line-height: 45px; font-size: 45px; text-align: center;"><span><span style="color:#FFFFFF;">50% OFF</span></span></h2>
</div>

<div class="cp-short-desc-container cp-clear  
">
<div class="cp-short-description cp_responsive cp-clear " data-font-size-init="20px" data-line-height-init="20px" style="line-height: 20px; font-size: 20px; text-align: center;"><span class="cp_responsive cp_line_height" data-line-height="30px" style="line-height: 30px; font-size: 20px;"><span data-line-height="20px"><span><span style="color:#FFFFFF;">NO MINIMUMS. NO EXCLUSIONS</span><br>
<span style="color:#FFFFFF;">Coupon Code - </span><span style="color:#5bb9e5;"><span style="font-weight:bold;">LARASHIP08</span></span></span></span></span></div>

<div class="cp-short-description cp_responsive cp-clear " data-font-size-init="20px" data-line-height-init="20px" style="line-height: 20px; font-size: 20px; text-align: center;">&nbsp;</div>

<div class="cp-short-description cp_responsive cp-clear " data-font-size-init="20px" data-line-height-init="20px" style="line-height: 20px; font-size: 20px; text-align: center;">&nbsp;</div>

<div class="cp-short-description cp_responsive cp-clear " data-font-size-init="20px" data-line-height-init="20px" style="line-height: 20px; font-size: 20px; text-align: center;">&nbsp;</div>

<div class="cp-short-description cp_responsive cp-clear " data-font-size-init="20px" data-line-height-init="20px" style="line-height: 20px; font-size: 20px; text-align: center;">&nbsp;</div>

<div class="cp-short-description cp_responsive cp-clear " data-font-size-init="20px" data-line-height-init="20px" style="line-height: 20px; font-size: 20px; text-align: center;">&nbsp;</div>
</div>
</div>
</div>
</div>',
                    'starts_at' => '2018-08-10',
                    'ends_at' => '2018-09-08',
                    'show_immediately' => 0,
                    'is_public' => 0,
                    'show_in_url' => NULL,
                    'properties' => NULL,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_at' => NULL,
                    'created_at' => '2018-08-10 08:24:24',
                    'updated_at' => '2018-08-10 14:29:28',
                ),
        ));
        $announcement = Announcement::find(1);

        $announcement->addMediaFromUrl('https://d2wvoz3xcmywg9.cloudfront.net/wp-content/uploads/2018/05/laraship-subcription.png')
            ->withCustomProperties(['root' => 'demo_announcement'])
            ->toMediaCollection($announcement->mediaCollectionName);

        $announcement = Announcement::find(2);

        $announcement->addMediaFromUrl('https://d2wvoz3xcmywg9.cloudfront.net/wp-content/uploads/2018/08/laraship_laravel_tablet-e1533376014700.png')
            ->withCustomProperties(['root' => 'demo_announcement'])
            ->toMediaCollection($announcement->mediaCollectionName);

    }
}
