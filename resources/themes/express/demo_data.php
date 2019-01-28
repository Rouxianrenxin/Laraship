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
            'content' => '<div id="slider">@slider(express-home-page-slider)</div>
            <div class="features-tabs-section" style="margin-top: 100px;">
    <div class="container">
        <div class="header">
            <h3>Accomplish more with Laraship</h3>
            <p>Choose your favorite formats for your own sites</p>
        </div>

        <div class="tabs-wrapper">
            <ul class="nav nav-tabs justify-content-center" id="feature-tabs">
                <li>
                    <a href="#home" class="active" data-toggle="tab">Upstart your development</a>
                </li>
                <li>
                    <a href="#profile" data-toggle="tab">Get ready in half the time</a>
                </li>
                <li>
                    <a href="#messages" data-toggle="tab">Collaborate with everyone</a>
                </li>
                <li>
                    <a href="#settings" data-toggle="tab">Get more done faster</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="home">
                    <div class="row">
                        <div class="col-lg-6 order-lg-2 image">
                            <img src="/assets/themes/express/images/portfolioitem1.png" class="img-fluid" alt="pic2" />
                        </div>
                        <div class="col-lg-6 order-lg-1 info">
                            <h4>You don\'t need to have any advanced technical</h4>
                            <p>
                                Whether you want to fill this paragraph with some text like I\'m doing right now, this place is perfect to describe some features or anything you want - Laraship has a complete solution for you.
                            </p>
                            <p>
                                You have complete control over the look & feel of your website, we offer the best quality so you take your site up and running in no time.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile">
                    <div class="row">
                        <div class="col-lg-6 image">
                            <img src="/assets/themes/express/images/tabs/pic1.png" class="img-fluid" alt="pic1" />
                        </div>
                        <div class="col-lg-6 info">
                            <h4>You don\'t need to have any advanced technical</h4>
                            <p>
                                Whether you want to fill this paragraph with some text like I\'m doing right now, this place is perfect to describe some features or anything you want - Laraship has a complete solution for you.
                            </p>
                            <p>
                                You have complete control over the look & feel of your website, we offer the best quality so you take your site up and running in no time.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="messages">
                    <div class="row">
                        <div class="col-lg-6 order-lg-2 image">
                            <img src="/assets/themes/express/images/tabs/pic2.png" class="img-fluid" alt="pic3" />
                        </div>
                        <div class="col-lg-6 order-lg-1 info">
                            <h4>You don\'t need to have any advanced technical</h4>
                            <p>
                                Whether you want to fill this paragraph with some text like I\'m doing right now, this place is perfect to describe some features or anything you want - Laraship has a complete solution for you.
                            </p>
                            <p>
                                You have complete control over the look & feel of your website, we offer the best quality so you take your site up and running in no time.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="settings">
                    <div class="row">
                        <div class="col-lg-6 image">
                            <img src="/assets/themes/express/images/tabs/pic1.png" class="img-fluid" alt="pic4" />
                        </div>
                        <div class="col-lg-6 info">
                            <h4>You don\'t need to have any advanced technical</h4>
                            <p>
                                Whether you want to fill this paragraph with some text like I\'m doing right now, this place is perfect to describe some features or anything you want - Laraship has a complete solution for you.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="features-section">
    <div class="container">
        <div class="header text-center">
            <h2>Need an easy way to customize your site?</h2>
            <p class="mt-3">Laraship is perfect for novice developers and experts alike.</p>
        </div>
        <div class="feature">
            <div class="row">
                <div class="col-md-6">
                    <div class="info">
                        <h4 class="mt-lg-5">You don\'t need to have great technical experience to use your product.</h4>
                        <p>
                            Whether you want to fill this paragraph with some text like I\'m doing right now, this place
                            is perfect to describe some features or anything you want - Laraship has a complete solution for you.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="/assets/themes/express/images/feature4.png" class="img-fluid" alt="feature1" />
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <div class="feature">
            <div class="row">
                <div class="col-md-6 order-md-2">
                    <div class="info">
                        <h4 class="mt-lg-4">A fully featured well design template that works.</h4>
                        <p>
                            You have complete control over the look & feel of your website, we offer the best quality so you
                            take your site up and running in no time.
                        </p>
                        <p>
                            Write some text here to explain the features of your site or application, it
                            has lots of uses.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 order-md-1 text-center">
                    <img src="/assets/themes/express/images/feature2.png" class="img-fluid" alt="feature2" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="features-hover-section">
    <div class="container">
        <div class="images">
            <img src="/assets/themes/express/images/services5.png" class="img-fluid active" alt="services1" />
            <img src="/assets/themes/express/images/services6.png" class="img-fluid" alt="services2" />
            <img src="/assets/themes/express/images/services7.png" class="img-fluid" alt="services3" />
        </div>
        <div class="features">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature active">
                        <strong>Your own dashboard</strong>
                        <p>
                            You can work with international customers right out of the box while you can keep staying in your country.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature">
                        <strong>Showcase your landing page</strong>
                        <p>
                            You can work with international customers right out of the box while you can keep staying in your country.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature">
                        <strong>Offer pricing plans</strong>
                        <p>
                            You can work with international customers right out of the box while you can keep staying in your country.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="testimonials-section">
    <div class="container">
        <h3 class="header">
            Trusted by a lot businesses around the world:
        </h3>
        <div class="row">
            <div class="col-md-6">
                <div class="testimonial">
                    <div class="quote">
                        I am just quoting some stuff but I am seriously happy about this product. Has a lot of powerful
                        features and is so easy to set up, I could stay customizing it day and night, it\'s just so much fun!
                        <div class="arrow-down">
                            <div class="arrow"></div>
                            <div class="arrow-border"></div>
                        </div>
                    </div>
                    <div class="author">
                        <img src="/assets/themes/express/images/testimonials/testimonial3.jpg" class="pic" alt="testimonial3" />
                        <div class="name">John McClane</div>
                        <div class="company">Microsoft</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="testimonial">
                    <div class="quote">
                        This thing is one of those tools that everybody should be using. I really like it and with this ease to use, you can kickstart your projects and apps and just focus on your business!
                        <div class="arrow-down">
                            <div class="arrow"></div>
                            <div class="arrow-border"></div>
                        </div>
                    </div>
                    <div class="author">
                        <img src="/assets/themes/express/images/testimonials/testimonial2.jpg" class="pic" alt="testimonial2" />
                        <div class="name">Carl Jones</div>
                        <div class="company">Pixar Co.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cta-section">
    <p>
        Start your free 14 day trial!
    </p>
    <a href="/register">
        Sign up for free
    </a>
