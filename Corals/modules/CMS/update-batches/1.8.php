<?php

use Illuminate\Database\Schema\Blueprint;

if (!\Schema::hasColumn('categories', 'belongs_to')) {

    \Schema::table('categories', function (Blueprint $table) {
        $table->string('belongs_to')->default('post')->after('status');
    });

    \DB::statement("ALTER TABLE `posts` CHANGE COLUMN `type` `type` ENUM('post', 'page', 'news', 'faq') NOT NULL DEFAULT 'post'");

    $cms_menu = \DB::table('menus')->where([
        'parent_id' => 1,// admin
        'key' => 'cms',

    ])->first();

    $cms_menu_id = $cms_menu->id;

    \DB::table('menus')->insert([
            [
                'parent_id' => $cms_menu_id,
                'key' => null,
                'url' => 'cms/faqs',
                'active_menu_url' => 'cms/faqs*',
                'name' => 'FAQ',
                'description' => 'FAQ List Menu Item',
                'icon' => 'fa fa-question-circle-o',
                'target' => null,
                'roles' => '["1"]',
                'order' => 0
            ],
        ]
    );

    \DB::table('permissions')->insert([

        [
            'name' => 'CMS::faq.view',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
        [
            'name' => 'CMS::faq.create',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
        [
            'name' => 'CMS::faq.update',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
        [
            'name' => 'CMS::faq.delete',
            'guard_name' => config('auth.defaults.guard'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
    ]);

    \DB::table('settings')->insert([

        [
            'code' => 'faqs_page_slug',
            'type' => 'TEXT',
            'category' => 'CMS',
            'label' => 'Faqs page slug',
            'value' => 'faqs',
            'editable' => 1,
            'hidden' => 0,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ],
    ]);

}

