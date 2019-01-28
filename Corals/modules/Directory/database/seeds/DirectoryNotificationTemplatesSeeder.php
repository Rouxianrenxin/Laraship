<?php

namespace Corals\Modules\Directory\database\seeds;

use Corals\User\Communication\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class DirectoryNotificationTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.listing_approved'], [
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


        NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.listing_rejected'], [
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





        NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.listing_claim'], [
            'friendly_name' => 'Claim Listing',
            'title' => '{user_name} claimed for listing {listing_name}',
            'extras' => [
                "bcc_users" => ["1"]
            ],
            'body' => [
                'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"><tbody><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px;">
<p style="font-size: 18px; font-weight: 800; line-height: 24px; color: #333333;">Hello there,</p>
<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
<br/>
<b>{user_name}</b> has claimd for listing "<b>{listing_name}</b>".
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



        NotificationTemplate::updateOrCreate(['name' => 'notifications.directory.claim_decline_status'], [
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
    }
}
