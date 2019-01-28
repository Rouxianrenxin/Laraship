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
            'meta_keywords' => 'home',
            'meta_description' => 'home',
            'content' => '<div id="slider">@slider(home-page-slider)</div>
<section class="features-section border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3 margin-b-30">
                <div class="feature-box-center text-center">
                    <i class="ion-iphone"></i>
                    <h4 class="text-capitalize">Fully Responsive</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
                    </p>
                </div>
            </div><!--/col-->
            <div class="col-md-6 col-lg-3  margin-b-30">
                <div class="feature-box-center text-center">
                    <i class="ion-ios-person-outline"></i>
                    <h4 class="text-capitalize">User Friendly</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
                    </p>
                </div>
            </div><!--/col-->
            <div class="col-md-6 col-lg-3  margin-b-30">
                <div class="feature-box-center text-center">
                    <i class="ion-ios-cog-outline"></i>
                    <h4 class="text-capitalize">Well Documented</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
                    </p>
                </div>
            </div><!--/col-->
            <div class="col-md-6 col-lg-3 margin-b-30">
                <div class="feature-box-center text-center">
                    <i class="ion-key"></i>
                    <h4 class="text-capitalize">Easy & Customizable</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
                    </p>
                </div>
            </div><!--/col-->
        </div>
    </div>
</section><!--end features section-->
<section class="showcase-section">
    <div class="space-90"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 margin-b-30">
                <h3>
                    Easily customizable with great user interface.
                </h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pellentesque efficitur turpis, vitae
                    dictum dolor tristique in. Mauris tristique id urna at cursus. Aliquam maximus, ligula nec commodo
                    maximus, felis metus sagittis ligula, lobortis consequat ante risus ut elit.
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list">
                            <li><i class="ion-ios-arrow-thin-right"></i>Lorem ipsum dolor</li>
                            <li><i class="ion-ios-arrow-thin-right"></i>Duis lacinia dolor quis</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list">
                            <li><i class="ion-ios-arrow-thin-right"></i>Lorem ipsum dolor</li>
                            <li><i class="ion-ios-arrow-thin-right"></i>Duis lacinia dolor</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 margin-b-30">
                <img src="/assets/themes/saas/images/shot1.png" alt="" class="img-fluid center-img">
            </div>
        </div>
        <div class="space-60"></div>
    </div>
</section><!--end showcase section-->
<section class="showcase-section bg-faded">
    <div class="space-90"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-6 ml-auto margin-b-30">
                <img src="/assets/themes/saas/images/iphone.png" alt="" class="img-fluid">
            </div>
            <div class="col-lg-5 col-md-6 mr-auto margin-b-30">
                <h3>
                    A fully featured & well designed template that works perfectly on all devices.
                </h3>
                <p class="margin-b-20">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pellentesque efficitur turpis, vitae
                    dictum dolor tristique in. Mauris tristique id urna at cursus. Aliquam maximus, ligula nec commodo
                    maximus, felis metus sagittis ligula, lobortis consequat ante risus ut elit.
                </p>
                <a href="https://www.laraship.com/laraship-features/" class="btn btn-lg btn-primary btn-rounded">Learn More</a>
            </div>
        </div>
    </div>
    <div class="space-30"></div>
</section><!--end showcase section-->

<section class="testimonials skin-bg">
    <div class="space-90"></div>
    <div class="container">
        <div class="center-title">
            <h2>True words from our customers.</h2>
            <p>Over 500,000 Customers worldwide</p>
        </div>

        <div class="row">
            <div class="col-lg-4 margin-b-30">
                <div class="feedback-box">
                    <p>
                        "let me congratulate you on how great product Laraship is. I bought several other "solutions", Laravel Spark, for instance, but neither one was really the solution I was looking for. That until I found Laraship, which is what I was looking for."
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-2.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>Roberto Fernandez</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 margin-b-30">
                <div class="feedback-box">
                    <p>
                        "Awesome platform, great features and code quality, would love to see this plugin get some extra features and more detailed documentation. Keep it up!"
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-2.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>Nasser Ali</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 margin-b-30">
                <div class="feedback-box">
                    <p>
                        "Developer Has EXCELLENT Customer Support and very friendly! The Script is Written very well and Functions as Mentioned!"
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-3.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>Angela Roy</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space-60"></div>
</section><!--end testimonials section-->

