<?php

namespace Corals\Modules\Subscriptions\database\seeds;

use Illuminate\Database\Seeder;

class FeaturePlanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('feature_plan')->delete();

        \DB::table('feature_plan')->insert(array(
            0 =>
                array(
                    'id' => 34,
                    'plan_id' => 2,
                    'feature_id' => 1,
                    'value' => '100',
                ),
            1 =>
                array(
                    'id' => 35,
                    'plan_id' => 2,
                    'feature_id' => 2,
                    'value' => '5',
                ),
            2 =>
                array(
                    'id' => 36,
                    'plan_id' => 2,
                    'feature_id' => 3,
                    'value' => '1000',
                ),
            3 =>
                array(
                    'id' => 37,
                    'plan_id' => 2,
                    'feature_id' => 4,
                    'value' => '500',
                ),
            4 =>
                array(
                    'id' => 38,
                    'plan_id' => 2,
                    'feature_id' => 5,
                    'value' => 'Basic',
                ),
            5 =>
                array(
                    'id' => 40,
                    'plan_id' => 3,
                    'feature_id' => 1,
                    'value' => '10',
                ),
            6 =>
                array(
                    'id' => 41,
                    'plan_id' => 3,
                    'feature_id' => 2,
                    'value' => '25',
                ),
            7 =>
                array(
                    'id' => 42,
                    'plan_id' => 3,
                    'feature_id' => 3,
                    'value' => '10000',
                ),
            8 =>
                array(
                    'id' => 43,
                    'plan_id' => 3,
                    'feature_id' => 4,
                    'value' => '1000',
                ),
            9 =>
                array(
                    'id' => 44,
                    'plan_id' => 3,
                    'feature_id' => 5,
                    'value' => 'Intermediate',
                ),
            10 =>
                array(
                    'id' => 45,
                    'plan_id' => 3,
                    'feature_id' => 6,
                    'value' => '1',
                ),
            11 =>
                array(
                    'id' => 46,
                    'plan_id' => 4,
                    'feature_id' => 1,
                    'value' => '1000',
                ),
            12 =>
                array(
                    'id' => 47,
                    'plan_id' => 4,
                    'feature_id' => 2,
                    'value' => '100',
                ),
            13 =>
                array(
                    'id' => 48,
                    'plan_id' => 4,
                    'feature_id' => 3,
                    'value' => '100000',
                ),
            14 =>
                array(
                    'id' => 49,
                    'plan_id' => 4,
                    'feature_id' => 4,
                    'value' => '10000',
                ),
            15 =>
                array(
                    'id' => 50,
                    'plan_id' => 4,
                    'feature_id' => 5,
                    'value' => 'Advanced',
                ),
            16 =>
                array(
                    'id' => 51,
                    'plan_id' => 4,
                    'feature_id' => 6,
                    'value' => '1',
                ),
            17 =>
                array(
                    'id' => 52,
                    'plan_id' => 5,
                    'feature_id' => 1,
                    'value' => '1000',
                ),
            18 =>
                array(
                    'id' => 53,
                    'plan_id' => 5,
                    'feature_id' => 2,
                    'value' => '1000',
                ),
            19 =>
                array(
                    'id' => 54,
                    'plan_id' => 5,
                    'feature_id' => 3,
                    'value' => '100000',
                ),
            20 =>
                array(
                    'id' => 55,
                    'plan_id' => 5,
                    'feature_id' => 4,
                    'value' => 'Unlimited',
                ),
            21 =>
                array(
                    'id' => 56,
                    'plan_id' => 5,
                    'feature_id' => 5,
                    'value' => 'Advanced',
                ),
            22 =>
                array(
                    'id' => 57,
                    'plan_id' => 5,
                    'feature_id' => 6,
                    'value' => '1',
                ),
            23 =>
                array(
                    'id' => 58,
                    'plan_id' => 6,
                    'feature_id' => 7,
                    'value' => '5',
                ),
            24 =>
                array(
                    'id' => 59,
                    'plan_id' => 6,
                    'feature_id' => 9,
                    'value' => '2',
                ),
            25 =>
                array(
                    'id' => 60,
                    'plan_id' => 6,
                    'feature_id' => 10,
                    'value' => '1',
                ),
            26 =>
                array(
                    'id' => 61,
                    'plan_id' => 6,
                    'feature_id' => 11,
                    'value' => '30000',
                ),
            27 =>
                array(
                    'id' => 62,
                    'plan_id' => 7,
                    'feature_id' => 7,
                    'value' => '100',
                ),
            28 =>
                array(
                    'id' => 63,
                    'plan_id' => 7,
                    'feature_id' => 8,
                    'value' => '1',
                ),
            29 =>
                array(
                    'id' => 64,
                    'plan_id' => 7,
                    'feature_id' => 9,
                    'value' => '20',
                ),
            30 =>
                array(
                    'id' => 65,
                    'plan_id' => 7,
                    'feature_id' => 10,
                    'value' => '1',
                ),
            31 =>
                array(
                    'id' => 66,
                    'plan_id' => 7,
                    'feature_id' => 11,
                    'value' => '100000',
                ),
            32 =>
                array(
                    'id' => 67,
                    'plan_id' => 8,
                    'feature_id' => 7,
                    'value' => '200',
                ),
            33 =>
                array(
                    'id' => 68,
                    'plan_id' => 8,
                    'feature_id' => 8,
                    'value' => '1',
                ),
            34 =>
                array(
                    'id' => 69,
                    'plan_id' => 8,
                    'feature_id' => 9,
                    'value' => '2000',
                ),
            35 =>
                array(
                    'id' => 70,
                    'plan_id' => 8,
                    'feature_id' => 10,
                    'value' => '1',
                ),
            36 =>
                array(
                    'id' => 71,
                    'plan_id' => 8,
                    'feature_id' => 11,
                    'value' => '199998',
                ),
            37 =>
                array(
                    'id' => 72,
                    'plan_id' => 9,
                    'feature_id' => 12,
                    'value' => '100',
                ),
            38 =>
                array(
                    'id' => 73,
                    'plan_id' => 9,
                    'feature_id' => 13,
                    'value' => '1',
                ),
            39 =>
                array(
                    'id' => 74,
                    'plan_id' => 9,
                    'feature_id' => 14,
                    'value' => '5',
                ),
            40 =>
                array(
                    'id' => 75,
                    'plan_id' => 9,
                    'feature_id' => 15,
                    'value' => '5',
                ),
            41 =>
                array(
                    'id' => 76,
                    'plan_id' => 9,
                    'feature_id' => 17,
                    'value' => 'Basic',
                ),
            42 =>
                array(
                    'id' => 77,
                    'plan_id' => 10,
                    'feature_id' => 12,
                    'value' => '1000',
                ),
            43 =>
                array(
                    'id' => 78,
                    'plan_id' => 10,
                    'feature_id' => 13,
                    'value' => '10',
                ),
            44 =>
                array(
                    'id' => 79,
                    'plan_id' => 10,
                    'feature_id' => 14,
                    'value' => '10',
                ),
            45 =>
                array(
                    'id' => 80,
                    'plan_id' => 10,
                    'feature_id' => 15,
                    'value' => '10',
                ),
            46 =>
                array(
                    'id' => 81,
                    'plan_id' => 10,
                    'feature_id' => 16,
                    'value' => '1',
                ),
            47 =>
                array(
                    'id' => 82,
                    'plan_id' => 10,
                    'feature_id' => 17,
                    'value' => 'Basic',
                ),
            48 =>
                array(
                    'id' => 83,
                    'plan_id' => 11,
                    'feature_id' => 12,
                    'value' => '5000',
                ),
            49 =>
                array(
                    'id' => 84,
                    'plan_id' => 11,
                    'feature_id' => 13,
                    'value' => '5',
                ),
            50 =>
                array(
                    'id' => 85,
                    'plan_id' => 11,
                    'feature_id' => 14,
                    'value' => '10',
                ),
            51 =>
                array(
                    'id' => 86,
                    'plan_id' => 11,
                    'feature_id' => 15,
                    'value' => '20',
                ),
            52 =>
                array(
                    'id' => 87,
                    'plan_id' => 11,
                    'feature_id' => 16,
                    'value' => '1',
                ),
            53 =>
                array(
                    'id' => 88,
                    'plan_id' => 11,
                    'feature_id' => 17,
                    'value' => 'High',
                ),
            54 =>
                array(
                    'id' => 89,
                    'plan_id' => 12,
                    'feature_id' => 12,
                    'value' => '10000',
                ),
            55 =>
                array(
                    'id' => 90,
                    'plan_id' => 12,
                    'feature_id' => 13,
                    'value' => '100',
                ),
            56 =>
                array(
                    'id' => 91,
                    'plan_id' => 12,
                    'feature_id' => 14,
                    'value' => '1000',
                ),
            57 =>
                array(
                    'id' => 92,
                    'plan_id' => 12,
                    'feature_id' => 15,
                    'value' => '1000',
                ),
            58 =>
                array(
                    'id' => 93,
                    'plan_id' => 12,
                    'feature_id' => 16,
                    'value' => '1',
                ),
            59 =>
                array(
                    'id' => 94,
                    'plan_id' => 12,
                    'feature_id' => 17,
                    'value' => 'High',
                ),
        ));


    }
}