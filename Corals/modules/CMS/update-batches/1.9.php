<?php

use Illuminate\Database\Schema\Blueprint;

if (!\Schema::hasTable('cms_blocks')) {


    \Schema::create('cms_blocks', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name')->unique();
        $table->string('key')->unique()->index();
        $table->enum('status', ['active', 'inactive'])->default('active');

        $table->unsignedInteger('created_by')->nullable()->index();
        $table->unsignedInteger('updated_by')->nullable()->index();

        $table->timestamps();
    });
}

if (!\Schema::hasTable('cms_widgets')) {

    \Schema::create('cms_widgets', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title')->nullable();
        $table->unsignedInteger('widget_order')->default(0);
        $table->unsignedInteger('widget_width')->default(12);
        $table->text('content')->nullable();
        $table->unsignedInteger('block_id');
        $table->enum('status', ['active', 'inactive'])->default('active');

        $table->unsignedInteger('created_by')->nullable()->index();
        $table->unsignedInteger('updated_by')->nullable()->index();

        $table->timestamps();

    $table->foreign('block_id')->references('id')->on('cms_blocks')->onDelete('cascade')->onUpdate('cascade');

    });

}
$cms_menu = \DB::table('menus')->where([
    'parent_id' => 1,// admin
    'key' => 'cms',

])->first();
$cms_menu_id = $cms_menu->id;

\DB::table('menus')->insert([
        [
            'parent_id' => $cms_menu_id,
            'key' => null,
            'url' => 'cms/blocks',
            'active_menu_url' => 'cms/blocks*',
            'name' => 'Blocks',
            'description' => 'Block List Menu Item',
            'icon' => 'fa fa-cube',
            'target' => null,
            'roles' => '["1"]',
            'order' => 0
        ],
    ]
);

\DB::table('permissions')->insert([

    [
        'name' => 'CMS::block.view',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'name' => 'CMS::widget.view',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'name' => 'CMS::widget.create',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'name' => 'CMS::widget.update',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
    [
        'name' => 'CMS::widget.delete',
        'guard_name' => config('auth.defaults.guard'),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ],
]);

\Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'faqs', 'type' => 'page'],
    array(
        'title' => 'FAQs',
        'slug' => 'faqs',
        'meta_keywords' => 'faqs',
        'meta_description' => 'FAQs',
        'content' => '<section class="gray-bg" id="sec4">
                        <div class="container">
                            <div class="section-title" style="padding-bottom: 0;">
                                <h2> FAQ</h2>
                                <div class="section-subtitle">popular questions</div>
                                <span class="section-separator"></span>
                                <p>Explore some of the best tips from around the city from our partners and friends.</p>
                            </div>
                        </div>
                    </section>
    <!-- About Section End -->',
        'published' => 1,
        'published_at' => '2018-10-3 11:56:34',
        'private' => 0,
        'type' => 'page',
        'template' => 'full',
        'author_id' => 1,
        'deleted_at' => NULL,
        'created_at' => '2017-11-16 11:56:34',
        'updated_at' => '2017-11-16 11:56:34',
    ));

$block = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'Pre Footer Block', 'key' => 'pre-footer-block'], [
    'name' => 'Pre Footer Block',
    'key' => 'pre-footer-block',
]);

$widgets = array(
    array(
        'title' => 'Free Worldwide Shipping',
        'content' => '<div class="text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/ecommerce-basic/img/services/01.png"
                        alt="Shipping">
                <h6>Free Worldwide Shipping</h6>
                <p class="text-muted margin-bottom-none">Free shipping for all orders over $100</p>
            </div>',
        'block_id' => $block->id,
        'widget_width' => 3,
        'widget_order' => 0,
        'status' => 'active',
    ),
    array(
        'title' => 'Money Back Guarantee',
        'content' => '<div class="text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/ecommerce-basic/img/services/02.png"
                        alt="Money Back">
                <h6>Money Back Guarantee</h6>
                <p class="text-muted margin-bottom-none">We return money within 30 days</p>
            </div>',
        'block_id' => $block->id,
        'widget_width' => 3,
        'widget_order' => 1,
        'status' => 'active',
    ),

    array(
        'title' => '24/7 Customer Support',
        'content' => '<div class="text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/ecommerce-basic/img/services/03.png"
                        alt="Support">
                <h6>24/7 Customer Support</h6>
                <p class="text-muted margin-bottom-none">Friendly 24/7 customer support</p>
            </div>',
        'block_id' => $block->id,
        'widget_width' => 3,
        'widget_order' => 2,
        'status' => 'active',

    ),
    array(
        'title' => 'Secure Online Payment',
        'content' => '<div class="text-center mb-30"><img
                        class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3"
                        src="/assets/themes/ecommerce-basic/img/services/04.png"
                        alt="Payment">
                <h6>Secure Online Payment</h6>
                <p class="text-muted margin-bottom-none">We posess SSL / Secure Certificate</p>
            </div>',
        'block_id' => $block->id,
        'widget_width' => 3,
        'widget_order' => 3,
        'status' => 'active',

    ),
);
foreach ($widgets as $widget) {
    \Corals\Modules\CMS\Models\Widget::updateOrCreate(
        ['block_id' => $widget['block_id'], 'title' => $widget['title']],
        $widget
    );
}

