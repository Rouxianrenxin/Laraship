<section class="container mt-100">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="heading text-center">@lang('corals-compo::labels.post.recent_post')</h2>
        </div>
        @foreach(\CMS::getLatestPosts(3) as $post)
            <div class="col-lg-4">
                <div class="card blog-card-grid">
                    <div class="blog-media">
                        <img class="card-img-top blog-media" src="{{ $post->featured_image }}" alt="">
                    </div>
                    <div class="posted-on">
                        <span class="date">{{$post->created_at->format('d')}}</span>
                        <span class="month">{{$post->created_at->format('M')}}</span>
                    </div>
                    <div class="card-body">
                        <p class="small text-muted">By {{ $post->author->name }}</p>
                        <a href=""><h4 class="card-title">{{ $post->title }}</h4></a>
                        <p class="card-text">
                            {{ str_limit(strip_tags($post->rendered ),80) }}
                        </p>
                        <a href="{{ url($post->slug) }}" class="btn btn-primary btn-sm">@lang('corals-compo::labels.blog.read_more')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
