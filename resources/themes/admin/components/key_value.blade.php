<style type="text/css">
    .select-section button {
        padding: 6px 12px !important;
    }

    .select-section .form-group {
        margin-bottom: 0;
    }
</style>

<div class="select-section {{ $class = str_random().'_setting' }}">
    <table id="values-table" width="100%" class="table table-striped table-responsive">
        <thead>
        <tr>
            <th width="50%">{{ trans($label['key']) }}</th>
            <th width="50%">{{ trans($label['value']) }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @php
            $key = $key??'key';
            $value = $value??'value';
        @endphp
        @foreach($options as $option_key => $option_value)
            <tr id="tr_{{ $loop->index }}" data-index="{{ $loop->index }}">
                <td>
                    <div class="form-group">
                        <input name="{{ $name."[$loop->index][{$key}]" }}" type="text"
                               value="{{ $option_key }}" class="form-control"/>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input name="{{ $name."[$loop->index][{$value}]" }}" type="text"
                               value="{{ $option_value }}" class="form-control"/>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-value" style="margin:0;"
                            data-index="{{ $loop->index }}"><i
                                class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <button type="button" class="btn btn-success btn-sm" id="add-value"><i
                class="fa fa-plus"></i>
    </button>
    <span class="help-block">
                           @lang('corals-admin::labels.component.add_new_pairs')
                        </span>
</div>

<script type="text/javascript">
    {{ $name}}_init = function () {
        if ($(".{{ $class }} #values-table").length > 0) {
            $(document).on('click', '.{{ $class }} #add-value', function () {
                var index = $('.{{ $class }} #values-table tr:last').data('index');
                if (isNaN(index)) {
                    index = 0;
                } else {
                    index++;
                }
                $('.{{ $class }} #values-table tr:last').after('<tr id="tr_' + index + '" data-index="' + index + '"><td><div class="form-group">' +
                    '<input name="{{ $name }}[' + index + '][{{ $key }}]" type="text"' +
                    'value="" class="form-control"/></div></td><td><div class="form-group">' +
                    '<input name="{{ $name }}[' + index + '][{{ $value }}]" type="text"' +
                    'value="" class="form-control"/></div></td>' +
                    '<td><div class="form-group"><button type="button" class="btn btn-danger btn-sm remove-value" style="margin:0;" data-index="' + index + '">'
                    + '<i class="fa fa-remove"></i></button></div></td>' +
                    '</tr>');
            });

            $(document).on('click', '.remove-value', function () {
                var index = $(this).data('index');
                $("#tr_" + index).remove();
            });
        }
    };

    window.initFunctions.push('{{ $name}}_init');
</script>
