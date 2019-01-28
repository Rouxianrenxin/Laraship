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
            <!-- ******Why Section****** -->
<section id="who" class="who section">
    <div class="container text-center">
        <h2 class="title text-center">Who we are</h2>
        <p class="intro text-center">We are a small team of web developers and designers based in Laravel. We are
            specialised in JavaScript, AngularJS and Python. Lorem ipsum dolor sit amet, consectetuer adipiscing
            elit.</p>
        <div class="row benefits text-center">
            <div class="item col-lg-3 col-md-6 col-12">
                <div class="item-inner">
                    <div class="fs1" aria-hidden="true" data-icon="&#xe007;"></div>
                    <h3 class="sub-title">Skilled team</h3>
                    <div class="desc">
                        <p>Tell your potential client why they should choose your service and how you are different from
                            your competitors.</p>
                    </div>
                </div>
            </div><!--//item-->
            <div class="item col-lg-3 col-md-6 col-12">
                <div class="item-inner">
                    <div class="fs1" aria-hidden="true" data-icon="&#xe01c;"></div>
                    <h3 class="sub-title">Agile approach</h3>
                    <div class="desc">
                        <p>Tell your potential client why they should choose your service and how you are different from
                            your competitors.</p>
                    </div>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-lg-3 col-md-6 col-12">
                <div class="item-inner">
                    <div class="fs1" aria-hidden="true" data-icon="&#xe031;"></div>
                    <h3 class="sub-title">High quality code</h3>
                    <div class="desc">
                        <p>Tell your potential client why they should choose your service and how you are different from
                            your competitors.</p>
                    </div>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-lg-3 col-md-6 col-12">
                <div class="item-inner">
                    <div class="fs1" aria-hidden="true" data-icon="&#xe100;"></div>
                    <h3 class="sub-title">No overheads</h3>
                    <div class="desc">
                        <p>Tell your potential client why they should choose your service and how you are different from
                            your competitors.</p>
                    </div>
                </div><!--//item-inner-->
            </div><!--//item-->
        </div><!--//row-->
        <a class="btn btn-cta btn-cta-secondary" href="/register">Try Laraship now</a>
    </div><!--//container-->
</section><!--//who-->

