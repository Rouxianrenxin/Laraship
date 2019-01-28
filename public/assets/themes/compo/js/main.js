"use strict";

$(window).on("load",function(){

    $(".loader-backdrop").fadeOut();               // Open Modal on Load or after delay
});

jQuery(document).ready(function() { 

    // ************ Function Calls ************//

    if($(".navbar-nav").length){
        callCurrentMenuItem();                    // Auto Select Current Menu Item
    }

    if($(".sub-menu").length){

        var rtl = false;                                // If language is not RTL
        
        if($("html").attr("dir")=="rtl"){
            rtl = true;                                 // If language is RTL
        }
        
        callMenuAlign(rtl);                             // For each sub-menu, check if it crosses window
    }

    if($(".main-image").length){
        callProductZoom();                        // Product Image Zoom on Product Detail Page
    }

    $(".open-widget").click(function(e){
        e.preventDefault();
        $(this).parent().toggleClass("open");    // Topbar Widgets Toggler
    });

    if($(".has-menu").length){
        callMobileMenuToggle();                  // Call to Mobile Menu Toggler
    }

    // if($("#slider").length){
    //     callSliderRevolution();                  // Call to Slider Revolution
    // }

    // if($("#slider-shop").length){
    //     callSliderRevolutionShop();              // Call to Slider Revolution Shop
    // }
    //
    // if($("#slider-boxed").length){
    //     callSliderRevolutionBoxed();             // Call to Slider Revolution Boxed
    // }

    if($(".announcement").length){
        callAnnounceToggle();                    // Call to Announcement Slide Up/Down
    }
    
    if($(".announcement-text").length){
        callAnnouncement();                      // Call to Announcement Carousels
    }
    
    if($(".timer").length){
        $(".timer").each(function(){
           callCountdown(this);                  // Call to Event Countdown Timer
       });
    }

    if($(".testimonials").length){
        $(".testimonials").each(function(){
            callTestimonial(this);               // Call to Testimonials Carousel
        });
    }
    
    if($(".logo-scroll").length){
        callLogoScroll();                        // Call to Logo Scroll
    }
    
    if($(".tweets").length){
        callTweetScroll();                       // Call to Tweet Scroll
    }
    
    if($(".fact .count").length){          
        $(".fact .count").appear(function() {    // Call function callCountTo() only when the Element is in viewport
            callCountTo(this);
        });
    }

    if($(".parallax").length && $(window).width() > 960){
        callBackgroundParallax();                // Call to  background parallax
    }
    
    if($(".youtube").length){    
        $(".youtube").each(function(){
            callYoutubeVideo(this);                     // Style each video found on page
        });        
    }
    
    if($("#gmap").length){

        var lat=$("#gmap").attr("data-lat");            // Latitude of the place to be marked
        
        var long=$("#gmap").attr("data-long");          // Longitude of the place to be marked
        
        var infoWin=$("#gmap").attr("data-info-win");   // Content to be shown in Info Window on Marker
        
        callGoogleMapStyle(lat, long, infoWin);         // Call to Google Map Styler
    }
    
    if($("#back").length){                              // Back To Top Button
        callBackToTop();
    }

    if($("a[data-gal^='prettyPhoto']").length){
        callPrettyPhoto();                              // Pretty Photo
    }
}); 

// ************Definitions of Functions************//

function callCurrentMenuItem(){

    var currentUrl = $(location).attr("href");          // Gets current location of the browser

    $(".navbar-nav .menu-list a").each(function(){      // Traverse each <a> in the menu
        var checkThisUrl = $(this).attr("href");
        if((splitUrl(checkThisUrl)) == splitUrl(currentUrl)){       //Check if this <a> matches with the browser location
            $(this).closest(".nav-item").addClass("active");
        }
    });

    function splitUrl(thisUrl){         // Takes URL path and returns only the web page name
        thisUrl=thisUrl.toString();
        var urlSplit = thisUrl.split("/");
        var thisPage = urlSplit[urlSplit.length-1];
        return thisPage;
    }
}

function callMenuAlign(rtol){

    var windowWidth = $(window).width();        // Get Window width

    $('.sub-menu').each(function(){

        var subMenuwidth = $(this).width();         //Get sub-menu width
        var containerWidth = $(this).closest('.container').width();         //Get Parent Container width 
        var subMenuOffset = $(this).offset().left;          //Get sub-menu offset from the left
        var containerOffset = $(this).closest('.container').offset().left;          //Get parent container offset from the left
        
        if(rtol==true){
            subMenuOffset = ( windowWidth - (subMenuOffset + subMenuwidth));        //Get sub-menu offset from right if RTL language
        }

        var relativeOffset =  subMenuOffset - containerOffset;

        if((relativeOffset + subMenuwidth) > (containerWidth+((windowWidth-containerWidth)/2))){
            $(this).addClass("sub-menu-reversed");          //Add class to sub-menu if it crosses window
        }
    });
}

function callProductZoom(){
    $(".main-image, .thumbnail-image").xzoom({
        position: "inside"
    });
}

function callMobileMenuToggle(){
    $(".has-menu > a").click(function(e){
        e.preventDefault();
        $(this).parent().toggleClass("open-menu");
    });
}

function callSliderRevolution()
{
    jQuery("#slider").revolution({
      sliderType:"standard",
      sliderLayout:"auto",
      delay:5000,                                       // Delay in Transition from one slide to another in milliseconds
      navigation: {
          arrows:{enable:true}
      },
      lazyLoad:"on",
      gridwidth:1200,
      gridheight:800,
      parallax:{
        type:"scroll"
    }
});
}

function callSliderRevolutionBoxed()
{
    jQuery("#slider-boxed").revolution({
      sliderType:"standard",
      sliderLayout:"auto",
      delay:5000,                                       // Delay in Transition from one slide to another in milliseconds
      navigation: {
          arrows:{enable:true}
      },
      lazyLoad:"on",
      gridwidth:1200,
      gridheight:600,
      parallax:{
        type:"scroll"
    }
});
}

function callSliderRevolutionShop()
{
    jQuery("#slider-shop").revolution({
      sliderType:"standard",
      sliderLayout:"auto",
      delay:5000,                                       // Delay in Transition from one slide to another in milliseconds
      navigation: {
          arrows:{
            enable:true,
            style: 'zeus'
        }
    },
    lazyLoad:"on",
    gridwidth:1200,
    gridheight:750
});
}

function callAnnounceToggle()
{
    $(".btn-announce").click(function(e){
        e.preventDefault();
        $(".btn-announce").toggleClass("open");
        $(".announcement").toggleClass("open");        // Slides Open or Closes the announcement section on Home Page
    });
}

function callAnnouncement()
{
    var announceCarousel= $('.announcement-text');
    
    $('.announcement .owl-left').click(function() {
        announceCarousel.trigger('prev.owl.carousel');
    })
    
    $('.announcement .owl-right').click(function() {
        announceCarousel.trigger('next.owl.carousel');
    })

    announceCarousel.owlCarousel({
        items:1,
        //  rtl: true,        Uncomment this line for RTL support
        center:true,
        loop: true,
        autoplay: true,
        autoplayTimeout: 2500                       // Announcements transition time from one to another in milliseconds
    });
}

function callCountdown(thisTimer)
{
    var date=$(thisTimer).attr("data-date");
    $(thisTimer).countdown(date, function(event) {
        $(this).find(".days").html(event.strftime("%D"));              // Days Left
        $(this).find(".hours").html(event.strftime("%H"));             // Hours Left
        $(this).find(".minutes").html(event.strftime("%M"));           // Minutes Left
        $(this).find(".seconds").html(event.strftime("%S"));           // Seconds Left
    });
}

function callTestimonial(currentTestimonial)
{
    var testiCarousel= $(currentTestimonial);
    
    testiCarousel.next().find('.owl-left').click(function() {
        testiCarousel.trigger('prev.owl.carousel');
    })
    
    testiCarousel.next().find('.owl-right').click(function() {
        testiCarousel.trigger('next.owl.carousel');
    })

    testiCarousel.owlCarousel({
        items:1,
        //  rtl: true,        Uncomment this line for RTL support
        loop: true,
        center: true,
        nav: false,
        margin: 20,
        autoplay: true,
        autoplayTimeout: 4000,                       // Testimonials Carousel transition time from one to another in milliseconds
        autoplayHoverPause: true
    });
}

function callCountTo(thisCount){
    $(thisCount).countTo();
}

function callLogoScroll()
{
    $(".logo-scroll").owlCarousel({
        items:5,
        //  rtl: true,        Uncomment this line for RTL support
        loop: true,
        margin:70,
        center: true,
        autoplay: true,
        autoplayTimeout: 2500,                       // Logo Carousel transition time from one to another in milliseconds
        responsive : {
            0 : {
                items : 1
            },
            480 : {
                items : 3
            },
            // breakpoint from 768 up
            768 : {
                items : 5
            }
        }
    });
}

function callTweetScroll()
{
    $(".tweets").owlCarousel({
        items:1,
        //  rtl: true,        Uncomment this line for RTL support
        loop: true,
        autoplay: true,
        autoplayTimeout: 2500                       // Tweets transition time from one to another in milliseconds
    });
}

