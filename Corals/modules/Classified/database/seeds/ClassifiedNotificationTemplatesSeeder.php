<?php

namespace Corals\Modules\Classified\database\seeds;

use Corals\User\Communication\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class ClassifiedNotificationTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationTemplate::updateOrCreate(
            ['name' => 'notifications.classified.product.reported'], [
            'friendly_name' => 'Product has been Reported',
            'title' => 'A Product has been reported for abuse',
            'body' => [
                'mail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;"><tr><td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;"><h4 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;"> Product : {product_name} has been reported </h4></td></tr><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;"><p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> {reporter_name} <{reported_email}> has reported the product with message : {report_body}  </p></td></tr><tr><td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;"><h5 style="font-size: 15px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;"> Click <a <a target="_blank" href="{product_link}">here</a> to view product </h5></td></tr></table>',
                'database' => '<p>A Product has been reported for abuse by {reporter_email} <{reporter_name}> : {report_body} Click <a target="_blank" href="{product_link}">Here</a> to view product</p>'
            ],
            'via' => ["mail", "database"],
            'extras' => ['bcc_roles' => [1]]

        ]);

    }
}