<!-- ******Testimonials Section****** -->
<section id="testimonials" class="testimonials section">
    <div class="container">
        <h2 class="title text-center">Testimonials</h2>
        <p class="intro text-center">Don’t just take our word for it – see what our clients are saying</p>
        <div class="row">
            <div class="item col-lg-6 col-12">
                <div class="item-inner">
                    <div class="quote-container">
                        <i class="fa fa-quote-left"></i>
                        <blockquote class="quote">We had great experience working with Phasellus ut cursus tellus. Etiam
                            ullamcorper varius diam, nec consequat dolor gravida non. Nullam commodo feugiat arcu, ut
                            scelerisque nisl vulputate eget. Cras a euismod elit.

                        </blockquote><!--//quote-->
                    </div><!--//quote-->
                    <div class="meta">
                        <div class="profile">
                            <img class="img-circle" src="/assets/themes/neptune/images/client/client-profile-1.png" alt=""/>
                            <p class="name">Katherine Hamilton<br/>
                                <span class="source-title">Product Manager</span>
                            </p>
                        </div><!--//profile-->
                        <div class="client-logo">
                            <img class="img-fluid" src="/assets/themes/neptune/images/client/client-logo-1.png" alt=""/>
                        </div><!--//client-logo-->
                    </div><!--//meta-->
                </div><!--//item-inner-->
            </div><!--//item-->

            <div class="item col-lg-6 col-12">
                <div class="item-inner">
                    <div class="quote-container">
                        <i class="fa fa-quote-left"></i>
                        <blockquote class="quote">Cras condimentum erat vel quam dignissim, eu venenatis velit porta.
                            Praesent fermentum, mi sit amet mollis fringilla, ex risus condimentum mauris, at dapibus
                            ipsum turpis non ipsum.
                        </blockquote><!--//quote-->
                    </div><!--//quote-->
                    <div class="meta">
                        <div class="profile">
                            <img class="img-circle" src="/assets/themes/neptune/images/client/client-profile-2.png" alt=""/>
                            <p class="name">Aaron Brown<br/>
                                <span class="source-title">Marketing Director</span>
                            </p>
                        </div><!--//profile-->
                        <div class="client-logo">
                            <img class="img-fluid" src="/assets/themes/neptune/images/client/client-logo-2.png" alt=""/>
                        </div><!--//client-logo-->
                    </div><!--//meta-->
                </div><!--//item-inner-->
            </div><!--//item-->

            <div class="clearfix"></div>

            <div class="item col-lg-6 col-12">
                <div class="item-inner">
                    <div class="quote-container">
                        <i class="fa fa-quote-left"></i>
                        <blockquote class="quote">Pellentesque nec maximus justo, a ultrices ligula. Duis sollicitudin
                            suscipit arcu eget interdum. Nullam et porttitor sem, id iaculis eros. Sed feugiat leo et
                            ligula pulvinar, et lobortis velit pretium.
                        </blockquote><!--//quote-->
                    </div><!--//quote-->
                    <div class="meta">
                        <div class="profile">
                            <img class="img-circle" src="/assets/themes/neptune/images/client/client-profile-3.png" alt=""/>
                            <p class="name">Phillip Perry<br/>
                                <span class="source-title">Product Manager</span>
                            </p>
                        </div><!--//profile-->
                        <div class="client-logo">
                            <img class="img-fluid" src="/assets/themes/neptune/images/client/client-logo-3.png" alt=""/>
                        </div><!--//client-logo-->
                    </div><!--//meta-->
                </div><!--//item-inner-->
            </div><!--//item-->

            <div class="item col-lg-6 col-12">
                <div class="item-inner">
                    <div class="quote-container">
                        <i class="fa fa-quote-left"></i>
                        <blockquote class="quote">We are impressed by lorem ipsum dolor sit amet, consectetur adipiscing
                            elit. Maecenas tellus nisi, maximus vel risus vel, fermentum faucibus magna. Aliquam sed
                            aliquet eros. Nunc nec aliquet ligula.
                        </blockquote><!--//quote-->
                    </div><!--//quote-->
                    <div class="meta">
                        <div class="profile">
                            <img class="img-circle" src="/assets/themes/neptune/images/client/client-profile-4.png" alt=""/>
                            <p class="name">Victoria Simmons<br/>
                                <span class="source-title">Product Designer</span>
                            </p>
                        </div><!--//profile-->
                        <div class="client-logo">
                            <img class="img-fluid" src="/assets/themes/neptune/images/client/client-logo-4.png" alt=""/>
                        </div><!--//client-logo-->
                    </div><!--//meta-->
                </div><!--//item-inner-->
            </div><!--//item-->
        </div><!--//row-->
    </div><!--//container-->
</section><!--//testimonials-->

<!-- ******Logos Section****** -->
<section id="logos" class="logos section">
    <div class="container text-center">
        <h2 class="title">Who we have worked with</h2>
        <p class="intro">SaaS / Mobile apps / Marketing sites / Internal apps</p>
        <ul class="logo-list list-inline row">
            <li class="col-md-3 col-6"><a href="#"><img class="img-fluid" src="/assets/themes/neptune/images/logos/logo-1.png" alt=""/></a>
            </li>
            <li class="col-md-3 col-6"><a href="#"><img class="img-fluid" src="/assets/themes/neptune/images/logos/logo-2.png" alt=""/></a>
            </li>
            <li class="col-md-3 col-6"><a href="#"><img class="img-fluid" src="/assets/themes/neptune/images/logos/logo-3.png" alt=""/></a>
            </li>
            <li class="col-md-3 col-6"><a href="#"><img class="img-fluid" src="/assets/themes/neptune/images/logos/logo-4.png" alt=""/></a>
            </li>
        </ul><!--//logo-list-->
        <ul class="logo-list list-inline row last">
            <li class="col-md-3 col-6"><a href="#"><img class="img-fluid" src="/assets/themes/neptune/images/logos/logo-5.png" alt=""/></a>
            </li>
            <li class="col-md-3 col-6"><a href="#"><img class="img-fluid" src="/assets/themes/neptune/images/logos/logo-6.png" alt=""/></a>
            </li>
            <li class="col-md-3 col-6"><a href="#"><img class="img-fluid" src="/assets/themes/neptune/images/logos/logo-7.png" alt=""/></a>
            </li>
            <li class="col-md-3 col-6"><a href="#"><img class="img-fluid" src="/assets/themes/neptune/images/logos/logo-8.png" alt=""/></a>
            </li>
        </ul><!--//logos-list-->
    </div><!--//container-->
