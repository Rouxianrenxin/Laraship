function initElements() {
    if (typeof CKEDITOR !== "undefined") {
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.dtd.$removeEmpty['i'] = false;
        CKEDITOR.config.filebrowserBrowseUrl = '/file-manager/ckeditor';
    }

    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        }
    });

    if ($.fn.iconpicker) {
        $('.icp-auto').iconpicker({
            animation: false
        });
    }

    $('[data-toggle="popover"]').popover();

    if (window.initFunctions) {
        $.each(window.initFunctions, function (index, element) {
            window[element]();
        });
        window.initFunctions = [];
    }

    if (window.Ladda) {
        Ladda.bind('button[type=submit]');
        Ladda.bind('.laddaBtn');
        Ladda.bind('[data-action]');
    }

    initCopyToClipBoard();
    initTabHash();
    initLimitedText();
    initFormIsDirty();
    initFormLangSwitcher();
}

function initLimitedText() {
    $('.limited-text').each(function () {
        var value = $(this).val();

        var limit = $(this).prop('maxlength');

        if (value.length == limit) {
            event.preventDefault();
        } else if (value.length > limit) {
            // Maximum exceeded
            value = value.substring(0, limit);
            $(this).val(value);
        }

        $(this).parent().find(".limit-counter").text(value.length);
    });
}

function initCopyToClipBoard() {
    if ($('.copy-button').length && window.Clipboard) {
        var clipboard = new Clipboard('.copy-button');
        clipboard.on('success', function (e) {
            // e.clearSelection();
            var message = {
                level: 'success',
                message: 'Copied to clipboard!'
            };
            themeNotify(message);
        });
    }
}

function initTabHash() {
    //init tabs hash
    let hash = window.location.hash;

    if (hash.length) {
        let hasURLParameters = hash.indexOf('?');//-1 if not exist
        let indexOfHash = hash.indexOf('#');

        if (hasURLParameters && hasURLParameters > indexOfHash) {
            hash = _.split(hash, '?')[0];
        }

        $('ul.nav a[href="' + hash + '"]').tab('show');
    }

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');

        var scroll = $(this).offset().top - 150;

        window.location.hash = this.hash;

        $('html,body').scrollTop(scroll);
    });
}

function refreshDataTable(table) {
    var $table = $(table);
    if (undefined !== table && $table.length) {
        $table.DataTable().ajax.reload();
    }else{
        site_reload();
    }
}

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function redirectTo(data) {
    setTimeout(function () {
        window.location.replace(data.url);
    }, 1000);
}

function site_reload() {
    setTimeout(function () {
        location.reload();
    }, 1000);
}

function clearForm(response, $form) {
    $form[0].reset();
}

function closeModal(response, $form) {
    setTimeout(function () {
        clearForm(response, $form);
        $form.closest('.modal ').modal('hide');
    }, 1000);
}


/* Simulate Ajax call on Panel with reload effect */
function blockUI(item) {
    if ($.fn.block) {
        $(item).block({
            message: '<svg class="circular"><circle class="path" cx="40" cy="40" r="10" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg>',
            css: {
                border: 'none',
                width: '14px',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.6,
                cursor: 'wait'
            }
        });
    }
}

function unblockUI(item) {
    if ($.fn.unblock) {
        $(item).unblock();
    }
}

