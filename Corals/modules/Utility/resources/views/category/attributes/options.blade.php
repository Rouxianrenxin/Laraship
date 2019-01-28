<style type="text/css">
    .select-section button {
        padding: 6px 12px !important;
    }

    .select-section .form-group {
        margin-bottom: 0;
    }
</style>

<div class="select-section {{ $class = str_random().'_setting' }}">
    <div class="table-responsive">
        <table id="values-table" width="100%"
               class="table color-table info-table table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th width="10%">@lang('Utility::labels.attribute.order')</th>
                <th width="40%">@lang('Utility::labels.attribute.value')</th>
                <th width="50%">@lang('Utility::labels.attribute.display')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($options as $option)
                <tr id="tr_{{ $loop->index }}" data-index="{{ $loop->index }}">
                    <input name="{{ $name."[$loop->index][id]" }}" type="hidden"
                           value="{{ $option->id }}" class="form-control"/>
                    <td>
                        <div class="form-group">
                            <input name="{{ $name."[$loop->index][option_order]" }}" type="text"
                                   value="{{ $option->option_order }}" class="form-control"/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input name="{{ $name."[$loop->index][option_value]" }}" type="text"
                                   value="{{ $option->option_value }}" class="form-control"/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input name="{{ $name."[$loop->index][option_display]" }}" type="text"
                                   value="{{  $option->option_display }}" class="form-control"/>
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
    </div>
    <button type="button" class="btn btn-success btn-sm" id="add-value"><i
                class="fa fa-plus"></i>
    </button>
    <span class="help-block">
                            @lang('Utility::labels.attribute.add_new_option')
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
                    '<input name="{{ $name }}[' + index + '][option_order]" type="text"' +
                    'value="" class="form-control"/></div></td><td><div class="form-group">' +
                    '<input name="{{ $name }}[' + index + '][option_value]" type="text"' +
                    'value="" class="form-control"/></div></td>' +
                    '<td><input name="{{ $name }}[' + index + '][option_display]" type="text"' +
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