</section><!--//logos-->

<!-- ******CTA Section****** -->
<section id="cta-section" class="cta-section section text-center home-cta-section">
    <div class="container">
        <h2 class="title">Want to have a quick chat?</h2>
        <p class="email contact-info">
            <span class="intro">You can also email us</span>
            <span class="info"><a href="mailto: support@corals.io">support@corals.io</a></span>
        </p><!--//phone-->
    </div><!--//container-->
</section><!--//cta-section-->
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
            <!-- ******team Section****** -->
<section id="team" class="team section">
    <div class="container">
        <h2 class="title text-center">Meet the team</h2>
        <p class="intro text-center">In vehicula accumsan vestibulum. Sed convallis massa ac nisi sodales, ac commodo
            nibh eleifend. Vivamus at vestibulum quam. Vivamus feugiat elit et elit viverra, et euismod lorem tincidunt.
            Suspendisse pharetra feugiat magna.</p>
        <div class="row">
            <div class="item col-md-6 col-12">
                <div class="item-inner">
                    <div class="row">
                        <figure class="figure col-md-5 col-12">
                            <img class="img-fluid" src="/assets/themes/neptune/images/team/member-1.jpg" alt=""/>
                        </figure>
                        <div class="info col-md-7 col-12">
                            <h3 class="name">James Lee</h3>
                            <h4 class="role">Lead Developer</h4>
                            <p>Sed vel ultricies quam. Ut lacus odio, cursus in quam sit amet, gravida dapibus ante.
                                Vestibulum viverra imperdiet diam vel condimentum. Nunc sit amet orci quis mauris mollis
                                sodales. Sed sed massa non elit interdum porttitor.</p>
                        </div><!--//info-->
                    </div><!--//row-->
                    <div class="social text-center">
                        <ul class="social-list list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-github-alt"></i></a></li>
                        </ul>
                    </div><!--//social-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-md-6 col-12">
                <div class="item-inner">
                    <div class="row">
                        <figure class="figure col-md-5 col-12">
                            <img class="img-fluid" src="/assets/themes/neptune/images/team/member-2.jpg" alt=""/>
                        </figure>
                        <div class="info col-md-7 col-12">
                            <h3 class="name">Jason Powell</h3>
                            <h4 class="role">Lead Developer</h4>
                            <p>Integer pretium auctor molestie. Nullam augue risus, suscipit a dictum ut, tincidunt id
                                dolor. Nullam pulvinar metus a ante vestibulum bibendum.</p>
                        </div><!--//info-->
                    </div><!--//row-->
                    <div class="social text-center">
                        <ul class="social-list list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-github-alt"></i></a></li>
                        </ul>
                    </div><!--//social-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-md-6 col-12">
                <div class="item-inner">
                    <div class="row">
                        <figure class="figure col-md-5 col-12">
                            <img class="img-fluid" src="/assets/themes/neptune/images/team/member-3.jpg" alt=""/>
                        </figure>
                        <div class="info col-md-7 col-12">
                            <h3 class="name">Sara Valdez</h3>
                            <h4 class="role">UX/UI Designer</h4>
                            <p>Vivamus a lectus in neque sagittis finibus. Ut consectetur ex eget eleifend pellentesque.
                                Sed congue ligula eu diam lobortis tristique. Aenean ullamcorper dui quis ante
                                posuere</p>
                        </div><!--//info-->
                    </div><!--//row-->
                    <div class="social text-center">
                        <ul class="social-list list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        </ul>
                    </div><!--//social-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-md-6 col-12">
                <div class="item-inner">
                    <div class="row">
                        <figure class="figure col-md-5 col-12">
                            <img class="img-fluid" src="/assets/themes/neptune/images/team/member-4.jpg" alt=""/>
                        </figure>
                        <div class="info col-md-7 col-12">
                            <h3 class="name">Larry Fox</h3>
                            <h4 class="role">Full Stack Developer</h4>
                            <p>Pellentesque pharetra, ipsum a luctus condimentum, nulla urna sollicitudin augue, id
                                pulvinar quam diam eget nisi. Vestibulum et tortor in turpis mattis hendrerit at vel
                                ligula. Phasellus mi erat.</p>
                        </div><!--//info-->
                    </div><!--//row-->
                    <div class="social text-center">
                        <ul class="social-list list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-github-alt"></i></a></li>
                        </ul>
                    </div><!--//social-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-md-6 col-12">
                <div class="item-inner">
                    <div class="row">
                        <figure class="figure col-md-5 col-12">
                            <img class="img-fluid" src="/assets/themes/neptune/images/team/member-6.jpg" alt=""/>
                        </figure>
                        <div class="info col-md-7 col-12">
                            <h3 class="name">Vincent Fowler</h3>
                            <h4 class="role">Front-end Developer</h4>
                            <p>Mauris at erat volutpat, consectetur tortor nec, dapibus purus. Cras semper, neque varius
                                maximus egestas, quam neque interdum sem, non placerat felis nunc et nulla.</p>
                        </div><!--//info-->
                    </div><!--//row-->
                    <div class="social text-center">
                        <ul class="social-list list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-github-alt"></i></a></li>
                        </ul>
                    </div><!--//social-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-md-6 col-12">
                <div class="item-inner">
                    <div class="row">
                        <figure class="figure col-md-5 col-12">
                            <img class="img-fluid" src="/assets/themes/neptune/images/team/member-5.jpg" alt=""/>
                        </figure>
                        <div class="info col-md-7 col-12">
                            <h3 class="name">Kathy Morgan</h3>
                            <h4 class="role">Interaction Designer</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tempor ante at massa
                                iaculis volutpat. In hac habitasse platea dictumst. Nunc pharetra neque libero.</p>
                        </div><!--//info-->
                    </div><!--//row-->
                    <div class="social text-center">
                        <div class="social-inner">
                            <ul class="social-list list-inline">
                                <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div><!--//social-inner-->
                    </div><!--//social-->
                </div><!--//item-inner-->
            </div><!--//item-->
        </div><!--//row-->
    </div><!--//container-->
