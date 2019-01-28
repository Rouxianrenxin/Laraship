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
            'content' => '
            <div id="slider">@slider(home-page-slider)</div>',
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
            'content' => '
<section class="container mt-80">
    <div class="row">
        <div class="col-lg-8 mt-20">
            <h2 class="heading">An <span class="text-primary">Introduction</span></h2>
            <p class="lead">Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero.</p>
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
            <p class="text-justify nom">Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
        </div>
        <div class="col-lg-4 mt-20">
            <aside class="applynow-widget">
                <img src="/assets/themes/compo/images/applynow.png" class="img-fluid center-block" alt="">
                <div class="apply-info text-center">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <p class="font20">Give Laraship a chance!</p>
                    <a href="/login" class="btn btn-primary">Try Laraship Now</a>
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="container mt-100">
    <div class="row">
        <div class="col-lg-4">
            <div class="icon-box-3">            <!-- ***** Icon Box Style 3 ***** -->
                <div class="icon-box-icon">
                    <i class="fa fa-bullseye" aria-hidden="true"></i>
                </div>
                <div class="icon-box-content">
                    <h5 class="heading">Our Mission</h5>
                    <span class="text-white">We believe in working towards the common goal.</span>
                    <br><br>
                    <a href="https://www.laraship.com/docs/laraship/welcome-to-laraship/">Laraship Docs</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="icon-box-3">            <!-- ***** Icon Box Style 3 ***** -->
                <div class="icon-box-icon">
                    <i class="fa fa-crosshairs" aria-hidden="true"></i>
                </div>
                <div class="icon-box-content">
                    <h5 class="heading">Our Vision</h5>
                    <span class="text-white">We believe in working towards the common goal.</span>
                    <br><br>
                    <a href="https://www.laraship.com/shop/">Laraship Shop</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="icon-box-3">            <!-- ***** Icon Box Style 3 ***** -->
                <div class="icon-box-icon">
                    <i class="fa fa-book" aria-hidden="true"></i>
                </div>
                <div class="icon-box-content">
                    <h5 class="heading">Our Values</h5>
                    <span class="text-white">We believe in working towards the common goal.</span>
                    <br><br>
                    <a href="https://www.laraship.com/laraship-features/">Laraship Features</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mt-100">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="heading text-center">Board of <span class="text-primary">Directors</span>
                <span class="sub-heading">EDUComp is a fully responsive premium education theme for schools, colleges, insitutions and universities.</span>
                <span class="icon-divider"></span>
            </h2>
        </div>
        <div class="col-lg-3">
            <div class="teacher-card">
                <div class="head">
                    <img src="/assets/themes/compo/images/teacher-1.png" class="img-fluid" alt="">
                    <div class="info">
                        <ul class="social">
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                        <a href="/register" class="btn btn-primary btn-sm">View Profile</a>
                    </div>
                </div>
                <div class="body">
                    <h5 class="heading">Ms. Suzanne</h5>
                    <small>HOD, Maths Department</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="teacher-card">
                <div class="head">
                    <img src="/assets/themes/compo/images/teacher-2.png" class="img-fluid" alt="">
                    <div class="info">
                        <ul class="social">
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                        <a href="/register" class="btn btn-primary btn-sm">View Profile</a>
                    </div>
                </div>
                <div class="body">
                    <h5 class="heading">Mr. John Geiger</h5>
                    <small>HOD, Maths Department</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="teacher-card">
                <div class="head">
                    <img src="/assets/themes/compo/images/teacher-3.png" class="img-fluid" alt="">
                    <div class="info">
                        <ul class="social">
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                        <a href="/register" class="btn btn-primary btn-sm">View Profile</a>
                    </div>
                </div>
                <div class="body">
                    <h5 class="heading">Ms. Valene Swann</h5>
                    <small>HOD, Maths Department</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="teacher-card">
                <div class="head">
                    <img src="/assets/themes/compo/images/teacher-4.png" class="img-fluid" alt="">
                    <div class="info">
                        <ul class="social">
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                        <a href="/register" class="btn btn-primary btn-sm">View Profile</a>
                    </div>
                </div>
                <div class="body">
                    <h5 class="heading">Mr. Carrie Fowler</h5>
                    <small>HOD, Maths Department</small>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="bg-light pt-100 pb-100 mt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="logo-scroll owl-carousel">
                    <img src="/assets/themes/compo/images/logo-1.png" alt="">
                    <img src="/assets/themes/compo/images/logo-2.png" alt="">
                    <img src="/assets/themes/compo/images/logo-3.png" alt="">
                    <img src="/assets/themes/compo/images/logo-4.png" alt="">
                    <img src="/assets/themes/compo/images/logo-5.png" alt="">
                </div>
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
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'blog', 'type' => 'page'],
        array(
            'title' => 'Blog',
            'slug' => 'blog',
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
            'template' => 'full',
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
            'slug' => 'contact-us',
            'meta_keywords' => 'Contact Us',
            'meta_description' => 'Contact Us',
            'content' => '<div><h2 style="text-align: center;">Drop Your Message</h2><p class="lead" style="text-align: center;">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p></div>',
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
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'history', 'type' => 'page'],
        array(
            'title' => 'History',
            'slug' => 'history',
            'meta_keywords' => 'history',
            'meta_description' => 'history',
            'content' => '<section class="container mt-100 mb-40">
        <div class="row">
            <div class="col-lg-7">
                <h2 class="heading">An <span class="text-primary">Introduction</span></h2>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            </div>
            <div class="col-lg-5">
                <h2 class="heading">Our <span class="text-primary">Milestones</span></h2>
                <ul class="imp-dates">
                    <li>
                        <div class="when">
                            <span class="year">1968</span>
                            <span class="month">Mar</span>
                        </div>
                        <div class="what">
                            <h5 class="bold">Laid Foundation Stone</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Consectetur adipiscing elit.</p>
                        </div>
                    </li>
                    <li>
                        <div class="when">
                            <span class="year">1975</span>
                            <span class="month">Aug</span>
                        </div>
                        <div class="what">
                            <h5 class="bold">Added 3 more Branches</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Consectetur adipiscing elit.</p>
                        </div>
                    </li>
                    <li>
                        <div class="when">
                            <span class="year">1989</span>
                            <span class="month">Apr</span>
                        </div>
                        <div class="what">
                            <h5 class="bold">First Batch Passed Out</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Consectetur adipiscing elit.</p>
                        </div>
                    </li>
                </ul>   
            </div>
        </div>
    </section>
    
    <div class="clearfix pt-20 pb-20"></div>
    
    <div class="bg-primary mt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 motto">
                    <img src="/assets/themes/compo/images/motto.png" class="motto-img d-none d-md-block" alt=""><p class="motto-text">Creativity, passion and excellence. We discover the hidden genius in every stratup.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mt-100">
        <div class="row">
            <div class="col-lg-8">
                <div class="row flex-row">
                    <div class="col-lg-6 info-box bg-light">
                        <p class="fact">Estd. <span class="fact-fig">1968</span></p>
                    </div>            
                    <div class="col-lg-6 info-box">
                        <p class="font22 text-primary">We\'re taking pride every year.</p>
                        <p>A wonderful serenity has taken possession of my entire soul.</p>
                    </div>
                    <div class="col-lg-6 info-box">
                        <p class="font22 text-primary">We\'re taking pride every year.</p>
                        <p>A wonderful serenity has taken possession of my entire soul.</p>
                    </div>
                    <div class="col-lg-6 info-box bg-light">
                        <p class="fact">Ranked <span class="fact-fig">#1</span></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 info-box2x nop">
                <img src="/assets/themes/compo/images/gallery-4.jpg" alt="">
            </div>
        </div>
    </div>
    
    <section class="process-1 mt-100 pt-80 pb-80 parallax" style="background-image: url(\'/assets/themes/compo/images/bg-2.jpg\');" data-speed="4">
        <div class="container">
            <h2 class="heading text-white text-center">Our <span class="text-primary">Impact</span></h2>
            <div class="row">
                <div class="col-lg-3 process-box">
                    <div class="process-round">
                        <span class="number">01.</span>
                        <p>A wonderful serenity has taken possession of my entire soul.</p>
                    </div>
                </div>
                <div class="col-lg-3 process-box">
                    <div class="process-round">
                        <span class="number">02.</span>
                        <p>A wonderful serenity has taken possession of my entire soul.</p>
                    </div>
                </div>
                <div class="col-lg-3 process-box">
                    <div class="process-round">
                        <span class="number">03.</span>
                        <p>A wonderful serenity has taken possession of my entire soul.</p>
                    </div>
                </div>
                <div class="col-lg-3 process-box">
                    <div class="process-round">
                        <span class="number">04.</span>
                        <p>A wonderful serenity has taken possession of my entire soul.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>
    
    <div class="bg-light pt-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="testimonials owl-carousel">
                        <div class="testimonial-item">
                            <img src="/assets/themes/compo/images/testi-1.png" class="testimonial-img" alt="">
                            <div class="testimonial-text">
                                <p>A wonderful serenity has taken possession of my entire soul has taken possession of my entire soul. A wonderful serenity has taken possession of my entire soul has taken.</p>
                                <span class="testimonial-by">Mrs. Harry Ponting</span>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <img src="/assets/themes/compo/images/testi-2.png" class="testimonial-img" alt="">
                            <div class="testimonial-text">
                                <p>A wonderful serenity has taken possession of my entire soul has taken possession of my entire soul. A wonderful serenity has taken possession of my entire soul has taken.</p>
                                <span class="testimonial-by">Mrs. Harry Ponting</span>
                            </div>
                        </div>
                    </div>
                    <div class="owl-nav">
                        <span class="owl-left"><i class="fa fa-angle-left"></i></span>
                        <span class="owl-right"><i class="fa fa-angle-right"></i></span>
                    </div>
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
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'team', 'type' => 'page'],
        array(
            'title' => 'Team',
            'slug' => 'team',
            'meta_keywords' => 'team',
            'meta_description' => 'team',
            'content' => '<section class="container mt-100 mb-100">
        <h2 class="heading">Our <span class="text-primary">Team</span></h2>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <img src="/assets/themes/compo/images/teacher-1-thumb.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-9">
                        <h3>Ms. Laura Bilodeau</h3>
                        <h5 class="text-muted">Principle, Educomp Institute of Education </h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <img src="/assets/themes/compo/images/teacher-2-thumb.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-9">
                        <h3>Mr. Joseph Chappell</h3>
                        <h5 class="text-muted">Treasurer, Educomp Group</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <img src="/assets/themes/compo/images/teacher-3-thumb.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-9">
                        <h3>Ms. Shannon Tritt</h3>
                        <h5 class="text-muted">Operations Officer, Educomp Group</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <img src="/assets/themes/compo/images/teacher-4-thumb.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-9">
                        <h3>Mr. Heather Martinez</h3>
                        <h5 class="text-muted">Senior Professor, History</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
',
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
        'url' => 'history',
        'active_menu_url' => 'history',
        'name' => 'Our History',
        'description' => 'History Menu Item',
        'icon' => null,
        'target' => null,
        'order' => 980
    ]);
    Corals\Menu\Models\Menu::updateOrCreate([
        'parent_id' => $topMenuId,
        'key' => null,
        'url' => 'team',
        'active_menu_url' => 'team',
        'name' => 'Our Team',
        'description' => 'Team Menu Item',
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

if (\Schema::hasTable('cms_blocks') && class_exists(\Corals\Modules\CMS\Models\Block::class)) {
    $block = \Corals\Modules\CMS\Models\Block::updateOrCreate(['name' => 'Testimonial', 'key' => 'testimonial'], [
        'name' => 'Testimonial',
        'key' => 'testimonial',
    ]);

    $widgets = array(
        array(
            'title' => 'Testimonial 1',
            'content' => '<div class="testimonial-card">
                    <div class="head">
                        <img src="/assets/themes/compo/images/parent-1.jpg" class="rounded-circle testimonial-img"
                             alt="">
                    </div>
                    <div class="body">
                        <p class="testimonial-text">We\'re very happy with the laraship. There are an amazing team
                            behind this big platform.</p>
                        <p>
                            <i class="text-primary bold">Mr. Dereck</i>
                            <small class="text-muted">, Shop owner</small>
                        </p>
                    </div>
                </div>',
            'block_id' => $block->id,
            'widget_width' => 6,
            'widget_order' => 0,
            'status' => 'active',
        ),
        array(
            'title' => 'Testimonial 2',
            'content' => '<div class="testimonial-card">
                    <div class="head">
                        <img src="/assets/themes/compo/images/parent-2.jpg" class="rounded-circle testimonial-img"
                             alt="">
                    </div>
                    <div class="body">
                        <p class="testimonial-text">We\'re very happy with the laraship. There are an amazing team
                            behind this big platform.</p>
                        <p>
                            <i class="text-primary bold">Ms. Lois</i>
                            <small class="text-muted">, Developer</small>
                        </p>
                    </div>
                </div>',
            'block_id' => $block->id,
            'widget_width' => 6,
            'widget_order' => 1,
            'status' => 'active',
        ),
        array(
            'title' => 'Testimonial 3',
            'content' => '<div class="testimonial-card">
                    <div class="head">
                        <img src="/assets/themes/compo/images/parent-3.jpg" class="rounded-circle testimonial-img"
                             alt="">
                    </div>
                    <div class="body">
                        <p class="testimonial-text">We\'re very happy with the laraship. There are an amazing team
                            behind this big platform.</p>
                        <p>
                            <i class="text-primary bold">Mr. David</i>
                            <small class="text-muted">, Business Manager</small>
                        </p>
                    </div>
                </div>',
            'block_id' => $block->id,
            'widget_width' => 6,
            'widget_order' => 2,
            'status' => 'active',
        ),
        array(
            'title' => 'Testimonial 4',
            'content' => '<div class="testimonial-card">
                    <div class="head">
                        <img src="/assets/themes/compo/images/parent-1.jpg" class="rounded-circle testimonial-img"
                             alt="">
                    </div>
                    <div class="body">
                        <p class="testimonial-text">We\'re very happy with the laraship. There are an amazing team
                            behind this big platform.</p>
                        <p>
                            <i class="text-primary bold">Ms. Richard</i>
                            <small class="text-muted">, Product Manager</small>
                        </p>
                    </div>
                </div>',
            'block_id' => $block->id,
            'widget_width' => 6,
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
