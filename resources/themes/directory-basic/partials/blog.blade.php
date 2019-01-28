<section>
    <div class="container">
        <div class="section-title">
            <h2>@lang('corals-directory-basic::labels.template.home.tips_articles')</h2>
            <div class="section-subtitle">@lang('corals-directory-basic::labels.template.home.from_the_blog')</div>
            <span class="section-separator"></span>
            <p>@lang('corals-directory-basic::labels.template.home.browse_the_latest_articles_from_our_blog')</p>
        </div>
        <div class="row home-posts">
            @foreach(\Corals\Modules\CMS\Facades\CMS::getLatestPosts(3,'active') as $post)
                <div class="col-md-4">
                    <article class="card-post">
                        <div class="card-post-img fl-wrap">
                            <a href="{{url($post->slug)}}"><img src="{{$post->featured_image}}" alt=""></a>
                        </div>
                        <div class="card-post-content fl-wrap">
                            <h3><a href="{{url($post->slug)}}">{{$post->title}}</a></h3>
                            <p>{{$post->meta_description }} </p>
                            <div class="post-author"><a href="#"><img src="{{$post->author->picture_thumb}}"
                                                                      alt=""><span>@lang('corals-directory-basic::labels.template.home.by') , {{$post->author->name}}</span></a>
                            </div>
                            <div class="post-opt">
                                <ul>
                                    <li><i class="fa fa-calendar-check-o"></i> <span>{{$post->created_at}}</span></li>
                                    @foreach($post->categories as $category)
                                        <li><i class="fa fa-tags"></i> <a href="#">{{$category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <a href="{{url('blog')}}"
           class="btn  big-btn circle-btn  dec-btn color-bg flat-btn">@lang('corals-directory-basic::labels.template.home.read_all')
            <i
                    class="fa fa-eye"></i></a>
    </div>
</section>