</section><!--//team-section-->

<!-- ******Job Section****** -->
<section class="join-us section">
    <div class="container">
        <h2 class="title text-center">Join Our Team</h2>
        <p class="intro text-center">We love what we do vestibulum tincidunt tincidunt nisl et consectetur mauris sed
            dui non sapien rhoncus volutpat pellentesque</p>
        <div class="row">
            <div class="info col-lg-7 col-md-6 col-12">
                <p>You can use this section to advertise jobs or attract freelancers to join your team... Fringilla
                    potenti morbi sociosqu dignissim sociis ridiculus. Magna parturient. Auctor convallis. Elementum
                    adipiscing est. Rutrum. Viverra hac congue aliquam accumsan nam laoreet ut nascetur eu vulputate
                    diam. Lacinia placerat ad lectus. Phasellus sit enim, metus quam hymenaeos fringilla venenatis
                    natoque.</p>
                <p>Sollicitudin hendrerit facilisis. Pretium quisque blandit justo massa condimentum varius lobortis,
                    hymenaeos nec phasellus lectus Convallis convallis magnis pellentesque blandit Molestie sociosqu
                    pede.</p>

                <p>If you are an iOS/Android developer interested in joining our team, please email your CV to <a
                        href="#">jobs@devstudio.com</a></p>
            </div>
            <div class="partner col-lg-4 col-md-5 col-12 ml-lg-auto mr-lg-auto">
                <h5 class="sub-title">Want to partner with us?</h5>
                <p>If you are a development focused team you might want to attract design partners here...Vulputate sed
                    Nostra elit consequat penatibus. Hac habitant inceptos scelerisque tempor dis purus orci. Risus
                    porta. Arcu gravida, cubilia taciti, ultricies Nisi posuere magna penatibus non suspendisse in mus
                    hendrerit.</p>
                <a href="https://codecanyon.net/item/laraship-pro-laravel-powerful-admin-user-cms-rules-memberships-settings-subscriptions/15650201" class="btn btn-cta btn-cta-primary">
                Give us a chance!
                </a>
            </div><!--//partner-->
        </div><!--//row-->
    </div><!--//row-->
