<?php

if (\Schema::hasTable('cms_blocks') && class_exists(\Corals\Modules\CMS\Models\Block::class)) {
    $block = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'How it Works', 'key' => 'how-it-works'], [
        'name' => 'How it Works',
        'key' => 'how-it-works',
    ]);

    $widgets = array(
        array(
            'title' => 'How it Works',
            'content' => '<section>
    <div class="container">
        <div class="section-title">
            <h2>How it works</h2>
            <div class="section-subtitle">Discover & Connect</div>
            <span class="section-separator"></span>
            <p>Explore some of the best tips from around the world.</p>
        </div>
        <!--process-wrap  -->
        <div class="process-wrap fl-wrap">
            <ul>
                <li>
                    <div class="process-item">
                        <span class="process-count">01 .</span>
                        <div class="time-line-icon"><i class="fa fa-map-o"></i></div>
                        <h4>Find Interesting Place</h4>
                        <p>Proin dapibus nisl ornare diam varius tempus. Aenean a quam luctus, finibus tellus ut, convallis eros sollicitudin turpis.</p>
                    </div>
                    <span class="pr-dec"></span>
                </li>
                <li>
                    <div class="process-item">
                        <span class="process-count">02 .</span>
                        <div class="time-line-icon"><i class="fa fa-envelope-open-o"></i></div>
                        <h4> Contact a Few Owners</h4>
                        <p>Faucibus ante, in porttitor tellus blandit et. Phasellus tincidunt metus lectus sollicitudin feugiat pharetra consectetur.</p>
                    </div>
                    <span class="pr-dec"></span>
                </li>
                <li>
                    <div class="process-item">
                        <span class="process-count">03 .</span>
                        <div class="time-line-icon"><i class="fa fa-hand-peace-o"></i></div>
                        <h4>Make a Listing</h4>
                        <p>Maecenas pulvinar, risus in facilisis dignissim, quam nisi hendrerit nulla, id vestibulum metus nullam viverra porta.</p>
                    </div>
                </li>
            </ul>
            <div class="process-end"><i class="fa fa-check"></i></div>
        </div>
        <!--process-wrap   end-->
    </div>
</section>',
            'block_id' => $block->id,
            'widget_width' => 12,
            'widget_order' => 0,
            'status' => 'active',
        ),
    );
    foreach ($widgets as $widget) {
        \Corals\Modules\CMS\Models\Widget::updateOrCreate(
            ['block_id' => $widget['block_id'], 'title' => $widget['title']],
            $widget
        );
    }
}

$topMenu = Corals\Menu\Models\Menu::where('key', 'frontend_top')->first();

if ($topMenu) {
    $topMenuId = $topMenu->id;

    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $topMenuId,
        'key' => null,
        'url' => 'faqs',
        'active_menu_url' => 'faqs',
        'name' => 'FAQs',
        'description' => 'FAQs',
        'icon' => null,
        'target' => null,
        'order' => 970
    ]);
}


