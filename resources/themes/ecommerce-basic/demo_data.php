<?php
$categories = [];
$posts = [];

if (\Schema::hasTable('posts')
    && class_exists(\Corals\Modules\CMS\Models\Page::class)
    && class_exists(\Corals\Modules\CMS\Models\Post::class)
) {
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'home', 'type' => 'page',],
        array(
            'title' => 'Home',
            'slug' => 'home',
            'meta_keywords' => 'home',
            'meta_description' => 'home',
            'content' => '<div id="slider">@slider(e-commerce-home-page-slider)</div>',
            'published' => 1,
            'published_at' => '2017-11-16 14:26:52',
            'private' => 0,
            'type' => 'page',
            'template' => 'home',
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-11-16 16:27:04',
            'updated_at' => '2017-11-16 16:27:07',
        ));
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'about-us', 'type' => 'page'],
        array(
            'title' => 'About Us',
            'slug' => 'about-us',
            'meta_keywords' => 'about us',
            'meta_description' => 'about us',
            'content' => '<!-- Page Content-->
<div class="container padding-bottom-2x mb-2">
    <div class="row align-items-center padding-bottom-2x">
        <div class="col-md-5"><img class="d-block w-270 m-auto" src="/assets/themes/ecommerce-basic/img/features/01.jpg" alt="Online Shopping"></div>
        <div class="col-md-7 text-md-left text-center">
            <div class="mt-30 hidden-md-up"></div>
            <h2>Search, Select, Buy Online.</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam id purus at risus pellentesque faucibus
                a quis eros. In eu fermentum leo. Integer ut eros lacus. Proin ut accumsan leo. Morbi vitae est eget
                dolor consequat aliquam eget quis dolor. Mauris rutrum fermentum erat, at euismod lorem pharetra nec.
                Duis erat lectus, ultrices euismod sagittis at, pharetra eu nisl. Phasellus id ante at velit tincidunt
                hendrerit. Aenean dolor dolor, tristique nec placerat nec.</p><a
                class="text-medium text-decoration-none" href="https://codecanyon.net/user/corals-io/portfolio" target="_blank">View Products&nbsp;<i
                class="icon-arrow-right"></i></a>
        </div>
    </div>
    <hr>
    <div class="row align-items-center padding-top-2x padding-bottom-2x">
        <div class="col-md-5 order-md-2"><img class="d-block w-270 m-auto" src="/assets/themes/ecommerce-basic/img/features/02.jpg" alt="Delivery">
        </div>
        <div class="col-md-7 order-md-1 text-md-left text-center">
            <div class="mt-30 hidden-md-up"></div>
            <h2>Fast Delivery Worldwide.</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam id purus at risus pellentesque faucibus
                a quis eros. In eu fermentum leo. Integer ut eros lacus. Proin ut accumsan leo. Morbi vitae est eget
                dolor consequat aliquam eget quis dolor. Mauris rutrum fermentum erat, at euismod lorem pharetra nec.
                Duis erat lectus, ultrices euismod sagittis at, pharetra eu nisl. Phasellus id ante at velit tincidunt
                hendrerit. Aenean dolor dolor, tristique nec placerat nec.</p><a
                class="text-medium text-decoration-none" href="https://codecanyon.net/user/corals-io/portfolio" target="_blank">View Products&nbsp;<i
                class="icon-arrow-right"></i></a>
        </div>
    </div>
    <hr>
    <div class="row align-items-center padding-top-2x padding-bottom-2x">
        <div class="col-md-5"><img class="d-block w-270 m-auto" src="/assets/themes/ecommerce-basic/img/features/03.jpg" alt="Mobile App"></div>
        <div class="col-md-7 text-md-left text-center">
            <div class="mt-30 hidden-md-up"></div>
            <h2>Great Mobile App. Shop On The Go.</h2>
            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam id purus at risus
                pellentesque faucibus a quis eros. In eu fermentum leo. Integer ut eros lacus. Proin ut accumsan leo.
                Morbi vitae est eget dolor consequat aliquam eget quis dolor.</p><a class="market-button apple-button"
                                                                                    href="#"><span class="mb-subtitle">Download on the</span><span
                class="mb-title">App Store</span></a><a class="market-button google-button" href="#"><span
                class="mb-subtitle">Download on the</span><span class="mb-title">Google Play</span></a><a
                class="market-button windows-button" href="#"><span class="mb-subtitle">Download on the</span><span
                class="mb-title">Windows Store</span></a>
        </div>
    </div>
    <hr>
    <div class="row align-items-center padding-top-2x padding-bottom-2x">
        <div class="col-md-5 order-md-2"><img class="d-block w-270 m-auto" src="/assets/themes/ecommerce-basic/img/features/04.jpg" alt="Delivery">
        </div>
        <div class="col-md-7 order-md-1 text-md-left text-center">
            <div class="mt-30 hidden-md-up"></div>
            <h2>Shop Offline. Cozy Outlet Stores.</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam id purus at risus pellentesque faucibus
                a quis eros. In eu fermentum leo. Integer ut eros lacus. Proin ut accumsan leo. Morbi vitae est eget
                dolor consequat aliquam eget quis dolor. Mauris rutrum fermentum erat, at euismod lorem pharetra nec.
                Duis erat lectus, ultrices euismod sagittis at, pharetra eu nisl. Phasellus id ante at velit tincidunt
                hendrerit. Aenean dolor dolor, tristique nec placerat nec.</p><a
                class="text-medium text-decoration-none" href="https://codecanyon.net/user/corals-io/portfolio" target="_blank">View Products&nbsp;<i
                class="icon-arrow-right"></i></a>
        </div>
    </div>
    <hr>
    <div class="text-center padding-top-3x mb-30">
        <h2>Our Core Team</h2>
        <p class="text-muted">People behind your awesome shopping experience.</p>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-30 text-center"><img
                class="d-block w-150 mx-auto img-thumbnail rounded-circle mb-2" src="/assets/themes/ecommerce-basic/img/team/01.jpg" alt="Team">
            <h6>Grace Wright</h6>
            <p class="text-muted mb-2">Founder, CEO</p>
            <div class="social-bar"><a class="social-button shape-circle sb-facebook" href="#" data-toggle="tooltip"
                                       data-placement="top" title="Facebook"><i class="socicon-facebook"></i></a><a
                    class="social-button shape-circle sb-twitter" href="#" data-toggle="tooltip" data-placement="top"
                    title="Twitter"><i class="socicon-twitter"></i></a><a
                    class="social-button shape-circle sb-google-plus" href="#" data-toggle="tooltip"
                    data-placement="top" title="Google +"><i class="socicon-googleplus"></i></a></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-30 text-center"><img
                class="d-block w-150 mx-auto img-thumbnail rounded-circle mb-2" src="/assets/themes/ecommerce-basic/img/team/02.jpg" alt="Team">
            <h6>Taylor Jackson</h6>
            <p class="text-muted mb-2">Financial Director</p>
            <div class="social-bar"><a class="social-button shape-circle sb-skype" href="#" data-toggle="tooltip"
                                       data-placement="top" title="Skype"><i class="socicon-skype"></i></a><a
                    class="social-button shape-circle sb-facebook" href="#" data-toggle="tooltip" data-placement="top"
                    title="Facebook"><i class="socicon-facebook"></i></a><a class="social-button shape-circle sb-paypal"
                                                                            href="#" data-toggle="tooltip"
                                                                            data-placement="top" title="PayPal"><i
                    class="socicon-paypal"></i></a></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-30 text-center"><img
                class="d-block w-150 mx-auto img-thumbnail rounded-circle mb-2" src="/assets/themes/ecommerce-basic/img/team/03.jpg" alt="Team">
            <h6>Quinton Cross</h6>
            <p class="text-muted mb-2">Marketing Director</p>
            <div class="social-bar"><a class="social-button shape-circle sb-twitter" href="#" data-toggle="tooltip"
                                       data-placement="top" title="Twitter"><i class="socicon-twitter"></i></a><a
                    class="social-button shape-circle sb-google-plus" href="#" data-toggle="tooltip"
                    data-placement="top" title="Google +"><i class="socicon-googleplus"></i></a><a
                    class="social-button shape-circle sb-email" href="#" data-toggle="tooltip" data-placement="top"
                    title="Email"><i class="socicon-mail"></i></a></div>
        </div>
        <div class="col-md-3 col-sm-6 mb-30 text-center"><img
                class="d-block w-150 mx-auto img-thumbnail rounded-circle mb-2" src="/assets/themes/ecommerce-basic/img/team/04.jpg" alt="Team">
            <h6>Liana Mullen</h6>
            <p class="text-muted mb-2">Lead Designer</p>
            <div class="social-bar"><a class="social-button shape-circle sb-behance" href="#" data-toggle="tooltip"
                                       data-placement="top" title="Behance"><i class="socicon-behance"></i></a><a
                    class="social-button shape-circle sb-dribbble" href="#" data-toggle="tooltip" data-placement="top"
                    title="Dribbble"><i class="socicon-dribbble"></i></a><a
                    class="social-button shape-circle sb-instagram" href="#" data-toggle="tooltip" data-placement="top"
                    title="Instagram"><i class="socicon-instagram"></i></a></div>
        </div>
    </div>
</div>',
            'published' => 1,
            'published_at' => '2017-11-16 11:56:34',
            'private' => 0,
            'type' => 'page',
            'template' => 'full',
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-11-16 11:56:34',
            'updated_at' => '2017-11-16 11:56:34',
        ));
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'blog', 'type' => 'page'],
        array(
            'title' => 'Blog',
            'slug' => 'blog',
            'meta_keywords' => 'Blog',
            'meta_description' => 'Blog',
            'content' => '',
            'published' => 1,
            'published_at' => '2017-11-16 11:56:34',
            'private' => 0,
            'type' => 'page',
            'template' => 'left',
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-11-16 11:56:34',
            'updated_at' => '2017-11-16 11:56:34',
        ));
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'pricing', 'type' => 'page'],
        array(
            'title' => 'Pricing',
            'meta_keywords' => 'Pricing',
            'meta_description' => 'Pricing',
            'content' => '',
            'published' => 1,
            'published_at' => '2017-11-16 11:56:34',
            'private' => 0,
            'type' => 'page',
            'status' => 'inactive',
            'template' => 'full',
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-11-16 11:56:34',
            'updated_at' => '2017-11-16 11:56:34',
        ));
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'contact-us', 'type' => 'page'],
        array(
            'title' => 'Contact Us',
            'slug' => 'contact-us',
            'meta_keywords' => 'Contact Us',
            'meta_description' => 'Contact Us',
            'content' => '<div class="row">
            <div class="col">
                <div class="text-center">
                    <h3>Drop Your Message here</h3>
                    <p>You can contact us with anything related to Laraship. <br/> We\'ll get in touch with you as soon as
                        possible.</p>
                </div>
            </div>
        </div>',
            'published' => 1,
            'published_at' => '2017-11-16 11:56:34',
            'private' => 0,
            'type' => 'page',
            'template' => 'contact',
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-11-16 11:56:34',
            'updated_at' => '2017-11-16 11:56:34',
        ));

    $posts[] = \Corals\Modules\CMS\Models\Post::updateOrCreate(['slug' => 'subscription-commerce-trends-for-2018', 'type' => 'post'],
        array(
            'title' => 'Subscription Commerce Trends for 2018',
            'meta_keywords' => NULL,
            'meta_description' => NULL,
            'content' => '<p>Subscription commerce is ever evolving. A few years ago, who would have expected&nbsp;<a href="https://techcrunch.com/2017/10/10/porsche-launches-on-demand-subscription-for-its-sports-cars-and-suvs/" target="_blank">Porsche</a>&nbsp;to launch a subscription service? Or that monthly boxes of beauty samples or shaving supplies and&nbsp;<a href="https://www.pymnts.com/subscription-commerce/2017/how-over-the-top-services-came-out-on-top/" target="_blank">OTT services</a>&nbsp;would propel the subscription model to new heights? And how will these trends shape the subscription space going forward&mdash;and drive growth and innovation?</p>

<p>Regardless of your billing model, there&rsquo;s an opportunity for you to capitalize on many of the current trends in subscription commerce&mdash;trends that will help you to continue to compete and succeed in your industry.</p>

<h3><strong>What are these trends and how can you learn more?</strong></h3>

<p>These trends are outlined in our &ldquo;Top Ten Trends for 2018&rdquo; which we publish every year to help subscription businesses understand the drivers which may impact them in 2018 and beyond.</p>

<p>One trend, for example, is machine learning and data science which the payments industry is increasingly utilizing to deliver more powerful results for their customers.</p>

<p>Another trend which is driving new revenue is the adoption of a hybrid billing model&mdash; subscription businesses seamlessly sell one-time items and &lsquo;traditional&rsquo; businesses add a subscription component as a means to introduce a new revenue stream.</p>

<p>And while subscriber acquisition is not a new trend, there are some sophisticated ways to acquire new customers that subscription businesses are putting to work for increasingly positive effect.</p>

<p>Download this year&rsquo;s edition and see how these trends and insights can help your subscription business succeed in 2018.</p>

<p>&nbsp;</p>',
            'published' => 1,
            'published_at' => '2017-12-04 11:18:23',
            'private' => 0,
            'type' => 'post',
            'template' => NULL,
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-12-03 23:45:51',
            'updated_at' => '2017-12-04 13:18:23',
        ));
    $posts[] = \Corals\Modules\CMS\Models\Post::updateOrCreate(['slug' => 'using-machine-learning-to-optimize-subscription-billing', 'type' => 'post'],
        array(
            'title' => 'Using Machine Learning to Optimize Subscription Billing',
            'meta_keywords' => NULL,
            'meta_description' => NULL,
            'content' => '<p>As a data scientist at Recurly, my job is to use the vast amount of data that we have collected to build products that make subscription businesses more successful. One way to think about data science at Recurly is as an extended R&amp;D department for our customers. We use a variety of tools and techniques, attack problems big and small, but at the end of the day, our goal is to put all of Recurly&rsquo;s expertise to work in service of your business.</p>

<p>Managing a successful subscription business requires a wide range of decisions. What is the optimum structure for subscription plans and pricing? What are the most effective subscriber acquisition methods? What are the most efficient collection methods for delinquent subscribers? What strategies will reduce churn and increase revenue?</p>

<p>At Recurly, we&#39;re focused on building the most flexible subscription management platform, a platform that provides a competitive advantage for your business. We reduce the complexity of subscription billing so you can focus on winning new subscribers and delighting current subscribers.</p>

<p>Recently, we turned to data science to tackle a big problem for subscription businesses: involuntary churn.</p>

<h3><strong>The Problem: The Retry Schedule</strong></h3>

<p>One of the most important factors in subscription commerce is subscriber retention. Every billing event needs to occur flawlessly to avoid adversely impacting the subscriber relationship or worse yet, to lose that subscriber to churn.</p>

<p>Every time a subscription comes up for renewal, Recurly creates an invoice and initiates a transaction using the customer&rsquo;s stored billing information, typically a credit card. Sometimes, this transaction is declined by the payment processor or the customer&rsquo;s bank. When this happens, Recurly sends reminder emails to the customer, checks with the Account Updater service to see if the customer&#39;s card has been updated, and also attempts to collect payment at various intervals over a period of time defined by the subscription business. The timing of these collection attempts is called the &ldquo;retry schedule.&rdquo;</p>

<p>Our ability to correct and successfully retry these cards prevents lost revenue, positively impacts your bottom line, and increases your customer retention rate.</p>

<p>Other subscription providers typically offer a static, one-size-fits-all retry schedule, or leave the schedule up to the subscription business, without providing any guidance. In contrast, Recurly can use machine learning to craft a retry schedule that is tailored to each individual invoice based on our historical data with hundreds of millions of transactions. Our approach gives each invoice the best chance of success, without any manual work by our customers.</p>

<p>A key component of Recurly&rsquo;s values is to test, learn and iterate. How did we call on those values to build this critical component of the Recurly platform?</p>

<h3><strong>Applying Machine Learning</strong></h3>

<p>We decided to use statistical models that leverage Recurly&rsquo;s data on transactions (hundreds of millions of transactions built up over years from a wide variety of different businesses) to predict which transactions are likely to succeed. Then, we used these models to craft the ideal retry schedule for each individual invoice. The process of building the models is known as machine learning.</p>

<p>The term &quot;machine learning&quot; encompasses many different processes and methods, but at its heart is an effort to go past explicitly programmed logic and allow a computer to arrive at the best logic on its own.</p>

<p>While humans are optimized for learning certain tasks&mdash;like how children can speak a new language after simply listening for a few months&mdash;computers can also be trained to learn patterns. Aggregating hundreds of millions of transactions to look for the patterns that lead to transaction success is a classic machine learning problem.</p>

<p>A typical machine learning project involves gathering data, training a statistical model on that data, and then evaluating the performance of the model when presented with new data. A model is only as good as the data it&rsquo;s trained on, and here we had a huge advantage.</p>',
            'published' => 1,
            'published_at' => '2017-12-04 11:21:25',
            'private' => 0,
            'type' => 'post',
            'template' => NULL,
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-12-04 13:21:25',
            'updated_at' => '2017-12-04 13:21:25',
        ));
    $posts[] = \Corals\Modules\CMS\Models\Post::updateOrCreate(['slug' => 'why-you-need-a-blog-subscription-landing-page', 'type' => 'post'],
        array(
            'title' => 'Why You Need A Blog Subscription Landing Page',
            'meta_keywords' => NULL,
            'meta_description' => NULL,
            'content' => '<p>Whether subscribing via email or RSS, your site visitor is individually volunteering to add your content to their day; a day that is already crowded with content from emails, texts, voicemails, site content, and even snail mail. &nbsp;</p>

<p>As a business, each time you receive a new blog subscriber, you have received validation or &quot;a vote&quot; that your audience has identified YOUR content as adding value to their day. With each new blog subscriber, your content is essentially being awarded as being highly relevant to conversations your readers are having on a regular basis.&nbsp;</p>

<p>To best promote the content your blog subscribers can expect to receive on an ongoing basis,&nbsp;<strong>consider adding a blog subscription landing page.&nbsp;</strong>This is a quick win that will help your company enhance the blogging subscription experience and help you measure and manage the success of this offer with analytical insight.</p>

<p>Holistically, your goal with this landing page is to provide visitors with a sneak preview of the experience they will receive by becoming a blog subscriber.<strong>&nbsp;Your blog subscription landing page should include:</strong></p>

<ul>
<li><strong>A high-level overview of topics, categories your blog will discuss.&nbsp;&nbsp;</strong>For example, HubSpot&#39;s blog covers &quot;all of the inbound marketing - SEO, Blogging, Social Media, Landing Pages, Lead Generation, and Analytics.&quot;</li>
<li><strong>Insight into &quot;who&quot; your blog will benefit.&nbsp;&nbsp;</strong>Examples may include HR Directors, Financial Business professionals, Animal Enthusiasts, etc.&nbsp; If your blog appeals to multiple personas, feel free to spell this out.&nbsp; This will help assure your visitor that they are joining a group of like-minded individuals who share their interests and goals.&nbsp;&nbsp;</li>
<li><strong>How your blog will help to drive the relevant conversation.&nbsp;</strong>Examples may include &quot;updates on industry events&quot;, &quot;expert editorials&quot;, &quot;insider tips&quot;, etc.&nbsp;&nbsp;</li>
</ul>

<p><strong>To create your blog subscription landing page, consider the following steps:</strong></p>

<p>1) Create your landing page following&nbsp;landing page best practices.&nbsp; Consider the &quot;subscribing to your blog&quot; offer as similar to other offers you promote using Landing Pages.&nbsp;</p>

<p>2) Create a Call To Action button that will link to this landing page.&nbsp; Use this button as a call to action within your blog articles or on other website pages to link to a blog subscription landing page&nbsp;Make sure your CTA button is supercharged!</p>

<p>3)&nbsp;Create a Thank You Page&nbsp;to complete the sign-up experience with gratitude and a follow-up call to action.&nbsp;</p>

<p>4) Measure the success of your blog subscription landing page.&nbsp;Consider the 3 Secrets to Optimizing Landing Page Copy.&nbsp;</p>

<p>For more information on Blogging Success Strategies,&nbsp;check out more Content Camp Resources and recorded webinars.&nbsp;</p>',
            'published' => 1,
            'published_at' => '2017-12-04 11:33:19',
            'private' => 0,
            'type' => 'post',
            'template' => NULL,
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-12-04 13:31:46',
            'updated_at' => '2017-12-04 13:33:19',
        ));
}

if (\Schema::hasTable('categories') && class_exists(\Corals\Modules\CMS\Models\Category::class)) {
    $categories[] = \Corals\Modules\CMS\Models\Category::updateOrCreate([
        'name' => 'Computers',
        'slug' => 'computers',
    ]);
    $categories[] = \Corals\Modules\CMS\Models\Category::updateOrCreate([
        'name' => 'Smartphone',
        'slug' => 'smartphone',
    ]);
    $categories[] = \Corals\Modules\CMS\Models\Category::updateOrCreate([
        'name' => 'Gadgets',
        'slug' => 'gadgets',
    ]);
    $categories[] = \Corals\Modules\CMS\Models\Category::updateOrCreate([
        'name' => 'Technology',
        'slug' => 'technology',
    ]);
    $categories[] = \Corals\Modules\CMS\Models\Category::updateOrCreate([
        'name' => 'Engineer',
        'slug' => 'engineer',
    ]);
    $categories[] = \Corals\Modules\CMS\Models\Category::updateOrCreate([
        'name' => 'Subscriptions',
        'slug' => 'subscriptions',
    ]);
    $categories[] = \Corals\Modules\CMS\Models\Category::updateOrCreate([
        'name' => 'Billing',
        'slug' => 'billing',
    ]);
}