</section><!--//job-->

<!-- ******CTA Section****** -->
<section id="cta-section" class="cta-section section text-center home-cta-section">
    <div class="container">
        <h2 class="title">Want to have a quick chat?</h2>
        <p class="email contact-info">
            <span class="intro">You can also email us</span>
            <span class="info"><a href="mailto:support@corals.io">support@corals.io</a></span>
        </p><!--//phone-->
    </div><!--//container-->
</section><!--//cta-section-->',
            'featured_image_link' => '/assets/themes/neptune/images/background/heading-background-2.jpg',
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
            'content' => '',
            'featured_image_link' => '/assets/themes/neptune/images/background/heading-background-3.jpg',
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
            'content' => '',
            'featured_image_link' => '/assets/themes/neptune/images/background/promo-background-1.jpg',
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
            'content' => '',
            'featured_image_link' => '/assets/themes/neptune/images/background/heading-background-4.jpg',
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
            'content' => '<!-- ******Work list Section****** -->
<section id="work-list" class="section work-list">
    <div class="container text-center">
        <h2 class="title">Case Studies</h2>
        <div id="filters" class="button-group clearfix">
            <button class="btn button is-checked" data-filter="*">All</button>
            <button class="btn button" data-filter=".saas">SaaS</button>
            <button class="btn button" data-filter=".mobile-app">Mobile app</button>
            <button class="btn button" data-filter=".website">Website</button>
            <button class="btn button" data-filter=".startup">Startup</button>
            <button class="btn button last" data-filter=".agency">Agency</button>
        </div><!--//filters-->
        <div class="items-wrapper isotope row">
            <div class="item startup saas col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-1.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Velocity web application</a></h3>
                        <div class="meta">Startup / SaaS</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup mobile-app col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-2.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Delta app development</a></h3>
                        <div class="meta">Startup / Mobile app</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup website col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-3.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Tempo</a></h3>
                        <div class="meta">Startup / Website</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item agency website col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-4.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Duis egestas</a></h3>
                        <div class="meta">Agency / Website</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item agency website col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-5.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Quisque vel nulla</a></h3>
                        <div class="meta">Agency / Website</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup mobile-app col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-6.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Fusce felis elit</a></h3>
                        <div class="meta">Startup / Mobile app</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup saas col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-7.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Quisque rutrum</a></h3>
                        <div class="meta">Startup / SaaS</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup mobile-app website col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-8.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Quisque rutrum</a></h3>
                        <div class="meta">Startup / Mobile app / Website</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup mobile-app saas col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-9.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Nullam Quis</a></h3>
                        <div class="meta">Startup / Mobile app / SaaS</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup saas col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-10.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Nullam Quis</a></h3>
                        <div class="meta">Startup / SaaS</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup website mobile-app col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-11.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Nullam Quis</a></h3>
                        <div class="meta">Startup / Website / Mobile app</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item startup saas website col-lg-4 col-md-6 col-12">
                <div class="item-inner">
                    <figure class="figure">
                        <a href="#"><img class="img-fluid"
                                         src="/assets/themes/neptune/images/work/work-example-thumb-12.jpg" alt=""/></a>
                        <a class="info-mask" href="#">
                            <span class="desc">Project intro goes here lorem ipsum dolor sit amet, consectetuer adipiscing elit...</span>
                            <span class="btn btn-cta btn-cta-primary">View case study</span>
                        </a><!--//info-mask-->
                    </figure>
                    <div class="content text-left">
                        <h3 class="sub-title"><a href="#">Nullam Quis</a></h3>
                        <div class="meta">Startup / Website / SaaS</div>
                    </div><!--//content-->
                </div><!--//item-inner-->
            </div><!--//item-->
        </div><!--//items-wrapper-->
    </div><!--//container-fluid-->
