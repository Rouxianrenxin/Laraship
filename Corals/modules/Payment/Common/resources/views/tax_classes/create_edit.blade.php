<div class="row">
    <div class="col-md-12">
        @component('components.box')
            {!! CoralsForm::openForm($tax_class) !!}
            <div class="row">
                <div class="col-md-12">
                    {!! CoralsForm::text('name','Payment::attributes.tax_class.name',true,$tax_class->name,
                    ['help_text'=>'']) !!}
                    {!! CoralsForm::formButtons(trans('Corals::labels.save',['title' => $title_singular]), [], ['show_cancel' => false])  !!}
                </div>
            </div>
            {!! CoralsForm::closeForm($tax_class) !!}
        @endcomponent
    </div>
</div>