$posts_media = [
    0 => array(
        'id' => 4,
        'model_type' => 'Corals\\Modules\\CMS\\Models\\Post',
        'collection_name' => 'featured-image',
        'name' => 'subscription_trends',
        'file_name' => 'subscription_trends.png',
        'mime_type' => 'image/png',
        'disk' => 'media',
        'size' => 20486,
        'manipulations' => '[]',
        'custom_properties' => '{"root":"demo"}',
        'order_column' => 6,
        'created_at' => '2017-12-03 23:45:51',
        'updated_at' => '2017-12-03 23:45:51',
    ),
    1 => array(
        'id' => 8,
        'model_type' => 'Corals\\Modules\\CMS\\Models\\Post',
        'collection_name' => 'featured-image',
        'name' => 'machine_learning',
        'file_name' => 'machine_learning.png',
        'mime_type' => 'image/png',
        'disk' => 'media',
        'size' => 32994,
        'manipulations' => '[]',
        'custom_properties' => '{"root":"demo"}',
        'order_column' => 11,
        'created_at' => '2017-12-04 13:21:25',
        'updated_at' => '2017-12-04 13:21:25',
    ),
    2 => array(
        'id' => 9,
        'model_type' => 'Corals\\Modules\\CMS\\Models\\Post',
        'collection_name' => 'featured-image',
        'name' => 'Successful-Blog_Fotolia_102410353_Subscription_Monthly_M',
        'file_name' => 'Successful-Blog_Fotolia_102410353_Subscription_Monthly_M.jpg',
        'mime_type' => 'image/jpeg',
        'disk' => 'media',
        'size' => 182317,
        'manipulations' => '[]',
        'custom_properties' => '{"root":"demo"}',
        'order_column' => 12,
        'created_at' => '2017-12-04 13:33:19',
        'updated_at' => '2017-12-04 13:33:19',
    ),
];

foreach ($posts as $index => $post) {
    $randIndex = rand(0, 6);
    if (isset($categories[$randIndex])) {
        $category = $categories[$randIndex];
        try {
            \DB::table('category_post')->insert(array(
                array(
                    'post_id' => $post->id,
                    'category_id' => $category->id,
                )
            ));
        } catch (\Exception $exception) {
        }
    }

    if (isset($posts_media[$index])) {
        try {
            $posts_media[$index]['model_id'] = $post->id;
            \DB::table('media')->insert($posts_media[$index]);
        } catch (\Exception $exception) {
        }
    }
}

if (class_exists(\Corals\Menu\Models\Menu::class) && \Schema::hasTable('posts')) {
    // seed root menus
    $topMenu = Corals\Menu\Models\Menu::updateOrCreate(['key' => 'frontend_top'], [
        'parent_id' => 0,
        'url' => null,
        'name' => 'Frontend Top',
        'description' => 'Frontend Top Menu',
        'icon' => null,
        'target' => null,
        'order' => 0
    ]);

    $topMenuId = $topMenu->id;

    // seed children menu
    Corals\Menu\Models\Menu::updateOrCreate(['key' => 'home'], [
        'parent_id' => $topMenuId,
        'url' => '/',
        'active_menu_url' => '/',
        'name' => 'Home',
        'description' => 'Home Menu Item',
        'icon' => 'fa fa-home',
        'target' => null,
        'order' => 0
    ]);

    Corals\Menu\Models\Menu::updateOrCreate(['parent_id' => $topMenuId, 'key' => 'shop'], [
        'url' => 'shop',
        'active_menu_url' => 'shop',
        'name' => 'Shop',
        'description' => 'Shop Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 965
    ]);

    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $topMenuId,
        'key' => null,
        'url' => 'about-us',
        'active_menu_url' => 'about-us',
        'name' => 'About Us',
        'description' => 'About Us Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 970
    ]);

    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $topMenuId,
        'key' => null,
        'url' => 'blog',
        'active_menu_url' => 'blog',
        'name' => 'Blog',
        'description' => 'Blog Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 980
    ]);

    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $topMenuId,
        'key' => null,
        'url' => 'pricing',
        'active_menu_url' => 'pricing',
        'name' => 'Pricing',
        'description' => 'Pricing Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 980
    ]);

    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $topMenuId,
        'key' => null,
        'url' => 'faqs',
        'active_menu_url' => 'faqs',
        'name' => 'FAQs',
        'description' => 'FAQs',
        'icon' => null,
        'target' => null,
        'order' => 980
    ]);

    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $topMenuId,
        'key' => null,
        'url' => 'contact-us',
        'active_menu_url' => 'contact-us',
        'name' => 'Contact Us',
        'description' => 'Contact Us Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 980
    ]);

    $footerMenu = Corals\Menu\Models\Menu::updateOrCreate(['key' => 'frontend_footer'], [
        'parent_id' => 0,
        'url' => null,
        'name' => 'Frontend Footer',
        'description' => 'Frontend Footer Menu',
        'icon' => null,
        'target' => null,
        'order' => 0
    ]);

    $footerMenuId = $footerMenu->id;

