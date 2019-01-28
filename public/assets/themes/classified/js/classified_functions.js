/**
 * init elements on page loading and ajax complete
 */
function initThemeElements() {
    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        }
    });

    $('.select2-normal').select2();
    $('.select2-normal.tags').select2({
        tags: []
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    initNoUISlider();
    categoriesExpandStatus();
    init_iCheck();
}

function categoriesExpandStatus() {

    $('.has-children').each(function () {
        if ($("input:checked").length) {
            $("input:checked").parent().parent().parent().removeClass("collapse").addClass("collapsed");
        }
    });
}


function init_iCheck() {
    // iCheck init
    $('input[type=checkbox],input[type=radio]').not('.disable-icheck').each(function () {
        if ($(this).css('opacity') != "0") {
            $(this).iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue',
                // increaseArea: '20%' // optional
            });
            $(this).on('ifClicked', function (event) {
                $(event.target).click()
            });
            $(this).on('ifChanged', function (event) {
                $(event.target).trigger('change');
            });
        }

    });

}

function themeConfirmation(title, text, type, confirm_btn, cancel_btn, callback, dismiss_callback) {
    swal({
        title: title,
        text: text,
        type: type,
        showCancelButton: true,
        animation: true,
        // customClass: 'animated tada',
        confirmButtonColor: "#ff7014",
        confirmButtonText: confirm_btn,
        cancelButtonText: cancel_btn
    }).then(
        function () {
            if (typeof callback === "function") {
                // Call it, since we have confirmed it is callable​
                callback();
            }
        }, function (dismiss) {
            if (typeof dismiss_callback === "function") {
                // Call it, since we have confirmed it is callable​
                dismiss_callback()
            }
        });
}

function themeNotify(data) {

    if (undefined == data.level && undefined == data.message) {

        if (undefined != data.responseJSON) {
            data = data.responseJSON;
        }

        var level = 'error';
        var message = data.message;
        var errors = data.errors;

        if (undefined == errors && undefined == message) {
            return;
        }
    } else {
        var level = data.level;
        var message = data.message;
    }

    if (undefined != errors) {
        message += "<br>";
        $.each(errors, function (key, val) {
            message += val + "<br>";
        });
    }
    if (undefined == level && undefined == message) {
        level = 'error';
        message = 'Something went wrong!!';
    }

    toastr[level](message);
}

function toggleWishListProduct(response) {

    $wishlist_item = $('*[data-wislist_class="' + response.hashed_id + '"]');
    console.log(response.action);
    if (response.action == "add") {
        $wishlist_item.removeClass('lni-heart');
        $wishlist_item.addClass('lni-heart-filled');
    } else {
        $wishlist_item.removeClass('lni-heart-filled');
        $wishlist_item.addClass('lni-heart');
    }
}

function initNoUISlider() {
    var rangeSliders = document.getElementsByClassName('ui-range-slider');
    for (var i = 0; i < rangeSliders.length; i++) {
        let rangeSlider = rangeSliders[i];

        let dataStartMin = parseInt(rangeSlider.parentNode.getAttribute('data-start-min'), 10),
            dataStartMax = parseInt(rangeSlider.parentNode.getAttribute('data-start-max'), 10),
            dataMin = parseInt(rangeSlider.parentNode.getAttribute('data-min'), 10),
            dataMax = parseInt(rangeSlider.parentNode.getAttribute('data-max'), 10),
            dataStep = parseInt(rangeSlider.parentNode.getAttribute('data-step'), 10);
        let valueMin = $('.ui-range-value-min span', rangeSlider.parentNode).get(0),
            valueMax = $('.ui-range-value-max span', rangeSlider.parentNode).get(0),
            valueMinInput = $('.ui-range-value-min input', rangeSlider.parentNode).get(0),
            valueMaxInput = $('.ui-range-value-max input', rangeSlider.parentNode).get(0);

        noUiSlider.create(rangeSlider, {
            start: [dataStartMin, dataStartMax],
            connect: true,
            step: dataStep,
            range: {
                'min': dataMin,
                'max': dataMax
            }
        });
        rangeSlider.noUiSlider.on('update', function (values, handle) {
            let value = values[handle];
            if (handle) {
                valueMax.innerHTML = Math.round(value);
                valueMaxInput.value = Math.round(value);
            } else {
                valueMin.innerHTML = Math.round(value);
                valueMinInput.value = Math.round(value);
            }
        });
    }
}