function readURL(area, input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if (area.find('.preview').length) {
                area.find('.preview').attr('src', e.target.result);
                area.find('.preview').removeClass('hidden');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on("change", ".upload-file-area", function () {
    var $area = $(this);
    var $input = $("#" + $area.data('input'));

    if ($area.find(".file-name").length) {
        var fileNameSpan = $area.find(".file-name");

        var names = '';

        for (var i = 0; i < $input[0].files.length; ++i) {
            names += $input[0].files[i].name + ' | ';
        }
        names = _.trim(names, ' | ');

        fileNameSpan.text(names);
    }

    readURL($area, $input[0]);
});

$(document).on('click', '.modal-load', function (e) {
    e.preventDefault();
    var title = $(this).data('title');
    var view_url = $(this).attr('href');
    $.get(view_url, function (data) {
        $('#global-modal').modal();
        $('#global-modal').on('shown.bs.modal', function () {
            $('#modal-body-global-modal').html(data);
            $('#global-modal .modal-header .modal-title').html(title);
            initElements();
            initThemeElements();
        });
        $('#global-modal').on('hidden.bs.modal', function () {
            $('#global-modal .modal-body').data('');
        });
    });

});

function clearFormValidationBeforeSubmit(form) {
    $('.has-error .help-block', form).html('');

    $('.form-group', form).removeClass('has-error');

    $('.nav.nav-tabs li a').removeClass('c-red');
}

function handleAjaxSubmitSuccess(response, textStatus, jqXHR, page_action, actionData, table, $form) {
    if ($form) {
        try {
            $form.prop('is_dirty', false);
        } catch (e) {

        }
    }

    if (response.message) {
        themeNotify(response);
    }

    if (response.action) {
        window[response.action](response, $form);
    }

    if (undefined !== table) {
        refreshDataTable(table);
    }

    if (undefined !== page_action) {
        window[page_action](response, $form, actionData);
    }
}

function handleAjaxSubmitError(response, textStatus, jqXHR, $form) {
    if (response.status === 422) {
        var errors = $.parseJSON(response.responseText)['errors'];
        // Iterate through errors object.
        $.each(errors, function (field, message) {
            //console.error(field+': '+message);
            //handle arrays
            if (field.indexOf('.') !== -1) {
                field = field.replace('.', '[');
                //handle multi dimensional array
                for (i = 1; i <= (field.match(/./g) || []).length; i++) {
                    field = field.replace('.', '][');
                }
                field = field + "]";
            }
            var formGroup = $('[name="' + field + '"]', $form).closest('.form-group');
            //Try array name
            if (formGroup.length === 0) {
                formGroup = $('[name="' + field + '[]"]', $form).closest('.form-group');
            }

            // try data-name
            if (formGroup.length === 0) {
                formGroup = $('[data-name="' + field + '"]', $form).closest('.form-group');
            }

            if (formGroup.length === 0) {
                field = field.replace(/[0-9]/, '');
                formGroup = $('[name="' + field + '"]', $form).closest('.form-group');
            }


            var tabIndex = formGroup.closest('.tab-pane').index();

            var panel = formGroup.closest('.panel').find('.panel-title').addClass('c-red');
            if (tabIndex >= 0) {
                $('.nav.nav-tabs li').eq(tabIndex).find('a').addClass('c-red');
            }
            formGroup.removeClass('hidden');

            formGroup.addClass('has-error has-danger').append('<small class="help-block form-control-feedback">' + message + '</small>');
        });
    }
    var data = {};
    data.message = $.parseJSON(response.responseText)['message'];
    data.level = 'error';
    themeNotify(data);

}

function divSubmit(div) {
    $('.has-error .help-block').html('');

    var page_action = div.data('page_action');
    var table = div.data('table');

    var actionData = div.data('action_data');

    var data = div.find('input, textarea, select').serializeArray();

    var formData = new FormData();

    $.each(data, function (index, element) {
        formData.append(element.name, element.value);
    });

    $.ajax({
        url: div.data('url'),
        type: div.data('method'),
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        success: function (response, textStatus, jqXHR) {
            handleAjaxSubmitSuccess(response, textStatus, jqXHR, page_action, actionData, table)
        },
        error: function (response, textStatus, jqXHR) {
            handleAjaxSubmitError(response, textStatus, jqXHR, div);
        }
    });
}

function ajax_form($form) {

    clearFormValidationBeforeSubmit($form);

    var page_action = $form.data('page_action');

    var actionData = $form.data('action_data');

    var table = $form.data('table');

    var formData = new FormData($form.get(0));

    var button = $('button[name]:focus', $form);

    if (button.length) {
        formData.append(button.attr('name'), button.attr('value'));
    }

    var url = $form.attr('action');

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response, textStatus, jqXHR) {
            handleAjaxSubmitSuccess(response, textStatus, jqXHR, page_action, actionData, table, $form);
        },
        error: function (response, textStatus, jqXHR) {
            handleAjaxSubmitError(response, textStatus, jqXHR, $form)
        }
    });
}