// seed children menu
    Corals\Menu\Models\Menu::updateOrCreate(['key' => 'footer_home'], [
        'parent_id' => $footerMenuId,
        'url' => '/',
        'active_menu_url' => '/',
        'name' => 'Home',
        'description' => 'Home Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 0
    ]);
    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $footerMenuId,
        'key' => null,
        'url' => 'about-us',
        'active_menu_url' => 'about-us',
        'name' => 'About Us',
        'description' => 'About Us Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 980
    ]);
    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $footerMenuId,
        'key' => null,
        'url' => 'contact-us',
        'active_menu_url' => 'contact-us',
        'name' => 'Contact Us',
        'description' => 'Contact Us Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 980
    ]);
    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $footerMenuId,
        'key' => null,
        'url' => 'blog',
        'active_menu_url' => 'blog',
        'name' => 'Blog',
        'description' => 'Blog Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 980
    ]);
}


if (class_exists(\Corals\Modules\Ecommerce\Models\Product::class) && \Schema::hasTable('ecommerce_products')) {
    ///////////////////////// Shippings
    $shippings = array(
        array(
            'priority' => 1,
            'shipping_method' => 'Shippo',
            'rate' => '0.00',
            'country' => 'US',
            'description' => NULL
        ),
        array(
            'priority' => 2,
            'shipping_method' => 'FlatRate',
            'rate' => '10.00',
            'country' => NULL,
            'description' => NULL
        ),
    );

    foreach ($shippings as $shipping) {
        \Corals\Modules\Ecommerce\Models\Shipping::updateOrCreate([
            'shipping_method' => $shipping['shipping_method'],
            'country' => $shipping['country']
        ], $shipping);
    }
    ///////////////////////// Coupons
    $coupons = array(
        array(
            'id' => 1,
            'code' => 'CORALS-FIXED',
            'type' => 'fixed',
            'uses' => NULL,
            'min_cart_total' => '500.00',
            'max_discount_value' => NULL,
            'value' => '45',
            'start' => '2018-03-01 00:00:00',
            'expiry' => '2022-03-01 00:00:00',
        ),
        array(
            'id' => 2,
            'code' => 'CORALS-PERC',
            'type' => 'percentage',
            'uses' => NULL,
            'min_cart_total' => '500.00',
            'max_discount_value' => NULL,
            'value' => '10',
            'start' => '2018-03-01 00:00:00',
            'expiry' => '2022-03-01 00:00:00',
        ),
    );

    foreach ($coupons as $coupon) {
        \Corals\Modules\Ecommerce\Models\Coupon::updateOrCreate(['code' => $coupon['code']], $coupon);
    }

    ///////////////////////// Settings

    $ecommerceSettings = array(
        array(
            'code' => 'ecommerce_company_owner',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_owner',
            'value' => 'Corals',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_company_name',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_name',
            'value' => 'Corals',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_company_street1',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_street1',
            'value' => '5543 Aliquet St.',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_company_city',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_city',
            'value' => 'Fort Dodge',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_company_state',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_state',
            'value' => 'GA',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_company_zip',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_zip',
            'value' => '20783',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_company_country',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_country',
            'value' => 'USA',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_company_phone',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_phone',
            'value' => '(717) 450-4729',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_company_email',
            'type' => 'TEXT',
            'label' => 'ecommerce_company_email',
            'value' => 'support@corals.io',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_shipping_weight_unit',
            'type' => 'TEXT',
            'label' => 'ecommerce_shipping_weight_unit',
            'value' => 'oz',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_shipping_dimensions_unit',
            'type' => 'TEXT',
            'label' => 'ecommerce_shipping_dimensions_unit',
            'value' => 'in',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_shipping_shippo_live_token',
            'type' => 'TEXT',
            'label' => 'ecommerce_shipping_shippo_live_token',
            'value' => NULL,
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_shipping_shippo_test_token',
            'type' => 'TEXT',
            'label' => 'ecommerce_shipping_shippo_test_token',
            'value' => 'shippo_test_b3aab6f5d5ee5fb9e981906a449d74fe2e7bf9eb',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_shipping_shippo_sandbox_mode',
            'type' => 'TEXT',
            'label' => 'ecommerce_shipping_shippo_sandbox_mode',
            'value' => 'true',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_tax_calculate_tax',
            'type' => 'TEXT',
            'label' => 'ecommerce_tax_calculate_tax',
            'value' => 'true',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_rating_enable',
            'type' => 'TEXT',
            'label' => 'ecommerce_rating_enable',
            'value' => 'true',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_wishlist_enable',
            'type' => 'TEXT',
            'label' => 'ecommerce_wishlist_enable',
            'value' => 'true',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_appearance_page_limit',
            'type' => 'TEXT',
            'label' => 'ecommerce_appearance_page_limit',
            'value' => '15',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_search_title_weight',
            'type' => 'TEXT',
            'label' => 'ecommerce_search_title_weight',
            'value' => '3',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_search_content_weight',
            'type' => 'TEXT',
            'label' => 'ecommerce_search_content_weight',
            'value' => '1.5',
            'editable' => 0,
            'hidden' => 1
        ),
        array(
            'code' => 'ecommerce_search_enable_wildcards',
            'type' => 'TEXT',
            'label' => 'ecommerce_search_enable_wildcards',
            'value' => 'true',
            'editable' => 0,
            'hidden' => 1
        ),
    );

    foreach ($ecommerceSettings as $setting) {
        \Corals\Settings\Models\Setting::updateOrCreate(['code' => $setting['code']], $setting);
    }

    /**
    ///////////////////////// Categories
    $mobilesCat = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Mobiles', 'slug' => 'mobiles'], [
        'is_featured' => 1,
    ]);

    $tabletsCat = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Tablets', 'slug' => 'tablets'], [
        'is_featured' => 1,
    ]);

    $accessoriesCat = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Accessories', 'slug' => 'accessories'], [
        'is_featured' => 1,
    ]);

    $headphones = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Headphones', 'slug' => 'headphones'], [
        'is_featured' => 0,
        'parent_id' => $accessoriesCat->id
    ]);

    $cases = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Cases', 'slug' => 'cases'], [
        'is_featured' => 0,
        'parent_id' => $accessoriesCat->id
    ]);

    $chargers = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Chargers', 'slug' => 'chargers'], [
        'is_featured' => 0,
        'parent_id' => $accessoriesCat->id
    ]);

    $memCards = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Memory Cards', 'slug' => 'mem-cards'], [
        'is_featured' => 0,
        'parent_id' => $accessoriesCat->id
    ]);

    $screenProtector = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Screen Protector', 'slug' => 'screen-protector'], [
        'is_featured' => 0,
        'parent_id' => $accessoriesCat->id
    ]);

    $catsMedia = array(
        array(
            'model_id' => $accessoriesCat->id,
            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Category',
            'collection_name' => 'ecommerce-category-thumbnail',
            'name' => 'accessories',
            'file_name' => 'accessories.jpg',
            'mime_type' => 'image/jpeg',
            'disk' => 'media',
            'size' => 83367,
            'manipulations' => '[]',
            'custom_properties' => json_decode('{"root":"demo","key":"accessories_cat"}', true),
            'order_column' => 1,
            'created_at' => '2018-03-21 11:13:01',
            'updated_at' => '2018-03-21 11:13:01',
        ),
        array(
            'model_id' => $tabletsCat->id,
            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Category',
            'collection_name' => 'ecommerce-category-thumbnail',
            'name' => 'tablets',
            'file_name' => 'tablets.jpg',
            'mime_type' => 'image/jpeg',
            'disk' => 'media',
            'size' => 1057378,
            'manipulations' => '[]',
            'custom_properties' => json_decode('{"root":"demo","key":"tablets_cat"}', true),
            'order_column' => 1,
            'created_at' => '2018-03-21 11:13:01',
            'updated_at' => '2018-03-21 11:13:01',
        ),
        array(
            'model_id' => $mobilesCat->id,
            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Category',
            'collection_name' => 'ecommerce-category-thumbnail',
            'name' => 'mobiles',
            'file_name' => 'mobiles.jpg',
            'mime_type' => 'image/jpeg',
            'disk' => 'media',
            'size' => 108333,
            'manipulations' => '[]',
            'custom_properties' => json_decode('{"root":"demo","key":"mobiles_cat"}', true),
            'order_column' => 1,
            'created_at' => '2018-03-21 11:13:01',
            'updated_at' => '2018-03-21 11:13:01',
        ),
    );

    foreach ($catsMedia as $media) {
        try {
            \Spatie\MediaLibrary\Media::updateOrCreate([
                'model_id' => $media['model_id'], 'model_type' => $media['model_type']
            ], $media);
        } catch (\Exception $exception) {

        }
    }

    ///////////////////////// Tags
    $tags = [
        [
            'name' => '5"',
            'slug' => '5-inch'
        ],
        [
            'name' => '5.5"',
            'slug' => '5-5-inch'
        ],
        [
            'name' => '5.8"',
            'slug' => '5-8-inch'
        ],
        [
            'name' => '6.3"',
            'slug' => '6-3-inch'
        ],
        [
            'name' => 'iOS 11',
            'slug' => 'ios-11'
        ],
        [
            'name' => 'Water Resistance',
            'slug' => 'water-resistance'
        ],
        [
            'name' => 'Bluetooth',
            'slug' => 'bluetooth'
        ],
        [
            'name' => 'Retina',
            'slug' => 'retina'
        ],
        [
            'name' => 'OLED',
            'slug' => 'oled-display'
        ],
        [
            'name' => 'Fingerprint',
            'slug' => 'fingerprint'
        ],
        [
            'name' => '8.0 Oreo',
            'slug' => '8-0-oreo'
        ],
    ];

    $tagsObjects = collect([]);

    foreach ($tags as $tag) {
        $tagsObjects->push(\Corals\Modules\Ecommerce\Models\Tag::updateOrCreate(['slug' => $tag['slug']], $tag));
    }
    ///////////////////////// Brands

    $samsungBrand = \Corals\Modules\Ecommerce\Models\Brand::updateOrCreate(['name' => 'Samsung', 'slug' => 'samsung-mobile'], [
        'is_featured' => 1,
    ]);

    $appleBrand = \Corals\Modules\Ecommerce\Models\Brand::updateOrCreate(['name' => 'Apple', 'slug' => 'apple-mobile'], [
        'is_featured' => 1,
    ]);

    $huaweiBrand = \Corals\Modules\Ecommerce\Models\Brand::updateOrCreate(['name' => 'Huawei', 'slug' => 'huawei-mobile'], [
        'is_featured' => 1,
    ]);

    $htcBrand = \Corals\Modules\Ecommerce\Models\Brand::updateOrCreate(['name' => 'HTC', 'slug' => 'htc-mobile'], [
        'is_featured' => 1,
    ]);

    $lgBrand = \Corals\Modules\Ecommerce\Models\Brand::updateOrCreate(['name' => 'LG', 'slug' => 'lg-mobile'], [
        'is_featured' => 1,
    ]);

    $brandsMedia = array(
        array(
            'model_id' => $lgBrand->id,
            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Brand',
            'collection_name' => 'ecommerce-brand-thumbnail',
            'name' => 'lg_logo',
            'file_name' => 'lg_logo.png',
            'mime_type' => 'image/png',
            'disk' => 'media',
            'size' => 86353,
            'manipulations' => '[]',
            'custom_properties' => json_decode('{"root":"demo","key":"lg_logo"}', true),
            'order_column' => 1,
            'created_at' => '2018-03-21 11:13:01',
            'updated_at' => '2018-03-21 11:13:01',
        ),
        array(
            'model_id' => $htcBrand->id,
            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Brand',
            'collection_name' => 'ecommerce-brand-thumbnail',
            'name' => 'htc_logo',
            'file_name' => 'htc_logo.png',
            'mime_type' => 'image/png',
            'disk' => 'media',
            'size' => 16849,
            'manipulations' => '[]',
            'custom_properties' => json_decode('{"root":"demo","key":"htc_logo"}', true),
            'order_column' => 2,
            'created_at' => '2018-03-21 11:16:12',
            'updated_at' => '2018-03-21 11:16:12',
        ),
        array(
            'model_id' => $huaweiBrand->id,
            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Brand',
            'collection_name' => 'ecommerce-brand-thumbnail',
            'name' => 'huawei_logo',
            'file_name' => 'huawei_logo.png',
            'mime_type' => 'image/png',
            'disk' => 'media',
            'size' => 285855,
            'manipulations' => '[]',
            'custom_properties' => json_decode('{"root":"demo","key":"huawei_logo"}', true),
            'order_column' => 3,
            'created_at' => '2018-03-21 11:17:45',
            'updated_at' => '2018-03-21 11:17:45',
        ),
        array(
            'model_id' => $appleBrand->id,
            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Brand',
            'collection_name' => 'ecommerce-brand-thumbnail',
            'name' => 'apple_logo',
            'file_name' => 'apple_logo.png',
            'mime_type' => 'image/png',
            'disk' => 'media',
            'size' => 11916,
            'manipulations' => '[]',
            'custom_properties' => json_decode('{"root":"demo","key":"apple_logo"}', true),
            'order_column' => 4,
            'created_at' => '2018-03-21 11:18:17',
            'updated_at' => '2018-03-21 11:18:17',
        ),
        array(
            'model_id' => $samsungBrand->id,
            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Brand',
            'collection_name' => 'ecommerce-brand-thumbnail',
            'name' => 'samsung_logo',
            'file_name' => 'samsung_logo.png',
            'mime_type' => 'image/png',
            'disk' => 'media',
            'size' => 21007,
            'manipulations' => '[]',
            'custom_properties' => json_decode('{"root":"demo","key":"samsung_logo"}', true),
            'order_column' => 5,
            'created_at' => '2018-03-21 11:18:47',
            'updated_at' => '2018-03-21 11:18:47',
        )
    );

    foreach ($brandsMedia as $media) {
        try {
            \Spatie\MediaLibrary\Media::updateOrCreate([
                'model_id' => $media['model_id'], 'model_type' => $media['model_type']
            ], $media);
        } catch (\Exception $exception) {

        }
    }
    ///////////////////////// Attributes
    $memoryAttr = \Corals\Modules\Ecommerce\Models\Attribute::updateOrCreate(['type' => 'select', 'label' => 'Memory'], [
        'display_order' => 0,
        'use_as_filter' => 1,
        'required' => 1,
    ]);

    $storageAttr = \Corals\Modules\Ecommerce\Models\Attribute::updateOrCreate(['type' => 'select', 'label' => 'Storage'], [
        'display_order' => 1,
        'use_as_filter' => 1,
        'required' => 1,
    ]);

    $colorAttr = \Corals\Modules\Ecommerce\Models\Attribute::updateOrCreate(['type' => 'select', 'label' => 'Color'], [
        'display_order' => 2,
        'use_as_filter' => 1,
        'required' => 1,
    ]);

    $wirelessAttr = \Corals\Modules\Ecommerce\Models\Attribute::updateOrCreate(['type' => 'multi_values', 'label' => 'Wireless Technology'], [
        'display_order' => 3,
        'use_as_filter' => 0,
        'required' => 1,
    ]);

    $attrOptions = array(
        array(
            'attribute_id' => $memoryAttr->id,
            'option_order' => 1,
            'option_value' => '1',
            'option_display' => '1 GB',
        ),
        array(
            'attribute_id' => $memoryAttr->id,
            'option_order' => 2,
            'option_value' => '2',
            'option_display' => '2 GB',
        ),
        array(
            'attribute_id' => $memoryAttr->id,
            'option_order' => 3,
            'option_value' => '3',
            'option_display' => '3 GB',
        ),
        array(
            'attribute_id' => $memoryAttr->id,
            'option_order' => 4,
            'option_value' => '4',
            'option_display' => '4 GB',
        ),
        array(
            'attribute_id' => $memoryAttr->id,
            'option_order' => 5,
            'option_value' => '6',
            'option_display' => '6 GB',
        ),
        array(
            'attribute_id' => $storageAttr->id,
            'option_order' => 1,
            'option_value' => '16',
            'option_display' => '16 GB',
        ),
        array(
            'attribute_id' => $storageAttr->id,
            'option_order' => 2,
            'option_value' => '32',
            'option_display' => '32 GB',
        ),
        array(
            'attribute_id' => $storageAttr->id,
            'option_order' => 3,
            'option_value' => '64',
            'option_display' => '64 GB',
        ),
        array(
            'attribute_id' => $storageAttr->id,
            'option_order' => 4,
            'option_value' => '128',
            'option_display' => '128 GB',
        ),
        array(
            'attribute_id' => $storageAttr->id,
            'option_order' => 5,
            'option_value' => '256',
            'option_display' => '256 GB',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 1,
            'option_value' => 'black',
            'option_display' => 'Black',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 2,
            'option_value' => 'white',
            'option_display' => 'White',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 3,
            'option_value' => 'red',
            'option_display' => 'Red',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 4,
            'option_value' => 'silver',
            'option_display' => 'Silver',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 5,
            'option_value' => 'gold',
            'option_display' => 'Gold',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 6,
            'option_value' => 'rosegold',
            'option_display' => 'Rosegold',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 7,
            'option_value' => 'lilac-purple',
            'option_display' => 'LILAC PURPLE',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 8,
            'option_value' => 'blue',
            'option_display' => 'Blue',
        ),
        array(
            'attribute_id' => $colorAttr->id,
            'option_order' => 9,
            'option_value' => 'gray',
            'option_display' => 'Gray',
        ),
        array(
            'attribute_id' => $wirelessAttr->id,
            'option_order' => 1,
            'option_value' => '2G',
            'option_display' => '2G',
        ),
        array(
            'attribute_id' => $wirelessAttr->id,
            'option_order' => 2,
            'option_value' => '3G',
            'option_display' => '3G',
        ),
        array(
            'attribute_id' => $wirelessAttr->id,
            'option_order' => 3,
            'option_value' => '4G LTE',
            'option_display' => '4G LTE',
        ),
        array(
            'attribute_id' => $wirelessAttr->id,
            'option_order' => 4,
            'option_value' => 'GSM',
            'option_display' => 'GSM',
        ),
    );
    $attrOptionsObjects = collect([]);

    foreach ($attrOptions as $option) {
        try {
            $attrOptionsObjects->push(\Corals\Modules\Ecommerce\Models\AttributeOption::updateOrCreate([
                'attribute_id' => $option['attribute_id'],
                'option_value' => $option['option_value']
            ], $option));
        } catch (\Exception $exception) {
        }
    }
*/

//    $samsungCat = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Samsung', 'slug' => 'samsung'], [
//        'parent_id' => $mobileCat->id,
//        'is_featured' => 1,
//    ]);
//
//    $appleCat = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Apple', 'slug' => 'apple'], [
//        'parent_id' => $mobileCat->id,
//        'is_featured' => 1,
//    ]);
//
//    $huaweiCat = \Corals\Modules\Ecommerce\Models\Category::updateOrCreate(['name' => 'Huawei', 'slug' => 'huawei'], [
//        'parent_id' => $mobileCat->id,
//        'is_featured' => 1,
//    ]);
//    $ecommerceMedia = [
//        array(
//            'model_id' => $huaweiCat->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Category',
//            'collection_name' => 'ecommerce-category-thumbnail',
//            'name' => '2000px-Huawei',
//            'file_name' => '2000px-Huawei.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media',
//            'size' => 285855,
//            'manipulations' => '[]',
//            'custom_properties' => ["root" => "demo", "key" => "10"],
//            'order_column' => 13,
//            'created_at' => '2017-12-03 23:45:51',
//            'updated_at' => '2017-12-03 23:45:51',
//        ),
//        array(
//            'model_id' => $samsungCat->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Category',
//            'collection_name' => 'ecommerce-category-thumbnail',
//            'name' => 'samsung-logo-759',
//            'file_name' => 'samsung-logo-759.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media',
//            'size' => 21007,
//            'manipulations' => '[]',
//            'custom_properties' => ["root" => "demo", "key" => "11"],
//            'order_column' => 14,
//            'created_at' => '2017-12-03 23:45:51',
//            'updated_at' => '2017-12-03 23:45:51',
//        ),
//        array(
//            'model_id' => $appleCat->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Category',
//            'collection_name' => 'ecommerce-category-thumbnail',
//            'name' => 't4',
//            'file_name' => 't4.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media',
//            'size' => 21007,
//            'manipulations' => '[]',
//            'custom_properties' => ["root" => "demo", "key" => "12"],
//            'order_column' => 15,
//            'created_at' => '2017-12-03 23:45:51',
//            'updated_at' => '2017-12-03 23:45:51',
//        ),
//    ];
//
//    foreach ($ecommerceMedia as $media) {
//        try {
//            \Spatie\MediaLibrary\Media::updateOrCreate([
//                'model_id' => $media['model_id'], 'model_type' => $media['model_type']
//            ], $media);
//        } catch (\Exception $exception) {
//
//        }
//    }
//

//
//    //================S9=====================
//    $s9 = array(
//        'name' => 'Samsung Galaxy S9',
//        'type' => 'simple',
//        'description' => '<p>Pellentesque egestas, neque sit amet convallis pulvinar, justo nulla eleifend augue, ac auctor orci leo non est. Phasellus gravida semper nisi. Ut non enim eleifend felis pretium feugiat. Nullam accumsan lorem in dui. Vivamus elementum semper nisi.</p>
//
//<p>Maecenas egestas arcu quis ligula mattis placerat. Sed in libero ut nibh placerat accumsan. Quisque ut nisi. Aenean imperdiet. Curabitur at lacus ac velit ornare lobortis.</p>',
//        'shipping' => ["width" => null, "height" => null, "length" => null, "weight" => null, "enabled" => 0],
//        'caption' => 'Sed aliquam ultrices mauris',
//        'is_featured' => 1
//    );
//
//    $s9 = \Corals\Modules\Ecommerce\Models\Product::updateOrCreate(['name' => $s9['name']], $s9);
//
//    \Corals\Modules\Ecommerce\Models\SKU::updateOrCreate(['product_id' => $s9->id], [
//        'regular_price' => 799,
//        'code' => 'SG-S9',
//        'inventory' => 'infinite', 'status' => 'active'
//    ]);
//
//    $s9->categories()->sync([$samsungCat->id]);
//    $s9->tags()->sync($tagsObjects->whereIn('slug', ['galaxy', 'mobile', 's9'])->pluck('id')->toArray());
//
//    //================Note8=====================
//    $note8 = array(
//        'name' => 'Samsung Note 8',
//        'type' => 'simple',
//        'description' => '<p>Vivamus euismod mauris. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Vestibulum suscipit nulla quis orci. Etiam rhoncus.</p>
//
//<p>Proin viverra, ligula sit amet ultrices semper, ligula arcu tristique sapien, a accumsan nisi mauris ac eros. Nullam sagittis. Aenean viverra rhoncus pede. Etiam ultricies nisi vel augue. Nam at tortor in tellus interdum sagittis.</p>',
//        'status' => 'active',
//        'shipping' => ["width" => null, "height" => null, "length" => null, "weight" => null, "enabled" => 0],
//        'caption' => 'Aenean tellus metus bibendum',
//        'is_featured' => 1,
//    );
//
//    $note8 = \Corals\Modules\Ecommerce\Models\Product::updateOrCreate(['name' => $note8['name']], $note8);
//    \Corals\Modules\Ecommerce\Models\SKU::updateOrCreate(['product_id' => $note8->id], [
//        'regular_price' => 949,
//        'code' => 'SN-8',
//        'inventory' => 'infinite', 'status' => 'active'
//    ]);
//    $note8->categories()->sync([$samsungCat->id]);
//    $note8->tags()->sync($tagsObjects->whereIn('slug', ['galaxy', 'mobile'])->pluck('id')->toArray());
//
//    //================Mate10=====================
//    $mate10 = array(
//        'name' => 'Huawei Mate 10',
//        'type' => 'simple',
//        'description' => '<p>Praesent nonummy mi in odio. Quisque malesuada placerat nisl. Quisque malesuada placerat nisl. Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Vestibulum ullamcorper mauris at ligula.</p>
//
//<p>Sed a libero. Fusce neque. Proin magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Phasellus gravida semper nisi.</p>',
//        'status' => 'active',
//        'shipping' => ["width" => null, "height" => null, "length" => null, "weight" => null, "enabled" => 0],
//        'caption' => 'Vestibulum facilisis purus nec',
//        'is_featured' => 1,
//    );
//    $mate10 = \Corals\Modules\Ecommerce\Models\Product::updateOrCreate(['name' => $mate10['name']], $mate10);
//    \Corals\Modules\Ecommerce\Models\SKU::updateOrCreate(['product_id' => $mate10->id], [
//        'regular_price' => 755,
//        'code' => 'HM-10',
//        'inventory' => 'infinite', 'status' => 'active'
//    ]);
//    $mate10->categories()->sync([$huaweiCat->id]);
//    $mate10->tags()->sync($tagsObjects->whereIn('slug', ['mobile'])->pluck('id')->toArray());
//
//    //================iPhone8=====================
//    $iphone8 = array(
//        'name' => 'Apple iPhone 8',
//        'type' => 'simple',
//        'description' => '<p>Nulla neque dolor, sagittis eget, iaculis quis, molestie non, velit. Sed mollis, eros et ultrices tempus, mauris ipsum aliquam libero, non adipiscing dolor urna a orci. Vivamus in erat ut urna cursus vestibulum. Sed hendrerit. Suspendisse non nisl sit amet velit hendrerit rutrum.</p>
//
//<p>Maecenas nec odio et ante tincidunt tempus. Nulla facilisi. Suspendisse eu ligula. Praesent porttitor, nulla vitae posuere iaculis, arcu nisl dignissim dolor, a pretium mi sem ut ipsum. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>',
//        'status' => 'active',
//        'shipping' => ["width" => null, "height" => null, "length" => null, "weight" => null, "enabled" => 0],
//        'caption' => 'Praesent ac sem eget',
//        'is_featured' => 1,
//    );
//
//    $iphone8 = \Corals\Modules\Ecommerce\Models\Product::updateOrCreate(['name' => $iphone8['name']], $iphone8);
//    \Corals\Modules\Ecommerce\Models\SKU::updateOrCreate(['product_id' => $iphone8->id], [
//        'regular_price' => 999,
//        'code' => 'Ai-8',
//        'inventory' => 'infinite', 'status' => 'active'
//    ]);
//    $iphone8->categories()->sync([$appleCat->id]);
//    $iphone8->tags()->sync($tagsObjects->whereIn('slug', ['mobile', 'iphone', 'ios11'])->pluck('id')->toArray());
//
//    $iphone7 = array(
//        'name' => 'Apple iPhone 7',
//        'type' => 'simple',
//        'description' => '<p>Suspendisse pulvinar, augue ac venenatis condimentum, sem libero volutpat nibh, nec pellentesque velit pede quis nunc. Sed aliquam ultrices mauris. Fusce neque. Fusce vel dui. Pellentesque commodo eros a enim.</p>
//
//<p>Fusce egestas elit eget lorem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce id purus. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Vestibulum suscipit nulla quis orci. Curabitur nisi.</p>',
//        'status' => 'active',
//        'shipping' => ["width" => null, "height" => null, "length" => null, "weight" => null, "enabled" => 0],
//        'caption' => 'Etiam feugiat lorem non',
//        'is_featured' => 1,
//    );
//
//    $iphone7 = \Corals\Modules\Ecommerce\Models\Product::updateOrCreate(['name' => $iphone7['name']], $iphone7);
//    \Corals\Modules\Ecommerce\Models\SKU::updateOrCreate(['product_id' => $iphone7->id], [
//        'regular_price' => 785,
//        'code' => 'Ai-7',
//        'inventory' => 'infinite', 'status' => 'active'
//    ]);
//    $iphone7->categories()->sync([$appleCat->id]);
//    $iphone7->tags()->sync($tagsObjects->whereIn('slug', ['mobile', 'iphone', 'ios11'])->pluck('id')->toArray());
//
//
//    $productsMedia = array(
//        array(
//            'model_id' => $s9->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => '022118-primary-selection-S9-GalaxyLanding-L',
//            'file_name' => '022118-primary-selection-S9-GalaxyLanding-L.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 15404,
//            'custom_properties' => ["root" => "demo", 'key' => '16'],
//        ),
//        array(
//            'model_id' => $s9->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'Exclusive-Samsung-Galaxy-S9-Renders-And-360-Degree-Video',
//            'file_name' => 'Exclusive-Samsung-Galaxy-S9-Renders-And-360-Degree-Video.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 69845,
//            'custom_properties' => ["root" => "demo", 'key' => '17'],
//        ),
//        array(
//            'model_id' => $s9->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'galaxy-s9_acc_img02',
//            'file_name' => 'galaxy-s9_acc_img02.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 112885,
//            'custom_properties' => ["root" => "demo", 'key' => '18'],
//        ),
//        array(
//            'model_id' => $s9->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'galaxy-s9_acc_img01',
//            'file_name' => 'galaxy-s9_acc_img01.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 173338,
//            'custom_properties' => ["root" => "demo", 'key' => '19'],
//        ),
//        array(
//            'model_id' => $s9->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'galaxy-s9_camera_lowlight_visual-purple',
//            'file_name' => 'galaxy-s9_camera_lowlight_visual-purple.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 44041,
//            'custom_properties' => ["root" => "demo", 'key' => '20'],
//        ),
//        array(
//            'model_id' => $s9->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'samsung_galaxy_s9_plus_samacy',
//            'file_name' => 'samsung_galaxy_s9_plus_samacy.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 18492,
//            'custom_properties' => ["root" => "demo", 'key' => '21'],
//        ),
//        array(
//            'model_id' => $s9->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'samsung-galaxy-s9-plus',
//            'file_name' => 'samsung-galaxy-s9-plus.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 65779,
//            'custom_properties' => ["root" => "demo", 'key' => '22', 'featured' => true],
//        ),
//        array(
//            'model_id' => $note8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'galaxy-note8_acc',
//            'file_name' => 'galaxy-note8_acc.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 31799,
//            'custom_properties' => ["root" => "demo", 'key' => '23'],
//        ),
//        array(
//            'model_id' => $note8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'galaxy-note8-spec_design_actual_img01',
//            'file_name' => 'galaxy-note8-spec_design_actual_img01.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 39820,
//            'custom_properties' => ["root" => "demo", 'key' => '24'],
//        ),
//        array(
//            'model_id' => $note8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'galaxy-note8-spec_design_actual_img03',
//            'file_name' => 'galaxy-note8-spec_design_actual_img03.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 42874,
//            'custom_properties' => ["root" => "demo", 'key' => '25'],
//        ),
//        array(
//            'model_id' => $note8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'galaxy-note8-spec_design_illustrator',
//            'file_name' => 'galaxy-note8-spec_design_illustrator.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 17215,
//            'custom_properties' => ["root" => "demo", 'key' => '26'],
//        ),
//        array(
//            'model_id' => $note8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'Note8-GalaxyLanding-L',
//            'file_name' => 'Note8-GalaxyLanding-L.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 12956,
//            'custom_properties' => ["root" => "demo", 'key' => '27', 'featured' => true],
//        ),
//        array(
//            'model_id' => $mate10->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'download',
//            'file_name' => 'download.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 6296,
//            'custom_properties' => ["root" => "demo", 'key' => '28'],
//        ),
//        array(
//            'model_id' => $mate10->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'huawei_mate10_pro_light_oak_wood_skins_2048x',
//            'file_name' => 'huawei_mate10_pro_light_oak_wood_skins_2048x.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 164455,
//            'custom_properties' => ["root" => "demo", 'key' => '29'],
//        ),
//        array(
//            'model_id' => $mate10->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'Huawei-Mate-10-and-Mate-10-Pro-2',
//            'file_name' => 'Huawei-Mate-10-and-Mate-10-Pro-2.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 62339,
//            'custom_properties' => ["root" => "demo", 'key' => '30'],
//        ),
//        array(
//            'model_id' => $mate10->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'huawei-mate10-pro-1',
//            'file_name' => 'huawei-mate10-pro-1.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 51076,
//            'custom_properties' => ["root" => "demo", 'key' => '31'],
//        ),
//        array(
//            'model_id' => $mate10->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'mate-10',
//            'file_name' => 'mate-10.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 63907,
//            'custom_properties' => ["root" => "demo", 'key' => '32', "featured" => true],
//        ),
//        array(
//            'model_id' => $iphone8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => '0-28089-iphone8andplustop1-l',
//            'file_name' => '0-28089-iphone8andplustop1-l.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 34058,
//            'custom_properties' => ["root" => "demo", 'key' => '33'],
//        ),
//        array(
//            'model_id' => $iphone8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => '47787',
//            'file_name' => '47787.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 28932,
//            'custom_properties' => ["root" => "demo", 'key' => '34'],
//        ),
//        array(
//            'model_id' => $iphone8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'design_charging_everywhere_large',
//            'file_name' => 'design_charging_everywhere_large.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 77705,
//            'custom_properties' => ["root" => "demo", 'key' => '35'],
//        ),
//        array(
//            'model_id' => $iphone8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'design_sizes_large',
//            'file_name' => 'design_sizes_large.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 94057,
//            'custom_properties' => ["root" => "demo", 'key' => '36'],
//        ),
//        array(
//            'model_id' => $iphone8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'display_brilliant_colors_large',
//            'file_name' => 'display_brilliant_colors_large.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 252368,
//            'custom_properties' => ["root" => "demo", 'key' => '37'],
//        ),
//        array(
//            'model_id' => $iphone8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iPhone8Plus_color_selection',
//            'file_name' => 'iPhone8Plus_color_selection.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 117601,
//            'custom_properties' => ["root" => "demo", 'key' => '38'],
//        ),
//        array(
//            'model_id' => $iphone8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iphone8-plus-gold-select-2017',
//            'file_name' => 'iphone8-plus-gold-select-2017.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 52893,
//            'custom_properties' => ["root" => "demo", 'key' => '39', "featured" => true],
//        ),
//        array(
//            'model_id' => $iphone8->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iphone8silverdesign-800x521',
//            'file_name' => 'iphone8silverdesign-800x521.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 27347,
//            'custom_properties' => ["root" => "demo", 'key' => '40'],
//        ),
//        array(
//            'model_id' => $iphone7->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iphone7display-800x570',
//            'file_name' => 'iphone7display-800x570.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 69128,
//            'custom_properties' => ["root" => "demo", 'key' => '41'],
//        ),
//        array(
//            'model_id' => $iphone7->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iphone7lineup',
//            'file_name' => 'iphone7lineup.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 51366,
//            'custom_properties' => ["root" => "demo", 'key' => '42'],
//        ),
//        array(
//            'model_id' => $iphone7->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iphone7-matblk_unAC06C_picture_srcset_x400',
//            'file_name' => 'iphone7-matblk_unAC06C_picture_srcset_x400.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 31705,
//            'custom_properties' => ["root" => "demo", 'key' => '43', 'featured' => true],
//        ),
//        array(
//            'model_id' => $iphone7->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iphone7-plus-black-select-2016',
//            'file_name' => 'iphone7-plus-black-select-2016.png',
//            'mime_type' => 'image/png',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 140999,
//            'custom_properties' => ["root" => "demo", 'key' => '44'],
//        ),
//        array(
//            'model_id' => $iphone7->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iPhonePlus7_Black_Front',
//            'file_name' => 'iPhonePlus7_Black_Front.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 23659,
//            'custom_properties' => ["root" => "demo", 'key' => '45'],
//        ),
//        array(
//            'model_id' => $iphone7->id,
//            'model_type' => 'Corals\\Modules\\Ecommerce\\Models\\Product',
//            'collection_name' => 'ecommerce-product-gallery',
//            'name' => 'iphone7-rosegold-select-2016',
//            'file_name' => 'iphone7-rosegold-select-2016.jpg',
//            'mime_type' => 'image/jpeg',
//            'disk' => 'media', 'manipulations' => '[]',
//            'size' => 42977,
//            'custom_properties' => ["root" => "demo", 'key' => '46'],
//        ),
//    );
//
//    foreach ($productsMedia as $media) {
//        try {
//            \Spatie\MediaLibrary\Media::updateOrCreate([
//                'model_id' => $media['model_id'], 'model_type' => $media['model_type'], 'file_name' => $media['file_name']
//            ], $media);
//        } catch (\Exception $exception) {
//            logger($exception->getMessage());
//        }
//    }
}

