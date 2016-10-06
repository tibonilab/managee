var map;
var myLatLng = {lat: 43.828501223352006, lng: 12.685380830688473}
var gallery;


$(document).ready(function () {
	
	check_cookie_law();
	init_gallery()
	initMap();

	$(".fancybox").fancybox();
	$(".ajax-content").fancybox({
		type: 'ajax',
		fitToView: false,
		width: '70%',
		height: '70%',
		autoSize: false,
		closeClick: false,
		openEffect: 'none',
		closeEffect: 'none'
	});

	$('body').scrollspy({target: '#navbar', offset: 60})

	
	$(window).resize(function () {
		init_gallery();
		initMap();
	})
	
	$(window).scroll(function () {
		manage_navbar()
	})
	
	$(this).on('click', '.fancybox-inner .scrollTo', function () {
		$.fancybox.close();
	})
	
	
	$(this).on('click', '.in .nav a', function(){
		$('.navbar-toggle:not(.collapsed)').click() //bootstrap 3.x by Richard
	});
	
	
	$('form').submit(function (e) { 
		e.preventDefault();
		
		var form	= $(this)
		var data	= form.serialize();
		var target	= form.find('.response');
		
		$.ajax({
			url: '/ajax/email',
			data: data,
			dataType: 'JSON',
			method: 'post'
		}).done(function (response) {
			
			if(response.status)
			{
				form.find('input[type=text]').val('');
				form.find('textarea').val('');
			}
			
			target.html(response.msg)
		})
	})
	
	
})


function manage_navbar() 
{
	if($(window).scrollTop() > 0)
	{
		$('.navbar').removeClass('on-top')
	}
	else
	{
		$('.navbar').addClass('on-top')
	}
}

function init_gallery()
{
	$.ajax({
		url: '/ajax/gallery',
		type: 'json'
	}).done(function (list) {
		gallery = JSON.parse(list)
		init_backstretch();
	})
}

function init_backstretch()
{
	$("#main-gallery").css('height', $(window).height() - $('.navbar').outerHeight()).backstretch(gallery, {duration: 3000, fade: 750});

	$("#main-gallery-logo").css('margin-left', '-' + $("#main-gallery-logo").outerWidth() / 2 + 'px')
}

$('.owl-carousel').owlCarousel({
	items: 1,
	nav: true,
	dots: true,
	center: true,
	loop: true,
	autoplay: true,
	navText: [
      "<i class='fa fa-chevron-circle-left'></i>",
      "<i class='fa fa-chevron-circle-right'></i>"
    ],
	navElement: 'div'
});



function initMap() {
	
	var id = $('#map').closest('.visible-lg').css('display') == 'block' ? 'map' : 'map-mobile';
	
	map = new google.maps.Map(document.getElementById(id), {
		center: myLatLng,
		zoom: 8
	});

	var markers = [];

	markers.push(new google.maps.Marker({
		position: myLatLng,
		map: map,
		title: 'Agririo'
		//icon: 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_yellow.png'
	}));
	
	$.ajax({url: '/ajax/places/', type: 'json'}).done(function (list) {
		
		$.each(JSON.parse(list), function () {
			markers.push(new google.maps.Marker({
				position: {lat: parseFloat(this.lat), lng: parseFloat(this.lng)},
				map: map,
				title: this.name,
				icon: 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_blue.png'
			}));
		})
	})
}


// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $(document).on('click', 'a.scrollTo', function(event) {
		var $anchor = $(this);
		var offset = $anchor.data('offset') ? $anchor.data('offset') : 0;
		var negative = $anchor.data('offset-negative');
		
		if(negative) offset = offset * (-1);
		
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 12
        }, 1500, 'easeInOutExpo');
		
		event.preventDefault();
    });
});



function check_cookie_law()
{
	if(typeof $.cookie('cookie-law-accepted') === 'undefined')
	{
		show_cookie_bar()
	}
	else
	{
		show_hidden_content_for_cookie_law()
	}

	$('#accept-cookie-statement').click(function (e) {
		e.preventDefault();

		hide_cookie_bar()
	})
}

function show_cookie_bar()
{
	$('#cookie-bar').removeClass('hide')
}

function hide_cookie_bar()
{
	$('#cookie-bar').addClass('hide');
	$.cookie('cookie-law-accepted', true, { expires: 7, path: '/' });

	show_hidden_content_for_cookie_law();
}

function show_hidden_content_for_cookie_law()
{
	if($('.cookie-law-confirmed-load').size() > 0)
	{
		$.each($('.cookie-law-confirmed-load'), function () { 
			$(this).append('<div id="fb-root"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];	  if (d.getElementById(id)) return;	  js = d.createElement(s); js.id = id;         js.async = true;	  js.src = "//connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.6&appId=167796693421670";	  fjs.parentNode.insertBefore(js, fjs);		}(document, "script", "facebook-jssdk"));</script><div class="fb-page" data-href="https://www.facebook.com/agririo/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" style="margin:auto"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/agririo/"><a href="https://www.facebook.com/agririo/">AgriRio</a></blockquote></div></div>');
		});
	}
}