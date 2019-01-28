<?php

namespace Corals\Modules\Subscriptions\database\seeds;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('products')->delete();

        \DB::table('products')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Online Form Builder',
                    'description' => 'Create online forms the easy way. Whether you’re looking to generate leads, conduct customer surveys, find applicants for a job, or register guests for an event, easy-to-use form builder lets you build a customized online form to fit your exact needs in minutes.',
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-11-30 12:23:04',
                    'updated_at' => '2017-12-03 19:19:51',
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'CRM software',
                    'description' => 'CRM software that lets you close more deals in less time.
A good CRM gives you insights into running your business. A smart CRM gives you the information you need in a way that you can use it. An ideal CRM offers you a solution to simplify your processes from day one.  CRM includes the good, the smart, and the ideal in an enterprise-ready package.',
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:05:21',
                    'updated_at' => '2017-12-03 19:05:21',
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Server Hosting',
                    'description' => 'We don\'t offer infrastructure without service. Your application needs more than just a high-performance, reliable cloud infrastructure. Achieving great business outcomes requires knowing how to run the most demanding workloads in a cost-effective way. That\'s why every account includes services and expertise, along with a high-performance, reliable, and secure cloud infrastructure.',
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:04:31',
                    'updated_at' => '2017-12-04 11:04:43',
                ),
        ));

        try {
            \DB::table('media')->insert(array(
                0 =>
                    array(
                        'id' => 5,
                        'model_id' => 1,
                        'model_type' => 'Corals\\Modules\\Subscriptions\\Models\\Product',
                        'collection_name' => 'product-image',
                        'name' => 'form-icon',
                        'file_name' => 'form-icon.svg',
                        'mime_type' => 'image/svg+xml',
                        'disk' => 'media',
                        'size' => 3619,
                        'manipulations' => '[]',
                        'custom_properties' => '{"root":"demo"}',
                        'order_column' => 8,
                        'created_at' => '2017-12-04 12:54:23',
                        'updated_at' => '2017-12-04 12:54:23',
                    ),
                1 =>
                    array(
                        'id' => 6,
                        'model_id' => 2,
                        'model_type' => 'Corals\\Modules\\Subscriptions\\Models\\Product',
                        'collection_name' => 'product-image',
                        'name' => 'crm_icon_modul',
                        'file_name' => 'crm_icon_modul.png',
                        'mime_type' => 'image/png',
                        'disk' => 'media',
                        'size' => 36655,
                        'manipulations' => '[]',
                        'custom_properties' => '{"root":"demo"}',
                        'order_column' => 9,
                        'created_at' => '2017-12-04 12:54:32',
                        'updated_at' => '2017-12-04 12:54:32',
                    ),
                2 =>
                    array(
                        'id' => 7,
                        'model_id' => 3,
                        'model_type' => 'Corals\\Modules\\Subscriptions\\Models\\Product',
                        'collection_name' => 'product-image',
                        'name' => 'Database-Cloud-circle1',
                        'file_name' => 'Database-Cloud-circle1.png',
                        'mime_type' => 'image/png',
                        'disk' => 'media',
                        'size' => 21261,
                        'manipulations' => '[]',
                        'custom_properties' => '{"root":"demo"}',
                        'order_column' => 10,
                        'created_at' => '2017-12-04 12:54:42',
                        'updated_at' => '2017-12-04 12:54:42',
                    ),
            ));
        } catch (\Exception $exception) {

        }

    }
}