</div>

<div class="clients-section">
    <div class="container">
        <h3>Our Customers</h3>
        <p>
            These are some of our customers who have helped us by using our product.
        </p>
        <div class="logos">
            <img src="/assets/themes/express/images/logos/google.png">
            <img src="/assets/themes/express/images/logos/facebook.png">
            <img src="/assets/themes/express/images/logos/apple.png">
            <img src="/assets/themes/express/images/logos/stripe.png">
            <img src="/assets/themes/express/images/logos/yahoo.png">
        </div>
    </div>
</div>',
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
            <div class="about-us-slider">
    <div class="container">
        <div class="header">
            <h3>About Laraship</h3>
            <p>
                You have to roll up your sleeves and be a stonecutter before you can become a sculptor – command of
                craft always precedes art.
            </p>
        </div>
        <img src="/assets/themes/express/images/office2.png" alt="office2"/>
    </div>
</div>
</div>

<div class="about-us-team">
    <div class="container">
        <h1 class="header">We care about our work</h1>
        <div class="row">
            <div class="col-md-6">
                <p>
                    Whether you want to fill this paragraph with some text like I\'m doing right now, this place is
                    perfect to describe some features or anything you want - Laraship has a complete solution for you.
                </p>
                <p>
                    You have complete control over the look & feel of your website, we offer the best quality so you
                    take your site up and running in no time.
                </p>
            </div>
            <div class="col-md-6">
                <p>
                    Laraship is a simple, developer-friendly way to get your site. Full of features, cool documentation
                    ease of use, lots of pages. We want to help bringing cool stuff to people so they can get their
                    projects faster.
                </p>
                <a href="/register" class="btn-shadow btn-shadow-info mt-3">Join our team</a>
            </div>
        </div>
        <div class="row stats">
            <div class="col-sm-3">
                <strong>13</strong>
                employees
            </div>
            <div class="col-sm-3">
                <strong>10k</strong>
                customers
            </div>
            <div class="col-sm-3">
                <strong>9</strong>
                template pages
            </div>
            <div class="col-sm-3">
                <strong>13k</strong>
                products sold
            </div>
        </div>
        <div class="team">
            <div class="team-row d-flex justify-content-around flex-wrap">
                <img src="/assets/themes/express/images/testimonials/testimonial7.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Eric Smith - CEO" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial2.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Rachel Dawes - PM" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial3.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Henry Hill - Developer" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial4.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Ana Rich - Designer" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial7.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Jessica Welch - Designer" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial8.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Charly - iOS Developer" alt="testimonial"/>
            </div>

            <div class="team-row d-flex justify-content-around flex-wrap">
                <img src="/assets/themes/express/images/testimonials/testimonial5.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Karen Stewart - PM" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial4.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Charly - iOS Developer" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial7.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Jessica Welch - Designer" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial8.jpg" class="img-fluid" data-toggle="tooltip"
                     title="John Raynolds - UI/UX" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial3.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Henry Hill - Developer" alt="testimonial"/>
                <img src="/assets/themes/express/images/testimonials/testimonial2.jpg" class="img-fluid" data-toggle="tooltip"
                     title="Rachel Dawes - PM" alt="testimonial"/>
            </div>
        </div>
    </div>
