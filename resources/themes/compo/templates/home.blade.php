@extends('layouts.master')

@section('editable_content')
    @php \Actions::do_action('pre_content',$item, $home??null) @endphp

    {!! $item->rendered !!}

    @include('partials.featured_categories')
    @include('partials.featured_products')
    @include('partials.three_column_lists')
    @include('partials.featured_brands')
    @include('partials.posts_grid')

    <section class="container mt-100 mb-80">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading text-center">People Show <span class="text-primary">Love</span></h2>
            </div>
            {!!   \Shortcode::compile( 'block','testimonial' ) ; !!}
        </div>
    </section>

@stop


@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection