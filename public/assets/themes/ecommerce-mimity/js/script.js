$(function () {

    // Attach breakpoint value to "body::before" for easily responsive development
    var breakpoint = {
        refreshValue: function () {
            this.value = window.getComputedStyle(document.querySelector('body'), ':before').getPropertyValue('content').replace(/\"/g, '');
        }
    };

    // Update breakpoint value on resized
    $(window).resize(function () {
        breakpoint.refreshValue();
    }).resize();

    // This is for development, show breakpoint to title
    /*var docTitle = document.title;
    $(window).resize(function() {
      document.title = '('+breakpoint.value+') '+docTitle;
    }).resize();*/

    // Form search, prevent submit on empty value
    $('.form-search').submit(function (event) {
        var searchInput = $(this).find('input');
        if (searchInput.val() == '') {
            searchInput.trigger('focus');
            event.preventDefault();
        }
    });

    // Perfect Scrollbar for sidebar
    var psSidebar = new PerfectScrollbar('#main-sidebar');

    // MORE & LESS toggle
    $('#main-sidebar .toggle').click(function () {
        var toggler = $(this);
        if (toggler.attr('aria-expanded') == 'true') {
            toggler.html('MORE &#9662;');
        } else {
            toggler.html('LESS &#9652;');
        }
    });
    // Update Perfect Scrollbar
    $('#main-sidebar .collapse').on('shown.bs.collapse', function () {
        psSidebar.update();
    });
    $('#main-sidebar .collapse').on('hidden.bs.collapse', function () {
        psSidebar.update();
    });

    var mainContainer = $('#main-container');
    // Toggle sidebar collapse
    $('.toggle-menu').click(function () {
        mainContainer.toggleClass('sidebar-collapse');
        if (breakpoint.value != 'lg' && breakpoint.value != 'xl' && !mainContainer.hasClass('sidebar-collapse')) {
            $('body').addClass('modal-open').append('<div class="sidebar-backdrop"></div>');
        } else {
            $('body').removeClass('modal-open').find('.sidebar-backdrop').remove();
        }
        $(document).trigger('sidebar.changed');
    });
    // Force to collapse sidebar on md down
    $(window).resize(function () {
        if (breakpoint.value != 'lg' && breakpoint.value != 'xl') {
            mainContainer.addClass('sidebar-collapse');
            $('body').removeClass('modal-open').find('.sidebar-backdrop').remove();
            $(document).trigger('sidebar.changed');
        } else {
            mainContainer.removeClass('sidebar-collapse');
            $(document).trigger('sidebar.changed');
        }
    }).resize();
    $(document).on('click', '.sidebar-backdrop', function (event) {
        $('.toggle-menu').trigger('click');
        event.preventDefault();
    });

    // Rating Icons
    $('.rating').each(function () {
        var value = $(this).data('value');
        for (var i = 0; i < Math.floor(value); i++) {
            $(this).append('<i class="fa fa-star"></i>\n');
        }
        if (value % 1 != 0) {
            $(this).append('<i class="fa fa-star-half-o"></i>\n');
        }
        var total = $(this).find('i.fa').length;
        if (total < 5) {
            for (var x = 0; x < (5 - total); x++) {
                $(this).append('<i class="fa fa-star-o"></i>\n');
            }
        }
    });

    // Background Cover
    var cover = function () {
        $('[data-cover]').each(function () {
            var cover = $(this);
            cover.css('background-image', 'url(' + decodeURIComponent(cover.data('cover')) + ')');
            cover.attr('data-height') && cover.css('height', cover.data('height'));
            switch (breakpoint.value) {
                case 'xs':
                    cover.attr('data-xs-height') && cover.css('height', cover.data('xs-height'));
                    break;
                case 'sm':
                    cover.attr('data-sm-height') && cover.css('height', cover.data('sm-height'));
                    break;
                case 'md':
                    cover.attr('data-md-height') && cover.css('height', cover.data('md-height'));
                    break;
                case 'lg':
                    cover.attr('data-lg-height') && cover.css('height', cover.data('lg-height'));
                    break;
                case 'xl':
                    cover.attr('data-xl-height') && cover.css('height', cover.data('xl-height'));
                    break;
            }
        });
    }
    $(window).resize(function () {
        cover();
    }).resize();
    cover();

    // Toggle Search Form
    $('#search-toggle').click(function (event) {
        $('.form-search').toggleClass('d-none').find('.form-control').focus();
        event.preventDefault();
    });
    $('.btn-search-back').click(function (event) {
        $('.form-search').toggleClass('d-none');
        event.preventDefault();
    });

    // Home Slider
    if ($('#home-slider').length && typeof Swiper !== 'undefined') {
        var homeSlider = new Swiper('#home-slider', {
            loop: true,
            navigation: {
                prevEl: '#home-slider-prev',
                nextEl: '#home-slider-next',
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            }
        });
        $(document).on('sidebar.changed', function () {
            homeSlider.update();
        });
    }

    // Categories Slider
    if ($('#categories-slider').length && typeof Swiper !== 'undefined') {
        var categoriesSlider = new Swiper('#categories-slider', {
            navigation: {
                prevEl: '#categories-slider-prev',
                nextEl: '#categories-slider-next',
            }
        });
        $(document).on('sidebar.changed', function () {
            categoriesSlider.update();
        });
    }

    // Popular Slider
    if ($('#popular-slider').length && typeof Swiper !== 'undefined') {
        var popularSlider = new Swiper('#popular-slider', {
            navigation: {
                prevEl: '#popular-slider-prev',
                nextEl: '#popular-slider-next',
            }
        });
        $(document).on('sidebar.changed', function () {
            popularSlider.update();
        });
    }

    // Brands Slider
    if ($('#brands-slider').length && typeof Swiper !== 'undefined') {
        var brandsSlider = new Swiper('#brands-slider', {
            navigation: {
                prevEl: '#brands-slider-prev',
                nextEl: '#brands-slider-next',
            }
        });
        $(document).on('sidebar.changed', function () {
            brandsSlider.update();
        });
    }

    // Price Range Slider

    // Rating Range Slider
    if ($('#star-rating').length) {
        $('#star-rating').raty({
            half: true,
            score: function () {
                return $(this).attr('data-score');
            }
        });
    }

    // Show large image on hover
    $('.img-detail-list a').mouseenter(function () {
        var src = $(this).find('img').data('large-src');
        var dataIndex = $(this).find('img').data('index');
        $('#img-detail').attr('src', src);
        ;
        $('#img-detail').data('index', dataIndex);
        ;
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });
    $('.img-detail-list a').click(function (event) {
        event.preventDefault();
    });

    // Photoswipe
    var parseThumbnailElements = function () {
        var items = [];
        $('.img-detail-list img').each(function () {
            item = {
                src: $(this).data('large-src'),
                w: 1000,
                h: 850
            };
            items.push(item);
        });
        return items;
    }
    var openPhotoSwipe = function (activeIndex) {
        activeIndex = typeof activeIndex !== 'undefined' ? activeIndex : 0;
        var pswpElement = document.querySelectorAll('.pswp')[0];
        var items = parseThumbnailElements();
        var options = {
            index: activeIndex
        };
        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    }
    $('#img-detail').click(function (event) {
        openPhotoSwipe($(this).data('index'));
    });

    // Spinner for quantity input
    $('.input-spinner').each(function () {
        var input = $(this).find('input[type="number"]'),
            min = input.attr('min'),
            max = input.attr('max'),
            btnIncrease = $(this).find('.btn:first-child'),
            btnDecrease = $(this).find('.btn:last-child');
        btnIncrease.click(function () {
            if (input.val() < max) {
                input.val(parseInt(input.val()) + 1).trigger('change');
            }
        });
        btnDecrease.click(function () {
            if (input.val() > min) {
                input.val(parseInt(input.val()) - 1).trigger('change');
            }
        });
    });

    // Credit Card Form
    if ($('#card').length) {
        $('#card').card({
            container: '.card-wrapper',
        });
    }

    var width = $(window).width();
    $(window).on('resize', function () {
        if ($(this).width() != width) {
            width = $(this).width();
            setWrapperHeight();
        }
    });

    // calculate element sizes here is accurate because the entire page has been loaded
    $(document).ready(function () {
        setWrapperHeight();
    });

    function setWrapperHeight() {
        var height = $(window).height();
        var html = $('html').height();
        if (height > html) {
            $("#wrapper").css("min-height", html + 50)
        }
    }
});