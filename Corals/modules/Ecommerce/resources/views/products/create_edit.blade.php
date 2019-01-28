@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_product_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-7">
            @component('components.box')
                {!! CoralsForm::openForm($product) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','Ecommerce::attributes.product.name',true,$product->name,[]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::text('caption','Ecommerce::attributes.product.caption',true,$product->caption,['help_text'=>'']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::text('slug','Ecommerce::attributes.product.slug',false, $product->slug,['help_text'=>'Ecommerce::attributes.product.slug_help']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::select('global_options[]','Ecommerce::attributes.product.global_options', \Ecommerce::getAttributesList(),false,null,['multiple'=>true], 'select2') !!}
                        {!! CoralsForm::select('type','Ecommerce::attributes.product.type',trans('Ecommerce::attributes.product.type_option') ,true, null,['class'=>'']) !!}
                        <div id="simple_product_attributes" class="hidden">
                            {!! CoralsForm::text('code','Ecommerce::attributes.product.sku_code',true,$product->exists? $sku->code:'' ,[] ) !!}
                            {!! CoralsForm::number('regular_price','Ecommerce::attributes.product.regular_price',true,$product->exists? $sku->regular_price:null,['step'=>0.01,'min'=>0,'max'=>999999,'left_addon'=>'<i class="'.$sku->currency_icon.'"></i>']) !!}
                            {!! CoralsForm::number('sale_price','Ecommerce::attributes.product.sale_price',false,$product->exists? $sku->sale_price:null,['step'=>0.01,'min'=>0,'max'=>999999,'left_addon'=>'<i class="'.$sku->currency_icon.'"></i>']) !!}
                            {!! CoralsForm::number('allowed_quantity','Ecommerce::attributes.product.allowed_quantity', false,$sku->exists?$sku->allowed_quantity:0,
                            ['step'=>1,'min'=>0,'max'=>999999, 'help_text'=>'Ecommerce::attributes.product.help']) !!}
                            {!! CoralsForm::select('inventory','Ecommerce::attributes.product.inventory',  get_array_key_translation(config('ecommerce.models.sku.inventory_options')),true,$sku->inventory) !!}
                            <div id="inventory_value_wrapper"></div>
                        </div>
                        <div id="variable_product_attributes" class="hidden">
                            {!! CoralsForm::select('variation_options[]','Ecommerce::attributes.product.variation_options', \Ecommerce::getAttributesList(),true,null,['multiple'=>true], 'select2') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::select('brand_id','Ecommerce::attributes.product.brand', \Ecommerce::getBrandsList(),false,null,[], 'select2') !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::checkbox('is_featured', 'Ecommerce::attributes.product.is_featured', $product->is_featured) !!}
                        {!! CoralsForm::select('categories[]','Ecommerce::attributes.product.categories', \Ecommerce::getCategoriesList(),true,null,['multiple'=>true], 'select2') !!}
                        {!! CoralsForm::select('tags[]','Ecommerce::attributes.product.tags', \Ecommerce::getTagsList(),false,null,['class'=>'tags','multiple'=>true], 'select2') !!}
                        {!! CoralsForm::select('tax_classes[]','Ecommerce::attributes.product.tax_classes', \Payments::getTaxClassesList(), false, null,['multiple'=>true], 'select2') !!}


                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('description','Ecommerce::attributes.product.description',false, $product->description, ['class'=>'ckeditor','rows'=>5]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::checkbox('shipping[enabled]', 'Ecommerce::attributes.product.shippable', $product->shipping['enabled']) !!}

                        <div class="row" id="shipping" style="{{ !$product->shipping['enabled']?'display:none':'' }}">
                            <div class="col-md-3">
                                {!! CoralsForm::number('shipping[width]','Ecommerce::attributes.product.width',false,null,['help_text'=>\Settings::get('ecommerce_shipping_dimensions_unit','in'),'min'=>0]) !!}
                            </div>
                            <div class="col-md-3">
                                {!! CoralsForm::number('shipping[height]','Ecommerce::attributes.product.height',false,null,['help_text'=>\Settings::get('ecommerce_shipping_dimensions_unit','in'),'min'=>0]) !!}
                            </div>
                            <div class="col-md-3">
                                {!! CoralsForm::number('shipping[length]','Ecommerce::attributes.product.length',false,null,['help_text'=>\Settings::get('ecommerce_shipping_dimensions_unit','in'),'min'=>0]) !!}
                            </div>
                            <div class="col-md-3">
                                {!! CoralsForm::number('shipping[weight]','Ecommerce::attributes.product.weight',false,null,['help_text'=>\Settings::get('ecommerce_shipping_weight_unit','oz'),'min'=>0]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::checkbox('external', 'Ecommerce::attributes.product.external', $product->external_url, 1,['onchange'=>"toggleExternalURL();",'help_text'=>'Ecommerce::attributes.product.help_external']) !!}
                        <div id="external_section" style="display: {{ $product->external_url ? "block":"none" }}">
                            {!! CoralsForm::text('external_url','Ecommerce::attributes.product.external_url',false,null) !!}

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::checkbox('downloads_enabled', 'Ecommerce::attributes.product.downloads_enabled', count($product->downloads), 1,['onchange'=>"toggleDownloadable();"]) !!}
                        @include('Ecommerce::products.partials.downloadable', ['model' => $product])
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::checkbox('private_content_pages', 'Ecommerce::attributes.product.private_content_page', count($product->posts), 1,['onchange'=>"togglePremuimContent();"]) !!}
                    </div>
                </div>
                <div class="row" id="product_pages" style="display: {{ count($product->posts) ? "block":"none" }}">
                    <div class="col-md-12">
                        {!! CoralsForm::select('posts[]','Ecommerce::attributes.product.posts', [], false, null,
                        ['class'=>'select2-ajax','multiple'=>"multiple",'data'=>[
                        'model'=>\Corals\Modules\CMS\Models\Content::class,
                        'columns'=> json_encode(['title']),
                        'selected'=>json_encode($product->posts()->pluck('posts.id')->toArray()),
                        'where'=>json_encode([['field'=>'private','operation'=>'=','value'=>1]]),
                        ]],'select2') !!}
                    </div>
                </div>

                {!! \Actions::do_action('ecommerce_product_form_post_fields', $product) !!}

                {!! CoralsForm::customFields($product) !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($product) !!}
            @endcomponent
        </div>
        @if($product->exists)
            <div class="col-md-5">
                @component('components.box')
                    @include('Ecommerce::products.gallery',['product'=>$product,'editable'=>true])
                @endcomponent
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script type="application/javascript">
        $(document).ready(function () {
            $('input[name="external"]').on('change', function () {
                if ($(this).prop('checked')) {
                    $('#external_link').fadeIn();
                } else {
                    $('#external_link').fadeOut();
                }
            });
            $('input[name="shipping[enabled]"]').on('change', function () {
                if ($(this).prop('checked')) {
                    $('#shipping').fadeIn();
                } else {
                    $('#shipping').fadeOut();
                }
            });
            $('select[name="type"]').on('change', function () {
                $product_type = $(this).val();
                if ($product_type === "simple") {
                    $('#simple_product_attributes').removeClass('hidden');
                    $('#variable_product_attributes').addClass('hidden');
                    setInventoryValue('{{ old('inventory', $sku->inventory) }}');
                } else if ($product_type === "variable") {
                    $('#simple_product_attributes').addClass('hidden');
                    $('#variable_product_attributes').removeClass('hidden');
                } else {
                    $('#simple_product_attributes').addClass('hidden');
                    $('#variable_product_attributes').addClass('hidden');
                }
            });

            $('select[name="type"]').trigger('change');
            $('#inventory').change(function (event) {
                var value = $(this).val();
                setInventoryValue(value);
            });


        });

        function togglePremuimContent() {
            var input = $('#private_content_pages');
            if (input.prop('checked')) {
                $('#product_pages').fadeIn();
            } else {
                $('#product_pages').fadeOut();
            }
        }

        function toggleExternalURL() {
            var input = $('#external');
            if (input.prop('checked')) {
                $('#external_section').fadeIn();
            } else {
                $('#external_section').fadeOut();
            }
        }

        function setInventoryValue(value) {
            var input = '';

            if (value === 'bucket') {
                input = '{{ CoralsForm::select('inventory_value','Inventory Value', get_array_key_translation(config('ecommerce.models.sku.bucket')),false,$sku->inventory_value?$sku->inventory_value:null )  }}';
            } else if (value === 'finite') {
                input = '{{ CoralsForm::number('inventory_value','Inventory Value',false,$sku->inventory_value?$sku->inventory_value:null,
                                    ['help_text'=>'',
                                    'step'=>1,'min'=>0,'max'=>999999])  }}';
            } else {
                input = '';
            }

            $("#inventory_value_wrapper").html(input);

            if (input !== '') {
                $("#inventory_value_wrapper").show();
            } else {
                $("#inventory_value_wrapper").hide();
            }
        }

    </script>
@endsection