<section class="steps">
    <div class="space-90"></div>
    <div class="container">
        <div class="center-title">
            <h2>Easy to get started. 3 Step process.</h2>
            <p>Take a look what the people think about our product</p>
        </div>
        <div class="row">
            <div class="col-md-4 margin-b-30">
                <div class="step-box">
                    <h1>01</h1>
                    <h4>Create Account.</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pellentesque efficitur turpis,
                        vitae dictum dolor tristique in.
                    </p>
                </div>
            </div>
            <div class="col-md-4 margin-b-30">
                <div class="step-box">
                    <h1>02</h1>
                    <h4>Select Plan.</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pellentesque efficitur turpis,
                        vitae dictum dolor tristique in.
                    </p>
                </div>
            </div>
            <div class="col-md-4 margin-b-30">
                <div class="step-box">
                    <h1>03</h1>
                    <h4>Assign Tasks.</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pellentesque efficitur turpis,
                        vitae dictum dolor tristique in.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="space-60"></div>
</section><!--end steps-->
<section class="features-bg">
    <div class="container">
        <div class="center-title">
            <h2>Why choose Laraship</h2>
            <p>Over 500,000 Customers worldwide</p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="feature-icon-left clearfix">
                    <div class="icon">
                        <i class="ion-iphone"></i>
                    </div>
                    <div class="content">
                        <h4>Fully Responsive</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut.
                        </p>
                    </div>
                </div><!--/feature icon-->
                <div class="feature-icon-left clearfix">
                    <div class="icon">
                        <i class="ion-social-google"></i>
                    </div>
                    <div class="content">
                        <h4>Google fonts</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut.
                        </p>
                    </div>
                </div><!--/feature icon-->
                <div class="feature-icon-left clearfix">
                    <div class="icon">
                        <i class="ion-ios-copy"></i>
                    </div>
                    <div class="content">
                        <h4>Well documented</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut.
                        </p>
                    </div>
                </div><!--/feature icon-->
            </div>
            <div class="col-md-6">
                <div class="feature-icon-left clearfix">
                    <div class="icon">
                        <i class="ion-social-twitter"></i>
                    </div>
                    <div class="content">
                        <h4>Bootstrap based</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut.
                        </p>
                    </div>
                </div><!--/feature icon-->
                <div class="feature-icon-left clearfix">
                    <div class="icon">
                        <i class="ion-ios-person"></i>
                    </div>
                    <div class="content">
                        <h4>Item Support</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut.
                        </p>
                    </div>
                </div><!--/feature icon-->
                <div class="feature-icon-left clearfix">
                    <div class="icon">
                        <i class="ion-ios-cog"></i>
                    </div>
                    <div class="content">
                        <h4>Easy to use</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut.
                        </p>
                    </div>
                </div><!--/feature icon-->
            </div>
        </div>
    </div>
</section>

<section class="app-section bg-faded">
    <div class="space-90"></div>
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 margin-b-30">
                <!-- 16:9 aspect ratio -->
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="854" height="480" src="https://www.youtube.com/embed/8zxj-6smeVA" frameborder="0"
                            allowfullscreen></iframe>
                </div>
            </div>

            <div class="col-lg-5 ml-auto">
                <h3>Download our Platform and start your business.</h3>
                <p class="margin-b-20">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rhoncus magna a lacinia tempor. Fusce et
                    turpis posuere, imperdiet orci et, tempus ex. Nunc vitae pellentesque ipsum. Quisque id magna a nisl
                    vestibulum ullamcorper.
                </p>
                <div class="app-buttons">
                    <a href="https://codecanyon.net/item/laraship-pro-laravel-powerful-admin-user-cms-rules-memberships-settings-subscriptions/15650201"><img src="/assets/themes/saas/images/codecanyon.png" alt=""></a>
                </div>
            </div>

        </div>
    </div>
    <div class="space-60"></div>