</div>

<div class="signup-cta">
    <div class="container">
        <div class="wrapper clearfix">
            <h4>Try Laraship now and take your business to a whole new level</h4>
            <a href="/register" class="btn-shadow btn-shadow-info btn-shadow-lg mt-4">Sign up free</a>
        </div>
    </div>
</div>
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
<h1>Blog</h1>
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
<h1>Pricing</h1>

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
            'content' => '<div class="text-center"><h2>Send us a message</h2>
<p>You can contact us with anything related to Laraship. <br/> We\'ll get in touch with you as soon as
                        possible.</p></div>',
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
    \Corals\Modules\CMS\Models\Page::updateOrCreate(['slug' => 'services', 'type' => 'page'],
        array(
            'title' => 'Our Services',
            'meta_keywords' => 'Our Services',
            'meta_description' => 'Our Services',
            'content' => '<div class="services-intro">
    <div class="container">
        <div class="row" style="overflow:hidden;">
            <div class="col-md-6 image">
                <img src="/assets/themes/express/images/services1.png" class="img-fluid animated fadeInUp" alt="services1" />
            </div>
            <div class="col-md-6 info">
                <h3>Here is everything we offer</h3>
                <p>
                    You will find a variety of ways to present your services such as grids and lists.
                </p>
                <p>
                    We plan to update this product with more pages and features as we keep on going.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="services-tabs">
    <div class="container">
        <nav class="nav nav-tabs justify-content-around">
            <a class="nav-link active" data-toggle="tab" href="#tab-web">
                <span class="icon brankic-monitor"></span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#tab-front">
                <span class="icon brankic-phone"></span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#tab-responsive">
                <span class="icon brankic-lamp3"></span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#tab-html">
                <span class="icon brankic-pictures3"></span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#tab-ps">
                <span class="icon brankic-upload2"></span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#tab-retina">
                <span class="icon brankic-tools"></span>
            </a>
        </nav>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-web">
                <h4>Web Development</h4>
                <p>
                    Whether you want to fill this paragraph with some text like I\'m doing right now, this place is perfect to describe some features or anything you want - Laraship has a complete solution for you.
                </p>
                <p>
                    Chances are, unless I’m a designer, I don’t know what I want. All I know is I want something functional that looks good, is comparable with my competitors, and features constant colour schemes for branding.
                </p>
            </div>
            <div class="tab-pane fade" id="tab-front">
                <h4>Frontend development</h4>
                <p>
                    I love making the stuff, that’s sort of the core of it. I love creating the stuff. It’s so satisfying to get from the beginning to the end, from a shaky nothing idea to something that’s well formed and the audience really likes. It’s like a drug: You keep trying to do it again and again and again. I’ve learned from experience that if you work harder at it, and apply more energy and time to it, and more consistency, you get a better result. It comes from the work.
                    <br />
                    This thing will work on any device, it has a very easy to understand documentation and is made with SASS.
                </p>
            </div>
            <div class="tab-pane fade" id="tab-responsive">
                <h4>Responsive web design</h4>
                <p>
                    We\'re always happy to offer support if you happen to have any doubts about anything, if you need some new stuff contact us.
                </p>
                <p>
                    You have to roll up your sleeves and be a stonecutter before you can become a sculptor – command of craft always precedes art: apprentice, journeyman, master. <br />
                    It doesn’t matter one damn bit whether fashion is art or not. You don’t question whether an incredible chef is an artist or not – his cakes are delicious and that’s all that matters.
                </p>
            </div>
            <div class="tab-pane fade" id="tab-html">
                <h4>HTML & CSS Development</h4>
                <p>
                    Well you’re in your little room and you’re working on something good but if it’s really good you’re gonna need a bigger room and when you’re in the bigger room you might not know what to do you might have to think of how you got started sitting in your little room.
                </p>
                <p>
                    We\'re always happy to offer support if you happen to have any doubts about anything, if you need some new stuff contact us.
                </p>
            </div>
            <div class="tab-pane fade" id="tab-ps">
                <h4>Photoshop Mockups</h4>
                <p>
                    I want everything we do to be beautiful. I don’t give a damn whether the client understands that that’s worth anything, or that the client thinks it’s worth anything, or whether it is worth anything. It’s worth it to me. It’s the way I want to live my life. I want to make beautiful things, even if nobody cares.
                </p>
                <p>
                    We\'ll be adding some new stuff to make it even more awesome, if you have any idea please let us know.
                </p>
            </div>
            <div class="tab-pane fade" id="tab-retina">
                <h4>Retina display</h4>
                <p>
                    Functionality is so over-valued in design, and we’ve kept design very small in that way. Functionality is the sheer minimum. If your house burns down, what do you take? The cat in the window that you got from your mother, or the chair you have?
                </p>
                <p>
                    Simply are looking to sell digital goods or are interested in drop shipping — Laraship has a complete solution in this.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="services-grid-section services-grid-section--border">
    <div class="container">
        <div class="header">
            <h3>Need an easy way to customize your site?</h3>
            <p>
                Laraship is perfect for novice developers and experts alike.
            </p>
        </div>
        <div class="services">
            <div class="row">
                <div class="col-md-4">
                    <div class="service">
                        <div class="pic">
                            <img src="/assets/themes/express/images/services2.png" class="img-fluid" alt="services1" />
                        </div>
                        <div class="info">
                            <strong>Get notifications instantly</strong>
                            <p>
                                You can work with international customers right out of the box while staying in your country.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service">
                        <div class="pic">
                            <img src="/assets/themes/express/images/services4.png" class="img-fluid" alt="services2" />
                        </div>
                        <div class="info">
                            <strong>Insights & Reports</strong>
                            <p>
                                You can work with international customers right out of the box while staying in your country.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service">
                        <div class="pic">
                            <img src="/assets/themes/express/images/services3.png" class="img-fluid" alt="services3" />
                        </div>
                        <div class="info">
                            <strong>Location Services</strong>
                            <p>
                                You can work with international customers right out of the box while staying in your country.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="services-showcase-section">
    <div class="container">
        <div class="header">
            <h3>Flexibility Built In</h3>
            <p>
                You can work with international customers right out of the box while staying in your country.
            </p>
        </div>
        <div class="services">
            <div class="row">
                <div class="col-md-6 service">
                    <img src="/assets/themes/express/images/circle-icons/full-color/globe.png" alt="globe" />
                    <div class="info">
                        <strong>Act locally, work globally</strong>
                        <p>You can work with international customers right out of the box while staying in your country.</p>
                    </div>
                </div>
                <div class="col-md-6 service">
                    <img src="/assets/themes/express/images/circle-icons/full-color/location.png" alt="location" />
                    <div class="info">
                        <strong>Act globally, work as usual</strong>
                        <p>With some customization you can make this product apply to your branding guidelines and amaze your customers at the same time.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 service">
                    <img src="/assets/themes/express/images/circle-icons/full-color/smartphone.png" alt="smartphone" />
                    <div class="info">
                        <strong>Act globally, work as usual</strong>
                        <p>We don\'t impose any design restrictions, you are free to customize it as you see fit and it\'s easy to use.</p>
                    </div>
                </div>
                <div class="col-md-6 service">
                    <img src="/assets/themes/express/images/circle-icons/full-color/support.png" alt="support" />
                    <div class="info">
                        <strong>Develop once, run everywhere</strong>
                        <p>We\'ll be adding some new stuff to make it even more awesome, if you have any idea please let us know.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="features-hover-section">
    <div class="container">
        <div class="images">
            <img src="/assets/themes/express/images/services5.png" class="img-fluid active" alt="services1" />
            <img src="/assets/themes/express/images/services6.png" class="img-fluid" alt="services2" />
            <img src="/assets/themes/express/images/services7.png" class="img-fluid" alt="services3" />
        </div>
        <div class="features">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature active">
                        <strong>Your own dashboard</strong>
                        <p>
                            You can work with international customers right out of the box while you can keep staying in your country.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature">
                        <strong>Showcase your landing page</strong>
                        <p>
                            You can work with international customers right out of the box while you can keep staying in your country.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature">
                        <strong>Offer pricing plans</strong>
                        <p>
                            You can work with international customers right out of the box while you can keep staying in your country.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="signup-cta">
    <div class="container">
        <div class="wrapper clearfix">
            <h4>Try Laraship now and take your business to a whole new level</h4>
            <a href="/register" class="btn-shadow btn-shadow-info btn-shadow-lg mt-4">Sign up free</a>
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
        'url' => 'services',
        'active_menu_url' => 'services',
        'name' => 'Our Services',
        'description' => 'Services Menu Item',
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


if (\Schema::hasTable('sliders')) {
    $slider = Corals\Modules\Slider\Models\Slider::updateOrCreate(['key' => 'express-home-page-slider'], array(
            'name' => 'Express Home Page Slider',
            'status' => 'active',
            'type' => 'images',
            'init_options' => json_decode('{"items":{"number":"1"},"margin":{"number":"0"},"loop":{"boolean":"false"},"center":{"boolean":"false"},"mouseDrag":{"boolean":"true"},"touchDrag":{"boolean":"true"},"stagePadding":{"number":"0"},"merge":{"boolean":"false"},"mergeFit":{"boolean":"true"},"autoWidth":{"boolean":"false"},"URLhashListener":{"boolean":"false"},"nav":{"boolean":"false"},"rewind":{"boolean":"true"},"navText":{"array":"[\'next\',\'prev\']"},"dots":{"boolean":"true"},"dotsEach":{"number\\/boolean":"false"},"dotData":{"boolean":"false"},"lazyLoad":{"boolean":"true"},"lazyContent":{"boolean":"true"},"autoplay":{"boolean":"true"},"autoplayTimeout":{"number":"3000"},"autoplayHoverPause":{"boolean":"true"},"autoplaySpeed":{"number\\/boolean":"false"},"navSpeed":{"number\\/boolean":"false"},"dotsSpeed":{"number\\/boolean":"false"},"dragEndSpeed":{"number\\/boolean":"false"},"callbacks":{"boolean":"true"},"responsive":{"object":"false"},"video":{"boolean":"false"},"videoHeight":{"number\\/boolean":"false"},"videoWidth":{"number\\/boolean":"false"},"animateOut":{"array\\/boolean":"false"},"animateIn":{"array\\/boolean":"false"}}', true),
            'deleted_at' => NULL,
            'created_at' => '2017-12-03 22:53:20',
            'updated_at' => '2017-12-03 23:13:24',
        )
    );

    \Corals\Modules\Slider\Models\Slide::updateOrCreate(['name' => 'First Slider', 'slider_id' => $slider->id], array(
        'content' => '/assets/themes/express/images/slides/slide_a.png',
        'status' => 'active',
        'deleted_at' => NULL,
        'created_at' => '2017-12-03 22:53:48',
        'updated_at' => '2017-12-03 23:24:42',
    ));

    \Corals\Modules\Slider\Models\Slide::updateOrCreate(['name' => 'Second Slider', 'slider_id' => $slider->id,], array(
        'content' => '/assets/themes/express/images/slides/slide_b.png',
        'status' => 'active',
        'deleted_at' => NULL,
        'created_at' => '2017-12-03 23:24:55',
        'updated_at' => '2017-12-03 23:24:55',
    ));
    \Corals\Modules\Slider\Models\Slide::updateOrCreate(['name' => 'Third Slider', 'slider_id' => $slider->id], array(
        'content' => '/assets/themes/express/images/slides/slide_c.png',
        'status' => 'active',
        'deleted_at' => NULL,
        'created_at' => '2017-12-03 23:24:55',
        'updated_at' => '2017-12-03 23:24:55',
    ));
}