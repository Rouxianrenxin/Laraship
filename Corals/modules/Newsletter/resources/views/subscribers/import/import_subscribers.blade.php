@extends('layouts.crud.create_edit')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('subscribers') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                {!! CoralsForm::openForm(null, ['url' => url('newsletter/import-subscribers'), 'method'=>'POST', 'files'=>true]) !!}

                {!! CoralsForm::file('subscribers_file', 'Newsletter::labels.subscriber.subscribers_file', true, [
                'help_text' => '
                Sample file format:<br/>
                <table class="details-table">
                <thead>
                <tr><th>Name</th><th>Email</th><th>Mail Lists</th></tr>
                </thead>
                <tbody>
                <tr><td>Subscriber Name</td><td>sample@example.com</td><td>Mail-List1,Mail-list2</td></tr>
                </tbody>
                </table>
                ']) !!}

                {!! CoralsForm::formButtons('Corals::labels.import') !!}

                {!! CoralsForm::closeForm() !!}
            @endcomponent
        </div>
    </div>

@endsection