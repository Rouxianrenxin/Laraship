<?php

use Illuminate\Database\Schema\Blueprint;
use Carbon\Carbon;

\Schema::create('directory_listings_claim', function (Blueprint $table) {
    $table->increments('id');
    $table->text('brief_desctiption')->nullable();
    $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
    $table->unsignedInteger('listing_id')->index();
    $table->unsignedInteger('created_by')->nullable()->index();
    $table->unsignedInteger('updated_by')->nullable()->index();
    $table->softDeletes();
    $table->timestamps();
    $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
    $table->foreign('listing_id')->references('id')->on('directory_listings')->onDelete('cascade')->onUpdate('cascade');
});

\DB::statement('ALTER TABLE `directory_listings` MODIFY `user_id` INTEGER UNSIGNED NULL;');
\DB::statement("ALTER TABLE `directory_listings` CHANGE COLUMN `status` `status` ENUM('active', 'inactive', 'archived', 'pending') NOT NULL DEFAULT 'pending'");


$directory_menu = \DB::table('menus')->where([
    'parent_id' => 1,// admin
    'key' => 'directory',

])->first();

$directory_menu_id = $directory_menu->id;

\DB::table('menus')->insert([

        [
            'parent_id' => $directory_menu_id,
            'key' => null,
            'url' => 'directory/claims',
            'active_menu_url' => 'directory/claims*',
            'name' => 'Claims',
            'description' => 'Listings Claims List Menu Item',
            'icon' => 'fa fa-paperclip',
            'target' => null,
            'roles' => '["1"]',
            'order' => 0
        ], [
            'parent_id' => $directory_menu_id,
            'key' => null,
            'url' => 'directory/user/reviews',
            'active_menu_url' => 'directory/user/reviews*',
            'name' => 'Reviews',
            'description' => 'Reviews',
            'icon' => 'fa fa-star',
            'target' => null,
            'roles' => '["2"]',
            'order' => 3
        ],
        [
            'parent_id' => $directory_menu_id,
            'key' => null,
            'url' => 'directory/user/invite-friends',
            'active_menu_url' => 'directory/user/invite-friends',
            'name' => 'Invite Friends',
            'description' => 'Invite Friends',
            'icon' => 'fa fa-paper-plane-o',
            'target' => null,
            'roles' => '["2"]',
            'order' => 33
        ],
    ]
);

\DB::table('permissions')->insert([

    [
        'name' => 'Administrations::admin.directory',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'name' => 'Directory::claim.view',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'name' => 'Directory::claim.create',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'name' => 'Directory::claim.update',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'name' => 'Directory::claim.set_status',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'name' => 'Directory::claim.delete',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],

]);

$member_role = \Corals\User\Models\Role::where('name', 'member')->first();

if ($member_role) {
    $member_role->givePermissionTo('Directory::claim.create');

}

\DB::table('settings')->insert([
    [
        'code' => 'listing_default_rating_status',
        'type' => 'TEXT',
        'category' => 'Directory',
        'label' => 'Default Rating Status approved|disapproved|spam|pending',
        'value' => 'approved',
        'editable' => 1,
        'hidden' => 0,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'code' => 'directory_default_listing_status',
        'type' => 'TEXT',
        'category' => 'Directory',
        'label' => 'Default Listing Status',
        'value' => 'active',
        'editable' => 1,
        'hidden' => 0,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'code' => 'directory_messaging_is_enable',
        'type' => 'BOOLEAN',
        'category' => 'Directory',
        'label' => 'Enable Internal Messaging',
        'value' => 'true',
        'editable' => 1,
        'hidden' => 0,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'code' => 'directory_invitation_subject',
        'type' => 'TEXT',
        'category' => 'Directory',
        'label' => 'Invitation Subject',
        'value' => 'You have been invited to Corals Directory',
        'editable' => 1,
        'hidden' => 0,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'code' => 'directory_invitation_text',
        'type' => 'TEXTAREA',
        'category' => 'Directory',
        'label' => 'Invitation Text',
        'value' => 'Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Praesent ac massa at ligula laoreet iaculis. Praesent ac massa at ligula laoreet iaculis. Donec id justo. In ac felis quis tortor malesuada pretium.',
        'editable' => 1,
        'hidden' => 0,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
]);

\Corals\User\Communication\Models\NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.listing_created'], [
    'friendly_name' => 'Listing Created',
    'title' => '{listing_name} listing has been created',
    'extras' => [
        "bcc_users" => ["1"]
    ],
    'body' => [
        'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Hello there,</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
New listing "<b>{listing_name}</b>" has been created by {user_name} ({user_email}).
<br/>
Thanks.
</p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{listing_link}" target="_blank" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Show Listing</a></td></tr></tbody></table></td></tr></tbody></table>',
        'database' => 'New listing "<b>{listing_name}</b>" has been created by {user_name} ({user_email}).'
    ],
    'via' => ["mail", "database"]
]);


