<?php

namespace Corals\Modules\Newsletter\database\seeds;

use Carbon\Carbon;
use Corals\Modules\Newsletter\Models\Subscriber;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class NewsletterSamplesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $samples = ['Corals', 'Electronics', 'Sports', 'Gaming', 'Cooking',
            'Digital Arts', 'Puzzles', 'Fashion', 'Travel', 'Photography'];

        $mail_list_samples = [];

        foreach ($samples as $sample) {
            $mail_list_samples[] = [
                'name' => $sample,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('newsletter_mail_lists')->insert($mail_list_samples);

        $subscribersFaker = [];

        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            $subscribersFaker[] = [
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('newsletter_subscribers')->insert($subscribersFaker);

        $subscribers = Subscriber::all();

        foreach ($subscribers as $subscriber) {
            $mail_list_count = rand(1, 10);

            $subscriber->mailLists()->sync(range(1, $mail_list_count));
        }
    }
}
