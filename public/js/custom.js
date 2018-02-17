"use strict";

// ==== Start Carousel ====
function start_carousel(el) {
    el.owlCarousel({
        rtl:true,
        loop:true,
        margin:30,
        stopOnHover : false,
        navigation : true,
        navigationText : ["&lsaquo;", "&rsaquo;"],
        pagination : false,
        paginationNumbers : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:2,
                nav:false
            },
            1000:{
                items:4,
                nav:true,
                loop:false
            }
        }
    });
}

// ==== Initial Google Map ====
function initialize(latitude, longitude, address, zoom) {
    var latlng = new google.maps.LatLng(latitude,longitude);

    var myOptions = {
        zoom: zoom,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    var marker = new google.maps.Marker({
        position: latlng, 
        map: map, 
        title: "location : " + address
    });
}

// ==== Go to top ====
function go_up(){
    // to top
    $('.go-up').hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            $('.go-up').fadeIn();
        } else {
            $('.go-up').fadeOut();
        }
    });
    $('.go-up a').on('click', function (e) {
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
}

$(document).ready(function(){ 
    go_up();

    // ==== Fix menu postion when scroll ====
    $(window).scroll(function () {
        if ($(window).scrollTop() > 120) {
            $('#top-header').addClass('fixed ');
        } else {
            $('#top-header').removeClass('fixed');
        }
    });

    // ==== Create menu for mobile ====
	$('#all').after('<div id="off-mainmenu"><div class="off-mainnav"><div class="close-menu"><i class="pe-7s-close"></i></div></div></div>');
    $('#main-nav').clone().appendTo('.off-mainnav');

    $('#btn-menu').on('click', function (e) {
        e.preventDefault();
        $('body').addClass('mainmenu-active');
    });
	
    $('.close-menu').on('click', function (e) {
        e.preventDefault();
        $('body').removeClass('mainmenu-active');
    });

	// ==== Display menu when resize window ====
    $(window).on('resize', function () {
        var win = $(this); //this = window
        if (win.width() >= 1000) {
            $('#main-nav').css({
                display: 'block'
            });
        }
    });
    
    // ==== Tab ====
    $('#myTabs a').on('click', function (e) {
		e.preventDefault();
		$(this).tab('show');

		start_carousel($(this).parents('.tabs-top').find($(this).attr('href') + ' .owl-carousel'));
    });

    $(".tabproduct-carousel").each(function(){
        start_carousel($(this));
    });

    // ==== Slideshow ====
    $('.main-slider').owlCarousel({
        rtl:true,
        items: 1,
        nav: true,
        dots: true
    });

    // ==== Featured Product ====
    $('.featured-productcarousel').owlCarousel({
        rtl:true,
        loop:true,
        trl: true,
        margin:30,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:2,
                nav:false
            },
            1000:{
                items:3,
                nav:true,
                loop:false
            }
        }
    });

    // ==== Related Product ====
    $('.blockproductscategory_grid').owlCarousel({
        rtl:true,
        loop:true,
        margin:30,
        stopOnHover : false,
        navigation : true,
        navigationText : ["&lsaquo;", "&rsaquo;"],
        pagination : false,
        paginationNumbers : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:2,
                nav:false
            },
            1000:{
                items:4,
                nav:true,
                loop:false
            }
        }
    });

    // ==== Manufactures ====
    $('.manufacture_block').owlCarousel({
        rtl:true,
        loop:true,
        margin:10,
        stopOnHover : false,
        pagination : false,
        paginationNumbers : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
                nav:true
            },
            600:{
                items:4,
                nav:false
            },
            1000:{
                items:5,
                nav:true,
                loop:false
            }
        }
    });

	// ==== Gallery ====
    $('.block-gallery .row').magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery:{enabled:true},
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        }
    });

    // ==== Google Map ====
    var address = jQuery('.contact-address').html();
    var width = '100%';
    var height = '500px';
    var zoom = 16;
   
    // Create map html
	if (address) {
		$('#map').html('<div id="map_canvas" style="width:' + width + '; height:' + height + '"></div>');
		
		var geocoder = new google.maps.Geocoder();

		geocoder.geocode({'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				initialize(latitude, longitude, address, zoom);
			}
		});
	}
	
	// ==== Product detail image ====
	$('#image-block #view_full_size').each(function(index) {
		$(this).find('img').elevateZoom({zoomType:"inner", cursor:"crosshair", easing:true, scrollZoom:false});
	});
	$('#thumbs_list ul li').on('click', function (e) {
		$('#image-block #view_full_size').html($(this).html()).find('img').elevateZoom({zoomType:"inner", cursor:"crosshair", easing:true, scrollZoom:false});;
	});
	
	// ==== Popup Screen ====
	$('.tiva-popup-screen').each(function(index) {
		// Control when window small
		if (screen.width < 500) {
			$(this).find('.popup').css('width', '80%');
		}
		
		// Click to close popup
		$('html').on('click', function (e) {
			if (e.target.id == 'tiva-popupscreen') {
				$('.tiva-popup-screen').remove();
			}
		});
		$(this).find('.popup .close').on('click', function (e) {
			e.preventDefault();
			$('.tiva-popup-screen').remove();
		});
		
		// Screen duration
		var popup = $(this);
		setTimeout(function() {
			$('.tiva-popup-screen').remove();
		}, 20 * 1000);
	});
    
}); //end