\Corals\User\Communication\Models\NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.listing_approved'], [
    'friendly_name' => 'Listing Created',
    'title' => '{listing_name} listing has been approved',
    'extras' => [
        "bcc_users" => ["1"]
    ],
    'body' => [
        'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Hello there,</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
Congratulations!, your listing "<b>{listing_name}</b>" has been approved by admin).
<br/>
Thanks.
</p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{listing_link}" target="_blank" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Show Listing</a></td></tr></tbody></table></td></tr></tbody></table>',
        'database' => 'listing "<b>{listing_name}</b>" has been approved!.'
    ],
    'via' => ["mail", "database"]
]);


\Corals\User\Communication\Models\NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.listing_rejected'], [
    'friendly_name' => 'Listing Created',
    'title' => '{listing_name} listing has been disaproved',
    'extras' => [
        "bcc_users" => ["1"]
    ],
    'body' => [
        'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
                <p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Hello there,</p>
                <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
                <br/>
                Hello,We are are sorry to inform you that your listing "<b>{listing_name}</b>" has been rejected by admin).
                <br/>
                Thanks.
                </p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{listing_link}" target="_blank" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Show Listing</a></td></tr></tbody></table></td></tr></tbody></table>',
        'database' => 'listing "<b>{listing_name}</b>" has been rejected!.'
    ],
    'via' => ["mail", "database"]
]);


\Corals\User\Communication\Models\NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.listing_claim'], [
    'friendly_name' => 'Claim Listing',
    'title' => '{user_name} has submitted a claim request for listing {listing_name}',
    'extras' => [
        "bcc_users" => ["1"]
    ],
    'body' => [
        'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Hello there,</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
<b>{user_name}</b> has submitted a claim request for listing "<b>{listing_name}</b>".
<br/>
<br/>
User E-Mail: {user_email}.<br />
<br/>
<br/>
Check the following details for listing:
<br/>
Listing Name: {listing_name},<br/>

<br/>
<br/>
Check the following details for claim:
<br/>

Brief Desctiption: {brief_desctiption},<br/>
<br/>
<br/>

Thanks.',
        'database' => '"<b>{user_name}</b>" has claimd for listing "<b>{listing_name}</b>".'
    ],
    'via' => ["mail", "database"]
]);

\Corals\User\Communication\Models\NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.claim_approved_status'], [
    'friendly_name' => 'Claim has Approved',
    'title' => 'Congratulations!, your claim for listing has {listing_name} has been approved',
    'extras' => [
        "bcc_users" => ["1"]
    ],
    'body' => [
        'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Hello {user_name},</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
we are happy to inform you that your claim for "<b>{listing_name}</b>" has been approved, listing is now attached to your account.
<br/>
<br/>
Check the following details for listing:
<br/>
Listing: {listing_name},<br/>

<br/>
<br/>
Check the following details for claim:
<br/>
Claim status: {claim_status},<br/>
Brief Desctiption: {brief_desctiption},<br/>

<br/>
<br/>
Thank you {user_name}.
</p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;">

<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{listing_link}" target="_blank" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Show Listing</a></td></tr></tbody></table></td></tr></tbody></table>',
        'database' => '"<b>{listing_name}</b>" That you are claimed for "<b>{claim_status}</b>".'
    ],
    'via' => ["mail", "database"]
]);

\Corals\User\Communication\Models\NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.claim_decline_status'], [
    'friendly_name' => 'Claim Decline Status',
    'title' => 'Your claim has been disapproved',
    'extras' => [
        "bcc_users" => ["1"]
    ],
    'body' => [
        'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Hello there,</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
We are sorry to inform you that your claim has been rejected.
<br/>
<br/>
Check the following details for listing:
<br/>
Listing: {listing_name},<br/>

<br/>
<br/>
Check the following details for claim:
<br/>
Claim status: {claim_status},<br/>
Brief Desctiption: {brief_desctiption},<br/>
Reasons: {reasons}
<br/>
<br/>
Thank you {user_name}.
</p></td></tr><tr><td align="center" style="padding: 10px 0 25px 0;">

<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td align="center" bgcolor="#ed8e20" style="border-radius: 5px;"><a href="{listing_link}" target="_blank" style="font-size: 18px; font-family: Open Sans, Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 5px; background-color: #ed8e20; padding: 15px 30px; border: 1px solid #ed8e20; display: block;" target="_blank">Show Listing</a></td></tr></tbody></table></td></tr></tbody></table>',
        'database' => 'Your claim for listing: "<b>{listing_name}</b>" has been "<b>rejected</b>".'
    ],
    'via' => ["mail", "database"]
]);
