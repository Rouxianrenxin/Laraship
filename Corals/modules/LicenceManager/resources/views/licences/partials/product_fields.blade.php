<div class="row">
    <div class="col-md-12">
        {!! CoralsForm::checkbox('properties[has_licence]', 'LicenceManager::attributes.product.has_licence', $product->properties['has_licence']??false, 'True') !!}
    </div>
</div>