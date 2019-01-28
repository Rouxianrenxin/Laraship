$(document).ready(function () {
    initThemeElements();

    // Range Slider
    //------------------------------------------------------------------------------
    var rangeSlider = document.querySelector('.ui-range-slider');
    if (typeof rangeSlider !== 'undefined' && rangeSlider !== null) {
        var dataStartMin = parseInt(rangeSlider.parentNode.getAttribute('data-start-min'), 10),
            dataStartMax = parseInt(rangeSlider.parentNode.getAttribute('data-start-max'), 10),
            dataMin = parseInt(rangeSlider.parentNode.getAttribute('data-min'), 10),
            dataMax = parseInt(rangeSlider.parentNode.getAttribute('data-max'), 10),
            dataStep = parseInt(rangeSlider.parentNode.getAttribute('data-step'), 10);
        var valueMin = document.querySelector('.ui-range-value-min span'),
            valueMax = document.querySelector('.ui-range-value-max span'),
            valueMinInput = document.querySelector('.ui-range-value-min input'),
            valueMaxInput = document.querySelector('.ui-range-value-max input');
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
            var value = values[handle];
            if (handle) {
                valueMax.innerHTML = Math.round(value);
                valueMaxInput.value = Math.round(value);
            } else {
                valueMin.innerHTML = Math.round(value);
                valueMinInput.value = Math.round(value);
            }
        });

    }
});

$(document).ajaxComplete(function (event, xhr, settings) {
    initThemeElements();
});