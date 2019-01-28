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
                @forelse($referral_programs as $referral_program)
                    <div class="panel panel-primary">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title pull-left" style="padding-top: 7.5px;">
                                {{$referral_program->title}}
                            </h4>
                            @php $referralLink = \Referral::getReferral( user(),$referral_program ) @endphp
                            @if(!$referralLink)
                                <div class="btn-group pull-right">
                                    <a href="{{url('referral/referral-programs/'.$referral_program->hashed_id.'/referral-links/create')}}"
                                       class="btn btn-default btn-sm">@lang('ReferralProgram::labels.get_my_link')</a>
                                </div>
                            @endif
                        </div>
                        <div class="panel-body clearfix">

                            <h4 class="media-heading">
                            </h4>
                            <p>{!!  $referral_program->description !!}</p>
                            @php $action_parameters = \Referral::prepareActionParameters($referral_program->referral_action); @endphp
                            @include('ReferralProgram::referral_programs.' . $referral_program->referral_action . '_action_template',['referral_program'=>$referral_program , 'edit_mode'=>'view', 'action_parameters',$action_parameters])
                            <div class="col-md-12">
                                <ul class="list-inline list-unstyled">
                                    <li>
                                        <span><i class="fa fa-calendar"></i> {{ $referral_program->created_at->diffForHumans() }} </span>
                                    </li>
                                    @if($referralLink)
                                        <li>|</li>
                                        <span><i class="fa fa-user"></i>
                                        {!! trans('ReferralProgram::labels.count_referral',['count' => $referralLink->relationships()->count()]) !!}
                                        </span>
                                        <li>|</li>
                                        <span><i class="fa fa-star"></i>
                                        {!! trans('ReferralProgram::labels.sum_point',['sum' => $referralLink->relationships()->sum('reward')]) !!}
                                        </span>
                                        <li>|</li>
                                        <span><i class="fa fa-link"></i>@lang('ReferralProgram::labels.your_referral_link') <b
                                                    class="text-info"
                                                    id="shortcode_{{$referralLink->id}}">{{$referralLink->getLinkAttribute()}}</b>
                            <a href="#" onclick="event.preventDefault();" class="copy-button"
                               data-clipboard-target="#shortcode_{{$referralLink->id}}"><i class="fa fa-clipboard"></i></a></span>
                                    @endif

                                </ul>
                            </div>
                        </div>

                    </div>

                @empty
                    <div class="alert alert-info">
                        <h5><i class="fa fa-info"></i>@lang('ReferralProgram::labels.there_no_active_referral')</h5>
                    </div>
                @endforelse
            @endcomponent
        </div>
    </div>
@endsection