</section>
<div class=\'container\'>
    <div class="space-90"></div>
    <div class="center-title">
        <h2>Our worldwide partners.</h2>
        <p>Over 500,000 Customers worldwide</p>
    </div>
    <ul class="row list-unstyled partners-list">
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p1.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p2.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p3.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p4.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p5.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p6.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p3.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p4.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p5.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p6.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p1.png" class="img-fluid" alt=""></a>
        </li>
        <li class="col-lg-2 col-md-4">
            <a href=\'#\'><img src="/assets/themes/saas/images/p2.png" class="img-fluid" alt=""></a>
        </li>
    </ul>
</div>
<div class="space-70"></div>
<div class="cta-skin">
    <div class="container text-center">
        <h2>Are you interested in Laraship</h2>
        <p>Give our platform a chance and test it here</p>
        <a href="/register" class="btn btn-rounded btn-white-border">Create Account</a>
    </div>
</div>
',
            'published' => 1,
            'published_at' => '2017-11-16 14:26:52',
            'private' => 0,
            'template' => 'full',
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-11-16 16:27:04',
            'updated_at' => '2017-11-16 16:27:07',
        ));
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'about-us', 'type' => 'page'],
        array(
            'title' => 'About Us',
            'meta_keywords' => 'about us',
            'meta_description' => 'about us',
            'content' => '
    <div class="row align-items-center margin-b-50 margin-t-20">
        <div class="col-md-12">
            <h3>
                Award winning & most popular web studio in the world.
            </h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud officia deserunt mollit exercitation.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud officia deserunt mollit exercitation.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3 class="margin-b-20">Our Mission</h3>
            <p class="margin-b-20">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud officia deserunt mollit exercitation.
            </p>

            <a href="/register" class="btn btn-primary btn-lg">Join Us Today</a>
        </div>
        <div class="col-md-6">
            <h3 class="margin-b-20">Some highlights</h3>
            <ul class="list">
                <li><i class="ion-checkmark"></i> Lightweight Template</li>
                <li><i class="ion-checkmark"></i> Customizable & easy to use </li>
                <li><i class="ion-checkmark"></i> Mobile friendly & Cross-browser</li>
                <li><i class="ion-checkmark"></i> Based on bootstrap </li>
            </ul>
        </div>
    </div>
    <div class="space-60"></div>
    <div class="border-bottom"></div>
    <div class="space-60"></div>
    <div class="row">
        <div class="col-sm-12">
            <div class="center-title">
                <h2>Meet our creative team.</h2>
                <p>Lorem ipsum dolor sit amet</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 margin-b-30 text-center">
            <img src="/assets/themes/saas/images/avtar-2.jpg" class="rounded-circle margin-b-20" alt="">
            <h4 class="text-capitalize margin-b-5">Adam Miller</h4>
            <p class="text-muted">UI/UX Designer</p>
        </div>
        <div class="col-lg-3 col-md-6  margin-b-30 text-center">
            <img src="/assets/themes/saas/images/avtar-3.jpg" class="rounded-circle margin-b-20" alt="">
            <h4 class="text-capitalize margin-b-5">Emily Howkins</h4>
            <p class="text-muted">UI/UX Designer</p>
        </div>
        <div class="col-lg-3 col-md-6  margin-b-30 text-center">
            <img src="/assets/themes/saas/images/avtar-1.jpg" class="rounded-circle margin-b-20" alt="">
            <h4 class="text-capitalize margin-b-5">Nikita Smith</h4>
            <p class="text-muted">UI/UX Designer</p>
        </div>
        <div class="col-lg-3 col-md-6  margin-b-30 text-center">
            <img src="/assets/themes/saas/images/avtar-4.jpg" class="rounded-circle margin-b-20" alt="">
            <h4 class="text-capitalize margin-b-5">John Doe</h4>
            <p class="text-muted">UI/UX Designer</p>
        </div>
        <div class="col-lg-3 col-md-6  margin-b-30 text-center">
            <img src="/assets/themes/saas/images/avtar-5.jpg" class="rounded-circle margin-b-20" alt="">
            <h4 class="text-capitalize margin-b-5">Adam Miller</h4>
            <p class="text-muted">UI/UX Designer</p>
        </div>
        <div class="col-lg-3 col-md-6  margin-b-30 text-center">
            <img src="/assets/themes/saas/images/avtar-6.jpg" class="rounded-circle margin-b-20" alt="">
            <h4 class="text-capitalize margin-b-5">Emily Howkins</h4>
            <p class="text-muted">UI/UX Designer</p>
        </div>
        <div class="col-lg-3 col-md-6  margin-b-30 text-center">
            <img src="/assets/themes/saas/images/avtar-7.jpg" class="rounded-circle margin-b-20" alt="">
            <h4 class="text-capitalize margin-b-5">Nikita Smith</h4>
            <p class="text-muted">UI/UX Designer</p>
        </div>
        <div class="col-lg-3 col-md-6  margin-b-30 text-center">
            <img src="/assets/themes/saas/images/avtar-8.jpg" class="rounded-circle margin-b-20" alt="">
            <h4 class="text-capitalize margin-b-5">John Doe</h4>
            <p class="text-muted">UI/UX Designer</p>
        </div>

    </div>
    <div class="space-60"></div>
    <div class="border-bottom"></div>

<div class="fun-facts">
    <div class="space-90"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-3 margin-b-30 text-center">
                <h1>18</h1>
                <p class="margin-b-0">
                    Products
                </p>
            </div>
            <div class="col-sm-6 col-md-3 margin-b-30 text-center">
                <h1>08K</h1>
                <p class="margin-b-0">
                    Copies Sold
                </p>
            </div>
            <div class="col-sm-6 col-md-3 margin-b-30 text-center">
                <h1>2.1M</h1>
                <p class="margin-b-0">
                    Register Users
                </p>
            </div>
            <div class="col-sm-6 col-md-3 margin-b-30 text-center">
                <h1>04</h1>
                <p class="margin-b-0">
                    Awards Winning
                </p>
            </div>
        </div>
    </div>
    <div class="space-60"></div>
</div>
<div class="cta-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Try Laraship now and take your project to a new level</h3>
            </div>
            <div class="col-md-4">
                <a href="https://codecanyon.net/item/laraship-pro-laravel-powerful-admin-user-cms-rules-memberships-settings-subscriptions/15650201" class="btn btn-rounded btn-white-border">Get Laraship Here</a>
            </div>
        </div>
    </div>
</div>

<section class="app-section">
    <div class="space-90"></div>
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 margin-b-30">
                <!-- 16:9 aspect ratio -->
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="854" height="480" src="https://www.youtube.com/embed/8zxj-6smeVA" frameborder="0" allowfullscreen=""></iframe>
                </div>
            </div>
            <div class="col-lg-5 ml-auto margin-b-30">
                <h3>Download our Platform and start your business.</h3>
                <p class="margin-b-20">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rhoncus magna a lacinia tempor. Fusce et
                    turpis posuere, imperdiet orci et, tempus ex. Nunc vitae pellentesque ipsum. Quisque id magna a nisl
                    vestibulum ullamcorper.
                </p>
                <div class="app-buttons">
                    <a href="https://codecanyon.net/item/laraship-pro-laravel-powerful-admin-user-cms-rules-memberships-settings-subscriptions/15650201"><img src="/assets/themes/saas/images/codecanyon.png" alt=""></a>
                </div>
            </div>

        </div>
    </div>
    <div class="space-60"></div>
</section>
',
            'published' => 1,
            'published_at' => '2017-11-16 11:56:34',
            'private' => 0,
            'type' => 'page',
            'template' => NULL,
            'author_id' => 1,
            'deleted_at' => NULL,
            'created_at' => '2017-11-16 11:56:34',
            'updated_at' => '2017-11-16 11:56:34',
        ));
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'blog', 'type' => 'page'],
        array(
            'title' => 'Blog',
            'meta_keywords' => 'Blog',
            'meta_description' => 'Blog',
            'content' => '<div class="text-center">
<h2>Blog</h2>
<p class="lead">Pellentesque habitant morbi tristique senectus et netus et malesuada</p>
</div>',
            'published' => 1,
            'published_at' => '2017-11-16 11:56:34',
            'private' => 0,
            'type' => 'page',
            'template' => 'right',
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
            'content' => '<div class="text-center">
<h2>Pricing</h2>

<p class="lead">Easy and Powerful products and plans management.</p>
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
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'contact-us', 'type' => 'page'],
        array(
            'title' => 'Contact Us',
            'meta_keywords' => 'Contact Us',
            'meta_description' => 'Contact Us',
            'content' => '<div class="text-center"><h2>Drop Your Message</h2><p class="lead" style="text-align: center;">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p></div>',
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
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'testimonials', 'type' => 'page'],
        array(
            'title' => 'What people says about us',
            'meta_keywords' => 'testimonials',
            'meta_description' => 'testimonials',
            'content' => '<section class="testimonials skin-bg">
    <div class="space-90"></div>
    <div class="container">
        <div class="center-title">
            <h2>True words from our customers.</h2>
            <p>Over 500,000 Customers worldwide</p>
        </div>

        <div class="row">
            <div class="col-lg-4 margin-b-30">
                <div class="feedback-box">
                    <p>
                        "let me congratulate you on how great product Laraship is. I bought several other "solutions", Laravel Spark, for instance, but neither one was really the solution I was looking for. That until I found Laraship, which is what I was looking for."
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-2.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>Roberto Fernandez</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 margin-b-30">
                <div class="feedback-box">
                    <p>
                        "Awesome platform, great features and code quality, would love to see this plugin get some extra features and more detailed documentation. Keep it up!"
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-2.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>Nasser Ali</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 margin-b-30">
                <div class="feedback-box">
                    <p>
                        "Developer Has EXCELLENT Customer Support and very friendly! The Script is Written very well and Functions as Mentioned!"
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-3.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>Angela Roy</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 margin-b-30">
                <div class="feedback-box">
                    <p>
                        " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rhoncus magna a lacinia tempor. Fusce et turpis posuere, imperdiet orci et, tempus ex. Nunc vitae pellentesque ipsum. Quisque id magna a nisl vestibulum ullamcorper. "
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-1.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>Nikita Miller</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 margin-b-30">
                <div class="feedback-box">
                    <p>
                        " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rhoncus magna a lacinia tempor. Fusce et turpis posuere, imperdiet orci et, tempus ex. Nunc vitae pellentesque ipsum. Quisque id magna a nisl vestibulum ullamcorper. "
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-2.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>John Doe</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 margin-b-30">
                <div class="feedback-box">
                    <p>
                        " Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rhoncus magna a lacinia tempor. Fusce et turpis posuere, imperdiet orci et, tempus ex. Nunc vitae pellentesque ipsum. Quisque id magna a nisl vestibulum ullamcorper. "
                    </p>
                </div>
                <div class="testi-info">
                    <img src="/assets/themes/saas/images/avtar-3.jpg" alt="" class="rounded-circle" width="60">
                    <div class="content">
                        <h4>Emily Howkins</h4>
                        <em>Laraship Customer</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space-60"></div>
</section>
<div class="cta-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Try Laraship now and take your project to a new level</h3>
            </div>
            <div class="col-md-4">
                <a href="https://codecanyon.net/item/laraship-pro-laravel-powerful-admin-user-cms-rules-memberships-settings-subscriptions/15650201" class="btn btn-rounded btn-white-border">Get Laraship Here</a>
            </div>
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
        'url' => 'testimonials',
        'active_menu_url' => 'testimonials',
        'name' => 'Testimonials',
        'description' => 'testimonials Menu Item',
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
        'order' => 970
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
        'icon' => 'fa fa-home',
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
}