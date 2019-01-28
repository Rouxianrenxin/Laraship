@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('directory_listing_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-7">
            @component('components.box')
                {!! CoralsForm::openForm($listing) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','Directory::attributes.listing.name',true,$listing->name,[]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::text('caption','Directory::attributes.listing.caption',true,$listing->caption) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('slug','Directory::attributes.listing.slug',false, $listing->slug, ['help_text'=>'Directory::attributes.listing.slug_help']) !!}
                    </div>
                    <div class="col-md-6">
                        @can('admin', $listing)
                            {!! CoralsForm::select('user_id','Directory::attributes.listing.owner', [], false, null,
                                 ['class'=>'select2-ajax','data'=>[
                                 'model'=>\Corals\User\Models\User::class,
                                 'columns'=> json_encode(['name', 'email']),
                                 'selected'=>json_encode($listing->user_id ? [$listing->user_id] :[]),
                                 'where'=>json_encode([]),
                                 ]],'select2')
                            !!}
                            {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Directory::attributes.listing.status_options')) !!}

                            {!! CoralsForm::checkbox('is_featured', 'Directory::attributes.listing.is_featured', $listing->is_featured) !!}
                            {!! CoralsForm::checkbox('verified', 'Directory::attributes.listing.verified', $listing->verified) !!}
                        @endcan

                        {!! CoralsForm::select('location_id','Directory::attributes.listing.location', \Address::getLocationsList('Directory'), true, null, [], 'select2') !!}
                        {!! CoralsForm::select('categories[]','Directory::attributes.listing.categories', \Category::getCategoriesList('Directory'),true,null,['id'=>'categories', 'multiple'=>true], 'select2') !!}

                        <div id="attributes">
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        {!! CoralsForm::select('tags[]','Directory::attributes.listing.tags', \Tag::getTagsList('Directory'),false,null,['class'=>'tags', 'multiple'=>true], 'select2') !!}
                        {!! CoralsForm::text('website','Directory::attributes.listing.website',true) !!}
                        {!! CoralsForm::text('properties[social][facebook]','Directory::attributes.listing.facebook') !!}
                        {!! CoralsForm::text('properties[social][twitter]','Directory::attributes.listing.twitter') !!}

                    </div>
                    <div class="col-md-6">
                        @foreach(\Settings::get('contact_info',[]) as $key=>$value)
                            {!! CoralsForm::text('properties[contact_info]['.$key.']',$value) !!}
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('description','Directory::attributes.listing.description',false, $listing->description, ['class'=>'ckeditor','rows'=>5]) !!}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table color-table info-table table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th></th>
                            @foreach(\Settings::get('utility_days_of_the_week',[]) as $key=>$day)
                                <th>{{ $day }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="required-field"><label>@lang('Directory::labels.attribute.start')</label></td>
                            @foreach(\Settings::get('utility_days_of_the_week',[]) as $key=>$day)
                                <td>
                                    {!! CoralsForm::select("schedule[$key][start]", '', \Settings::get('utility_schedule_time',[]), false, $directory_schedules[$key]['start']) !!}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="required-field"><label>@lang('Directory::labels.attribute.end')</label></td>
                            @foreach(\Settings::get('utility_days_of_the_week',[]) as $key=>$day)
                                <td>
                                    {!! CoralsForm::select("schedule[$key][end]", '', \Settings::get('utility_schedule_time',[]), false, $directory_schedules[$key]['end']) !!}
                                </td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>

                {!! \Actions::do_action('directory_listing_form_post_fields', $listing) !!}

                {!! CoralsForm::customFields($listing) !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($listing) !!}
            @endcomponent
        </div>
        @if($listing->exists)
            <div class="col-md-5">
                @component('components.box')
                    @include('Utility::gallery.gallery',['galleryModel'=>$listing,'editable'=>true])
                @endcomponent
            </div>
        @endif
    </div>
@endsection

@section('js')
    @include('Utility::category.category_scripts', ['product'=>$listing,'category_field_id'=>'#categories','attributes_div'=>'#attributes'])
@endsection