</section><!--//work-list"-->

<!-- ******Services Section****** -->
<section id="services" class="services section">
    <div class="container text-center">
        <h2 class="title">Services</h2>
        <p class="intro">We offer lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
            laboris nisi ut aliquip ex ea commodo consequat</p>
        <div class="service-items row">
            <div class="item col-xl-3 col-md-6 col-12">
                <div class="item-inner">
                    <div class="header-box">
                        <span class="fs1" aria-hidden="true" data-icon="&#xe104;"></span>
                    </div><!--//header-->
                    <div class="desc">
                        <h3 class="sub-title">UX &amp; Front-end</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae diam magna. Curabitur
                            nibh metus, ultricies sed aliquam euismod, scelerisque eu purus. In hac habitasse platea
                            dictumst. Suspendisse tempus elit eget libero suscipit pulvinar.</p>
                    </div>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-xl-3 col-md-6 col-12">
                <div class="item-inner">
                    <div class="header-box">
                        <span class="fs1" aria-hidden="true" data-icon="&#xe0ea;"></span>
                    </div><!--//header-->
                    <div class="desc">
                        <h3 class="sub-title">Back-end &amp; Database</h3>
                        <p>Phasellus fermentum accumsan fermentum. Vestibulum elit sapien, consequat vitae auctor sit
                            amet, elementum sed elit. Quisque ullamcorper quis augue sit amet porttitor. Maecenas ac
                            dolor iaculis, dapibus.</p>
                    </div>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-xl-3 col-md-6 col-12">
                <div class="item-inner">
                    <div class="header-box">
                        <span class="fs1" aria-hidden="true" data-icon="&#xe003;"></span>
                    </div><!--//header-->
                    <div class="desc">
                        <h3 class="sub-title">Hosting</h3>
                        <p>Cras mollis ex sed tortor finibus, a mattis risus rhoncus. Sed sodales et metus at sodales.
                            Ut non dolor sollicitudin, venenatis mauris eget, fringilla enim. Pellentesque sed magna
                            ante. Cras mollis tincidunt lectus vitae suscipit.</p>
                    </div>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-xl-3 col-md-6 col-12">
                <div class="item-inner">
                    <div class="header-box">
                        <span class="fs1" aria-hidden="true" data-icon="&#xe028;"></span>
                    </div><!--//header-->
                    <div class="desc">
                        <h3 class="sub-title">Support</h3>
                        <p>Aliquam efficitur, lorem blandit dapibus viverra, erat turpis placerat lacus, quis hendrerit
                            libero sem eget dui. Integer eu diam orci. Nullam sed dictum lorem. Quisque ut lacus non
                            enim aliquam pretium sit amet id augue.</p>
                    </div>
                </div><!--//item-inner-->
            </div><!--//item-->
        </div><!--//row-->
        <a class="btn btn-cta btn-cta-primary" href="https://codecanyon.net/item/laraship-pro-laravel-powerful-admin-user-cms-rules-memberships-settings-subscriptions/15650201">Give us a chance</a>
    </div><!--//container-->
</section>

<!-- ******CTA Section****** -->
<section id="cta-section" class="cta-section section text-center home-cta-section">
    <div class="container">
        <h2 class="title">Want to have a quick chat?</h2>
        <p class="email contact-info">
            <span class="intro">You can also email us</span>
            <span class="info"><a href="mailto:support@corals.io">support@corals.io</a></span>
        </p><!--//phone-->
    </div><!--//container-->
</section><!--//cta-section-->',
            'featured_image_link' => '/assets/themes/neptune/images/background/heading-background-1.jpg',
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
