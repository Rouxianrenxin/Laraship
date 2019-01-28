<?php

namespace Corals\Modules\Directory\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DirectorySettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            [
                'code' => 'directory_google_address_api_key',
                'type' => 'TEXT',
                'category' => 'Directory',
                'label' => 'Google address api key',
                'value' => 'AIzaSyBrMjtZWqBiHz1Nr9XZTTbBLjvYFICPHDM',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'contact_info',
                'type' => 'SELECT',
                'category' => 'Directory',
                'label' => 'Contact Methods',
                'value' => '{"email":"Email","phone_number":"Phone Number","whatsapp":"WhatsApp"}',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'directory_wishlist_enable',
                'type' => 'BOOLEAN',
                'category' => 'Directory',
                'label' => 'Enable Wishlist',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'directory_rating_enable',
                'type' => 'BOOLEAN',
                'category' => 'Directory',
                'label' => 'Enable Rating',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'directory_appearance_page_limit',
                'type' => 'number',
                'category' => 'Directory',
                'label' => 'Product page limit',
                'value' => 10,
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'directory_auth_theme',
                'type' => 'TEXT',
                'category' => 'Directory',
                'label' => 'Auth theme code',
                'value' => 'corals-directory-basic',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'listing_default_rating_status',
                'type' => 'TEXT',
                'category' => 'Directory',
                'label' => 'Default Rating Status',
                'value' => 'approved',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'directory_default_listing_status',
                'type' => 'TEXT',
                'category' => 'Directory',
                'label' => 'Default Listing Status',
                'value' => 'active',
                'editable' => 1,
                'hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
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
    }
}