function callBackgroundParallax(){

  var $fwindow = $(window);
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

  $fwindow.on('scroll resize', function() {
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
}); 

  $('[data-type="content"]').each(function (index, e) {
    var $contentObj = $(this);
    var fgOffset = parseInt($contentObj.offset().top);
    var yPos;
    var speed = ($contentObj.data('speed') || 1 );

    $fwindow.on('scroll resize', function (){
      yPos = fgOffset - scrollTop / speed; 

      $contentObj.css('top', yPos);
  });
});

  $(".parallax").each(function(){
    var $backgroundObj = $(this);
    var bgOffset = parseInt($backgroundObj.offset().top);
    var yPos;
    var coords;
    var speed = ($backgroundObj.data('speed') || 0 );

    $fwindow.on('scroll resize', function() {
      yPos = - ((scrollTop - bgOffset) / speed); 
      coords = '50% '+ yPos + 'px';

      $backgroundObj.css({ backgroundPosition: coords });
  }); 
}); 

  $fwindow.trigger('scroll');
}

function callYoutubeVideo(currentVideo)
{    
    var videoId = $(currentVideo).attr("data-video-id");                                    // Get Video ID from data attributes
    
    var thumbnail = 'url(https://img.youtube.com/vi/'+ videoId + '/sddefault.jpg)';         // Get Thumbail image of the video
    
    $(currentVideo).css("background-image", thumbnail);                                     // Set thmbnail image as the background
    
    var videoUrl= "https://www.youtube.com/embed/" + videoId + "?autoplay=1&autohide=1";    // Framing Video URL from video ID
    
    $(currentVideo).find(".btn-play").click(function(){                                     // If play button is clicked, load Video within IFrame
        var videoFrame = $('<iframe/>', {
            'frameborder': '0',
            'src': videoUrl,
            'width': $(currentVideo).width(),
            'height': $(currentVideo).height()
        });
        $(currentVideo).replaceWith(videoFrame);                                            // Finally replace the div with IFrame
    });    
}

function callGoogleMapStyle(lat, long, infoWin)
{
    if(window.google == undefined){
        return;
    }
    var styles = [
    {
        featureType: 'water',                       //Color of the Water Bodies
        elementType: 'geometry.fill',
        stylers: [
        { color: '#adc9b8' }
        ]
    },{
        featureType: 'landscape.natural',           //Color of the Natural Landscapes
        elementType: 'all',
        stylers: [
        { hue: '#809f80' },
        { lightness: -35 }
        ]
    },{
        featureType: 'poi',                         //Color of Points of Interest like Business
        elementType: 'geometry',
        stylers: [
        { hue: '#f9e0b7' },
        { lightness: 30 }
        ]
    },{
        featureType: 'road',                        //Color of Main Roads
        elementType: 'geometry',
        stylers: [
        { hue: '#d5c18c' },
        { lightness: 14 }
        ]
    },{
        featureType: 'road.local',                  //Color Of Local Roads
        elementType: 'all',
        stylers: [
        { hue: '#ffd7a6' },
        { saturation: 100 },
        { lightness: -12 }
        ]
    }
    ];
    
    var options = {
        mapTypeControlOptions: {
            mapTypeIds: ['Styled']
        },
        center: new google.maps.LatLng(lat, long),
        zoom: 16,
        disableDefaultUI: true, 
        mapTypeId: 'Styled'
    };
    var div = document.getElementById('gmap');
    
    var map = new google.maps.Map(div, options);
    
    var styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });
    
    map.mapTypes.set('Styled', styledMapType);
    
    var marker = new google.maps.Marker({
        map: map,
        icon: 'images/map-pin.png',
        position: new google.maps.LatLng(lat, long)             // Set Marker Position of the place
    });
    
    marker['infowindow'] = new google.maps.InfoWindow({
        content: infoWin                                        // Set Content of the Info Window of the Marker
    });

    new google.maps.event.addListener(marker, 'mouseover', function() {
        this['infowindow'].open(map, this);                     // On Marker Hover, show Info Window
    });    
}

function callBackToTop()
{
    var offset = 250;                          // Offset after which Back To Top button will be visible 
    var duration = 1000;                       // Time duration in which the page scrolls back up.
    
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            $('#back').fadeIn(500);
        } else {
            $('#back').fadeOut(500);
        }
    });

    jQuery('#back').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    });    
}

function callPrettyPhoto()
{
    $("a[data-gal^='prettyPhoto']").prettyPhoto({social_tools:''});
}