@extends('layouts.master')

@section('editable_content')
    @php \Actions::do_action('pre_content',$item, $home??null) @endphp
    {!! $item->rendered !!}
    @include('partials.featured_categories')
    @include('partials.featured_products')
    @include('partials.three_column_lists')
    @include('partials.featured_brands')

    {!!   \Shortcode::compile( 'block','home-offers' ) ; !!}

    <section class="container padding-top-2x padding-bottom-2x">
        {!!   \Shortcode::compile( 'block','home-stores-features' ) ; !!}
        <div class="text-center">
            @php \Actions::do_action('pre_display_footer') @endphp
        </div>
    </section>
@stop
@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection