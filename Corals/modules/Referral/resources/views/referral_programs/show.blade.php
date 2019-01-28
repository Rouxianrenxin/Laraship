@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('referral_program_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                <div class="well">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">{{$referral_program->title}}
                                <small class="pull-right"><i
                                            class="glyphicon glyphicon-calendar"></i> {{$referral_program->created_at->diffForHumans() }}
                                </small>
                            </h4>
                            <p>{!! $referral_program->description !!}</p>
                            @include('ReferralProgram::referral_programs.' . $referral_program->referral_action . '_action_template',['referral_program'=>$referral_program , 'edit_mode'=>'view', 'action_parameters',$action_parameters])
                        </div>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
@endsection

