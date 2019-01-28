<?php

namespace Corals\Modules\Subscriptions\database\seeds;

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('plans')->delete();

        \DB::table('plans')->insert(array(
            0 =>
                array(
                    'id' => 2,
                    'name' => 'Starter',
                    'code' => 'free',
                    'price' => '0.00',
                    'bill_frequency' => 1,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 0,
                    'free_plan' => 1,
                    'display_order' => 1,
                    'description' => 'Starter',
                    'product_id' => 1,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 15:32:53',
                    'updated_at' => '2017-12-03 15:59:11',
                ),
            1 =>
                array(
                    'id' => 3,
                    'name' => 'Bronze',
                    'code' => 'bronze',
                    'price' => '9.50',
                    'bill_frequency' => 1,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 0,
                    'free_plan' => 0,
                    'display_order' => 2,
                    'description' => 'Bronze Plan',
                    'product_id' => 1,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 16:11:40',
                    'updated_at' => '2017-12-03 16:11:40',
                ),
            2 =>
                array(
                    'id' => 4,
                    'name' => 'Silver',
                    'code' => 'silver',
                    'price' => '19.50',
                    'bill_frequency' => 1,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 1,
                    'free_plan' => 0,
                    'display_order' => 2,
                    'description' => 'Silver Plan',
                    'product_id' => 1,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 16:17:59',
                    'updated_at' => '2017-12-03 16:17:59',
                ),
            3 =>
                array(
                    'id' => 5,
                    'name' => 'Gold',
                    'code' => 'gold',
                    'price' => '49.49',
                    'bill_frequency' => 1,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 0,
                    'free_plan' => 0,
                    'display_order' => 4,
                    'description' => 'Gold',
                    'product_id' => 1,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 16:21:24',
                    'updated_at' => '2017-12-03 16:21:24',
                ),
            4 =>
                array(
                    'id' => 6,
                    'name' => 'Basic',
                    'code' => 'basic',
                    'price' => '19.00',
                    'bill_frequency' => 3,
                    'trial_period' => 10,
                    'bill_cycle' => 'month',
                    'recommended' => 0,
                    'free_plan' => 0,
                    'display_order' => 1,
                    'description' => 'For teams up to 5 users',
                    'product_id' => 2,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:23:43',
                    'updated_at' => '2017-12-03 19:23:43',
                ),
            5 =>
                array(
                    'id' => 7,
                    'name' => 'Professional',
                    'code' => 'professional',
                    'price' => '49.00',
                    'bill_frequency' => 3,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 1,
                    'free_plan' => 0,
                    'display_order' => 2,
                    'description' => 'CRM for growing businesses',
                    'product_id' => 2,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:31:56',
                    'updated_at' => '2017-12-03 19:31:56',
                ),
            6 =>
                array(
                    'id' => 8,
                    'name' => 'Business',
                    'code' => 'business',
                    'price' => '119.00',
                    'bill_frequency' => 3,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 0,
                    'free_plan' => 0,
                    'display_order' => 3,
                    'description' => 'Complete CRM for any size business',
                    'product_id' => 2,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-03 19:33:03',
                    'updated_at' => '2017-12-03 19:33:03',
                ),
            7 =>
                array(
                    'id' => 9,
                    'name' => 'Basic',
                    'code' => 'basichosting',
                    'price' => '9.99',
                    'bill_frequency' => 1,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 0,
                    'free_plan' => 0,
                    'display_order' => 1,
                    'description' => 'for Personal use',
                    'product_id' => 3,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:11:49',
                    'updated_at' => '2017-12-04 11:11:49',
                ),
            8 =>
                array(
                    'id' => 10,
                    'name' => 'Corporate',
                    'code' => 'corporate',
                    'price' => '14.98',
                    'bill_frequency' => 1,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 0,
                    'free_plan' => 0,
                    'display_order' => 2,
                    'description' => 'for small companies',
                    'product_id' => 3,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:13:22',
                    'updated_at' => '2017-12-04 11:13:22',
                ),
            9 =>
                array(
                    'id' => 11,
                    'name' => 'Business',
                    'code' => 'bushosting',
                    'price' => '29.00',
                    'bill_frequency' => 1,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 1,
                    'free_plan' => 0,
                    'display_order' => 3,
                    'description' => 'Business recommended plan',
                    'product_id' => 3,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:15:20',
                    'updated_at' => '2017-12-04 11:15:20',
                ),
            10 =>
                array(
                    'id' => 12,
                    'name' => 'Platinuim',
                    'code' => 'platinuim',
                    'price' => '59.98',
                    'bill_frequency' => 1,
                    'trial_period' => 0,
                    'bill_cycle' => 'month',
                    'recommended' => 0,
                    'free_plan' => 0,
                    'display_order' => 4,
                    'description' => 'Platinum Unlimited',
                    'product_id' => 3,
                    'status' => 'active',
                    'deleted_at' => NULL,
                    'created_at' => '2017-12-04 11:16:30',
                    'updated_at' => '2017-12-04 11:16:30',
                ),
        ));

    }
}