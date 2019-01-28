<?php

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
