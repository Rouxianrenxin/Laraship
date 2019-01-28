<!-- Trending Categories Section Start -->
<section class="categories-icon section-padding bg-drack">
    <div class="container">
        <h1 class="section-title">
            @lang('corals-classified-master::labels.partial.popular_categories')
        </h1>
        <div class="d-flex justify-content-center align-content-around flex-wrap">
            @foreach(\Category::getCategoriesList('Classified', false, true, 'active',[],true) as $category)
                <div>
                    <a href="{{url('products?category='.$category->slug)}}">
                        <div class="icon-box">
                            <div class="icon">
                                <img src="{{ $category->thumbnail }}" alt="Category" class="mx-auto"
                                     style="max-height: 100px;width: auto;">
                            </div>
                            <h4>{{$category->name}}</h4>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>