function ajaxRequest(url, requestData, table, page_action, method) {
    $.ajax({
        url: url,
        type: method,
        processData: false,
        contentType: false,
        dataType: 'json',
        data: JSON.stringify(requestData),
        success: function (data, textStatus, jqXHR) {
            themeNotify(data);

            if (undefined !== table) {
                refreshDataTable(table);
            }
            if (undefined !== page_action) {
                window[page_action](data);
            }
        },
        error: function (data, textStatus, jqXHR) {
            themeNotify(data);
        }
    });
}

function openInNewWindow(url, title) {
    event.preventDefault();
    var newWindow = window.open(url, title, 'height=480,width=640,top=200,left=300,resizable');

    if (window.focus) {
        newWindow.focus();
    }
}

function getURLSearchParameters() {
    let searchParameters = window.location.search.substr(1);

    let params = {};

    if (searchParameters !== null && searchParameters !== "") {

        let parametersArray = searchParameters.split("&");

        for (let i = 0; i < parametersArray.length; i++) {
            let parameter = parametersArray[i].split("=");
            params[parameter[0]] = parameter[1];
        }
    }

    return params;
}

function translateFormFields(response) {
    let form = $('[data-hashed_id="' + response.hashed_id + '"]').closest('form');

    if (!form.length) {
        return;
    }

    let translateables = response.translateables;

    $.each(translateables, function (fieldId, value) {
        $("#" + fieldId, form).val(value);
        $("#" + fieldId, form).prop('is_dirty', false);
    })

    if (window.CKEDITOR) {
        for (var i in CKEDITOR.instances) {
            textarea_name = CKEDITOR.instances[i].name;
            $textarea = $('textarea[name="' + textarea_name + '"]');
            CKEDITOR.instances[i].setData($textarea.val())

        }
    }

}

function switchFormFieldsTranslation(response, form, action_data) {

    let langCodeSelected = action_data.langCodeSelected;
    let activeLangCode = action_data.activeLangCode;
    let model = action_data.model;
    let hashed_id = action_data.hashed_id;

    activeLangCode.val(langCodeSelected);

    let url = '/get-model-translation';

    let requestData = {
        model: model,
        lang_code: langCodeSelected,
        hashed_id: hashed_id
    };

    let page_action = 'translateFormFields';

    ajaxRequest(url, requestData, undefined, page_action, 'POST');

    $('.form_language_switcher .btn', form).removeClass('current-lang btn-success');

    $('[data-lang_code="' + langCodeSelected + '"]').addClass('current-lang btn-default btn-secondary');

    initFormLangSwitcher();

    form.data('action_data', form.data('old_action_data'));
    form.data('page_action', form.data('old_page_action'));

    $("input[name=translation_submit]", form).remove();
}

function initFormLangSwitcher() {
    $('.current-lang').addClass('btn-success').removeClass('btn-default btn-secondary');
}

function initFormIsDirty() {
    $('form input, form select, form textarea, form input[type="checkbox"], form input[type="radio"]').not('.ignore-dirty-state').change(function () {
        $(this).prop('is_dirty', true);
        $(this).closest('form').prop('is_dirty', true);
    });
    if (window.CKEDITOR) {
        for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].on('key', function (event) {
                textarea_name = CKEDITOR.instances[i].name;
                $textarea = $('textarea[name="' + textarea_name + '"]');
                $textarea.prop('is_dirty', true);
                $textarea.closest('form').prop('is_dirty', true);
            });


        }
    }


}

function isFormDirty(form) {
    return !!$(form).prop('is_dirty');
}
