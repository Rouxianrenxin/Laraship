@if(!empty($actions))
    <div class="nav-holder actions">
        <nav>
            <div class="btn-group">
                <ul>
                    <li>
                        <a href="#"
                           class=" pull-right btn btn-sm flat-btn"
                           >
                            <i class="fa fa-caret-down "></i> @lang('corals-directory-basic::labels.actions')
                        </a>
                        <ul>
                            @foreach($actions as $action)
                                <li>
                                    @php
                                        $dataAttribute = [];
                                            foreach($action['data'] as $key=>$data){
                                            $dataAttribute['data-'.$key]=$data;
                                            }
                                    @endphp
                                    <a target="{{ $action['target']??'_self' }}" href="{{ $action['href'] }}"
                                       class="{{ $action['class'] ?? '' }}" {!! \Html::attributes($dataAttribute) !!} >
                                        <i class="{{ $action['icon']?? '' }}"></i> {!! $action['label'] !!}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
@endif