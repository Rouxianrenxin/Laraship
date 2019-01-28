<section class="container py-4">


    <div class="row align-items-center">
        <div class="col-md-3 text-center">
            <div class="mt-2">
                <img class="img-fluid img-circle mb-2" style="width: 200px"
                     src="{{ asset($productUser->picture) }}" alt="{{ $productUser->full_name }}">

                @if(\Settings::get('classified_rating_enable',true))
                    @include('partials.components.rating',['rating'=> $productUser->averageRating(1)[0],'rating_count'=>$productUser->countRating()[0] ])
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="mt-2">
                <h4>{!! $productUser->full_name !!}</h4>
                @if(!empty($productUser->getProperty('about')))
                    {{ $productUser->getProperty('about') }}
                @else
                    <p>@lang('corals-classified-master::labels.template.product.user_details_unavailable')</p>
                @endif
            </div>
            <div class="mt-3">
                <a href="mailto:{{ $productUser->email }}" class="btn btn-common btn-reply">
                    <i class="lni-envelope"></i></a>
                @if(!empty($productUser->phone))
                    <a href="#" class="btn btn-common call ml-1">
                        <i class="lni-phone-handset"></i>
                        <span class="phonenumber">{{$productUser->phone}}</span></a>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            @include('partials.user_reviews',['productUser'=> $productUser])
        </div>
    </div>


</section>


