<div class="row">
    <div class="col-md-12">
        @component('components.box')
            @slot('box_title')
                @if($root)
                    @lang('Menu::labels.root_menu_title',['title'=>$menu->name])
                @elseif($parent)
                    @lang('Menu::labels.parent_menu_title',['title'=> $parent->name])
                @else
                    @lang('Menu::labels.menu_item_title',['title'=>$menu->name])
                @endif
            @endslot

            @slot('box_actions')
                @if($menu->exists && $root)
                    {!! CoralsForm::link(url(config('menu.models.menu.resource_url') . '/create?parent=' . $menu->hashed_id),trans('Corals::labels.create'),
                    ['class'=>'btn btn-sm btn-success','data' => ['action' => 'load','load_to' => '#menu_form']]) !!}
                @endif
            @endslot

            {!! CoralsForm::openForm($menu,['url' => url(config('menu.models.menu.resource_url').'/'.$menu->hashed_id), 'data-page_action'=>'site_reload']) !!}
            {{ Form::hidden('parent_id', $menu->parent_id) }}
            {{ Form::hidden('root', $root) }}

            @if($root)
                {!! CoralsForm::text('key','Menu::attributes.menu.key',true) !!}
            @endif

            {!! CoralsForm::text('name','Menu::attributes.menu.name',true) !!}

            {!! CoralsForm::radio('status','Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}
            @if(!$root)
                {!! CoralsForm::text('url','Menu::attributes.menu.url') !!}

                {!! CoralsForm::text('active_menu_url','Menu::attributes.menu.active_menu_url',false,$menu->active_menu_url,['help_text'=> 'Menu::attributes.menu.active_menu_url_help']) !!}

                {!! CoralsForm::text('icon','Menu::attributes.menu.icon',false,str_replace('fa ','',$menu->icon),['class'=>'icp icp-auto',
                'help_text'=>'Menu::attributes.menu.icon_help']) !!}

                {!! CoralsForm::select('target', trans('Menu::attributes.menu.target'),trans('Menu::attributes.menu.target_options')) !!}

                {!! CoralsForm::select('roles[]',trans('Menu::attributes.menu.roles'), \Corals\User\Facades\Roles::getRolesList(),false,null,
                ['class'=>'','multiple'=>true,
                'help_text'=>'Menu::attributes.menu.roles_help'],'select2') !!}
            @endif
            {!! CoralsForm::textarea('description','Menu::attributes.menu.description',false,$menu->description,['rows'=>3]) !!}

            {!! CoralsForm::customFields($menu,'col-md-12') !!}

            {!! CoralsForm::formButtons(trans('Corals::labels.save', ['title'=> $title_singular]), [], ['href' => url('menus')])  !!}

            {!! CoralsForm::closeForm($menu) !!}
        @endcomponent
    </div>
</div>