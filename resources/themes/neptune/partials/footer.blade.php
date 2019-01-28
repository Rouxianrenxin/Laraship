<!-- ******FOOTER****** -->
<footer class="footer">
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <div class="footer-col col-lg-3 col-md-4 col-12 links-col">
                    <div class="footer-col-inner">
                        <h3 class="sub-title">@lang('corals-neptune::labels.partial.quick_link')</h3>
                        <ul class="list-unstyled">
                            @foreach(Menus::getMenu('frontend_footer','active') as $menu)
                                <li>
                                    <a href="{{ url($menu->url) }}">
                                        @if($menu->icon)<i class="{{ $menu->icon }} fa-fw"></i>@endif {{ $menu->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div><!--//footer-col-inner-->
                </div><!--//foooter-col-->
                <div class="footer-col col-lg-6 col-md-8 col-12 blog-col">
                    <div class="footer-col-inner">
                        <h3 class="sub-title">@lang('corals-neptune::labels.partial.latest_Blog')</h3>
                        @foreach(\CMS::getLatestPosts() as $post)
                            <div class="item">
                                <figure class="figure">
                                    <img class="img-fluid" src="{{ $post->featured_image }}" width="60"
                                         alt="{{ $post->title }}"/>
                                </figure>
                                <div class="content">
                                    <h4 class="post-title"><a href="{{ url($post->slug) }}">{{ $post->title }}</a></h4>
                                    <p class="intro">
                                        {{ str_limit(strip_tags($post->rendered )) }}
                                    </p>
                                    <ul class="meta list-inline">
                                        <li>{{ format_date($post->published_at) }}</li>
                                        <li>{{ $post->author->name }}</li>
                                    </ul>
                                </div><!--//content-->
                            </div>
                        @endforeach
                    </div><!--//footer-col-inner-->
                </div><!--//foooter-col-->
                <div class="footer-col col-lg-3 col-12 contact-col">
                    <div class="footer-col-inner">
                        <h3 class="sub-title">@lang('corals-neptune::labels.partial.get_touch')</h3>
                        <p class="intro"></p>
                        <div class="row">
                            <p class="email col-lg-12 col-md-4 col-12">
                                <span class="fs1" aria-hidden="true" data-icon="&#xe010;"></span>
                                <a href="#">{{ \Settings::get('contact_form_email') }}</a>
                            </p>
                        </div>
                    </div><!--//footer-col-inner-->
                </div><!--//foooter-col-->
            </div>
        </div>
    </div><!--//footer-content-->
    <div class="bottom-bar">
        <div class="container center">
            <ul class="social-icons list-inline">
                @foreach(\Settings::get('social_links',[]) as $key=>$link)
                    <li class="list-inline-item">
                        <a href="{{ $link }}" target="_blank"><i class="fa fa-fw fa-{{ $key }}"></i></a>
                    </li>
                @endforeach
            </ul>
            <small class="copyright text-center">{!! \Settings::get('footer_text') !!}</small>
        </div><!--//container-->
    </div><!--//bottom-bar-->
</footer><!--//footer-->