if (class_exists(\Corals\Modules\Slider\Models\Slider::class) && \Schema::hasTable('sliders')) {
    $slider = \Corals\Modules\Slider\Models\Slider::updateOrCreate(['key' => 'e-commerce-home-page-slider'],
        array(
            'name' => 'E-commerce Home Page Slider',
            'key' => 'e-commerce-home-page-slider',
            'status' => 'active',
            'type' => 'images',
            'init_options' => json_decode('{"items":{"number":"1"},"margin":{"number":"0"},"loop":{"boolean":"false"},"center":{"boolean":"false"},"mouseDrag":{"boolean":"true"},"touchDrag":{"boolean":"true"},"stagePadding":{"number":"0"},"merge":{"boolean":"false"},"mergeFit":{"boolean":"true"},"autoWidth":{"boolean":"false"},"URLhashListener":{"boolean":"false"},"nav":{"boolean":"false"},"rewind":{"boolean":"true"},"navText":{"array":"[\'next\',\'prev\']"},"dots":{"boolean":"true"},"dotsEach":{"number\\/boolean":"false"},"dotData":{"boolean":"false"},"lazyLoad":{"boolean":"true"},"lazyContent":{"boolean":"true"},"autoplay":{"boolean":"true"},"autoplayTimeout":{"number":"3000"},"autoplayHoverPause":{"boolean":"true"},"autoplaySpeed":{"number\\/boolean":"false"},"navSpeed":{"number\\/boolean":"false"},"dotsSpeed":{"number\\/boolean":"false"},"dragEndSpeed":{"number\\/boolean":"false"},"callbacks":{"boolean":"true"},"responsive":{"object":"false"},"video":{"boolean":"false"},"videoHeight":{"number\\/boolean":"false"},"videoWidth":{"number\\/boolean":"false"},"animateOut":{"array\\/boolean":"false"},"animateIn":{"array\\/boolean":"false"}}', true),
        ));
    $slides = array(
        array(
            'name' => 'E-First Slide',
            'content' => '/assets/themes/ecommerce-basic/img/slider/ecommerce-1.png',
            'slider_id' => $slider->id,
            'status' => 'active',
        ),
        array(
            'name' => 'E-Second Slide',
            'content' => '/assets/themes/ecommerce-basic/img/slider/ecommerce-2.png',
            'slider_id' => $slider->id,
            'status' => 'active',
        )
    );

    foreach ($slides as $slide) {
        \Corals\Modules\Slider\Models\Slide::updateOrCreate(
            ['slider_id' => $slide['slider_id'], 'name' => $slide['name']],
            $slide
        );
    }
}

