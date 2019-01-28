<div class="column">
    <h1>{{ $page_title }}</h1>
</div>
<div class="column">
    {!! str_replace('breadcrumb','breadcrumbs',str_replace('breadcrumb-item', '', $breadcrumb))  !!}
</div>