if (\Schema::hasTable('cms_blocks') && class_exists(\Corals\Modules\CMS\Models\Block::class)) {
    $block = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'Home Stores Features', 'key' => 'home-stores-features'], [
        'name' => 'Home Stores Features',
        'key' => 'home-stores-features',
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
}
/**
 * random orders
 * $skus = \Corals\Modules\Ecommerce\Models\SKU::get();
 *$statuses = ['pending', 'processing', 'canceled', 'completed'];
 * foreach ($skus as $sku) {
 * $userId = random_int(5, 259);
 * $qt = random_int(1, 4);
 * $items = [];
 *
 * $shippingItems = [
 * [
 * 'amount' => 10.00,
 * 'description' => 'Flat Rate -  Shipping',
 * 'quantity' => 1,
 * 'sku_code' => 'FlatRate|Flat Rate',
 * 'type' => 'Shipping',
 * 'item_options' => null
 * ],
 * [
 * 'amount' => 7.75,
 * 'description' => 'USPS - Parcel Select Shipping',
 * 'quantity' => 1,
 * 'sku_code' => 'Shippo|' . str_random(32),
 * 'type' => 'Shipping',
 * 'item_options' => null
 * ],
 * [
 * 'amount' => 4.66,
 * 'description' => 'USPS - First-Class Package/Mail Parcel Shipping',
 * 'quantity' => 1,
 * 'sku_code' => 'Shippo|' . str_random(32),
 * 'type' => 'Shipping',
 * 'item_options' => null
 * ]
 * ];
 * $discountItem = [
 * 'amount' => -45,
 * 'description' => 'Discount Coupon',
 * 'quantity' => 1,
 * 'sku_code' => 'CORALS-FIXED',
 * 'type' => 'Discount',
 * 'item_options' => null
 * ];
 * $skuItem = [
 * 'amount' => $sku->price,
 * 'description' => $sku->product->name,
 * 'quantity' => $qt,
 * 'sku_code' => $sku->code,
 * 'type' => 'Product',
 * 'item_options' => '{\"product_options\":[]}'
* ];
 *
 * $items[] = $skuItem;
 *
 * if ($sku->id % 2) {
 * $items[] = $discountItem;
 * }
 *
 * $items[] = $shippingItems[random_int(0, 2)];
 *
 * $amount = 0;
 *
 * foreach ($items as $item) {
 * $amount += $item['amount'] * $item['quantity'];
 * }
 * $orderNum = \Ecommerce::createOrderNumber();
 *
 * $orderId = \DB::table('ecommerce_orders')->insertGetId([
 * 'amount' => $amount,
 * 'currency' => 'USD',
 * 'order_number' => $orderNum,
 * 'billing' => '{\"status\":\"pending\",\"label_url\":\"\",\"tracking_number\":\"\",\"shipping_address\":{\"address_1\":\"711-2880 Nulla St.\",\"address_2\":\"Cecilia Chapman\",\"type\":\"shipping\",\"city\":\"Mankato\",\"state\":\"MS\",\"zip\":\"96522\",\"country\":\"US\"},\"shipping_provider\":\"FlatRate\",\"selected_shipping\":{\"provider\":\"Flat Rate\",\"service\":\"\",\"currency\":\"USD\",\"amount\":\"10.00\",\"estimated_days\":\"\"}}\', \'{\"billing_address\":{\"address_1\":\"711-2880 Nulla St.\",\"address_2\":\"Cecilia Chapman\",\"type\":\"billing\",\"city\":\"Mankato\",\"state\":\"MS\",\"zip\":\"96522\",\"country\":\"US\"},\"payment_reference\":\"ch_1C8YJrG0x8xKQUt93uHWgRQr\",\"gateway\":\"Stripe\",\"payment_status\":\"paid\"}',
* 'status' => $statuses[random_int(0, 3)],
 * 'user_id' => $userId,
 * 'created_at' => Carbon\Carbon::now()->subDays($userId)->toDateString(),
 * 'updated_at' => Carbon\Carbon::now()->subDays($userId / 2)->toDateString(),
 * ]);
 *
 * foreach ($items as $index => $item) {
 * $items[$index]['order_id'] = $orderId;
 * }
 *
 * \DB::table('ecommerce_order_items')->insert($items);
 * }
 *
 *
 *  $orders = \Corals\Modules\Ecommerce\Models\Order::get();
 *
 * foreach ($orders as $order) {
 * $invoice = \Corals\Modules\Payment\Models\Invoice::create([
 * 'code' => str_random(6),
 * 'currency' => $order->currency,
 * 'status' => 'paid',
 * 'invoicable_id' => $order->id,
 * 'invoicable_type' => get_class($order),
 * due_date' => $order->created_at,
 * 'sub_total' => $order->amount,
 * 'total' => $order->amount,
 * 'user_id' => $order->user->id,
 * 'created_at' => $order->created_at
 * ]);
 *
 * $invoice_items = [];
 * foreach ($order->items as $order_item) {
 * $invoice_items[] = [
 * 'code' => str_random(6),
 * 'description' => $order_item->description,
 * 'amount' => $order_item->amount,
 * 'itemable_id' => $order_item->id,
 * 'itemable_type' => get_class($order_item),
 * ];
 * }
 *
 * $invoice->items()->createMany($invoice_items);
 * }
 *
 *
 *
 *
 *
 *  $users = \Corals\User\Models\User::whereHas('roles', function ($role) {
 * $role->where('name', 'member');
 * })->get();
 *
 * foreach ($users as $user) {
 * if ($user->id % 25 == 0) {
 * for ($g = 1; $g <= 28; $g++) {
 * \Trexology\ReviewRateable\Models\Rating::create([
 * 'rating' => random_int(3, 5),
 * 'title' => 'Maecenas egestas arcu quis ligula',
 * 'body' => 'Nunc nonummy metus. Morbi nec metus. Aliquam eu nunc. Pellentesque ut neque. Cras dapibus.',
 * 'reviewrateable_id' => $g,
 * 'reviewrateable_type' => \Corals\Modules\Ecommerce\Models\Product::class,
 * 'author_id' => $user->id,
 * 'author_type' => Corals\User\Models\User::class
 * ]);
 * }
 * }
 * }
 */