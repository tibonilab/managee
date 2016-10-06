var FORM_submit = function (e) {

	e.preventDefault();

	var me = $(this);

	var call_params = {
		url		: me.prop('action'),
		data	: me.serialize(),
		method	: 'post'
	}

	var on_done = function (response) {
		var obj = $.parseJSON(response);

		me.find('.success').html('').fadeIn(0)
		me.find('.error').html('').fadeIn(0)
		me.find('.warning').html('').fadeIn(0)

		if(obj.status)
		{
			me.find('input.form-control').val('');
			me.find('textarea.form-control').val('');

			clearInterval(progress);
			$.removeCookie('counter')
		}

		me.find('.' + obj.selector).html(obj.msg).delay(3500).fadeOut(500)
	}


	$.ajax(call_params).done(on_done);

}

var DOM_ready = function () { 
	/*
	var DOM = $(document);
	
	
	
	DOM.find('form').submit(FORM_submit)

	$('a[data-toggle="popover"]').popover({html : true});


	if( ! $.cookie('counter')) {

		$.cookie('counter', Date.now())
	}
	*/
}

/*
var progress = setInterval(function () {
	var increment = (Date.now() - $.cookie('counter')) * (100/119000);

	increment = (increment >= 100) ? 100 : increment;

	$('.progress-bar').css('width', increment + '%')

	if(increment >= 60)
	{
		$('.progress-bar, .btn-primary').css('background', '#f90')					
	}
	if(increment >= 65)
	{
		$('.progress-bar, .btn-primary').css('background', '#f80')
		$('.btn-primary').val('Hurry up!!')
	}

	if(increment >= 70)
	{
		$('.progress-bar, .btn-primary').css('background', '#f70')
	}
	if(increment >= 75)
	{
		$('.progress-bar, .btn-primary').css('background', '#f60')
	}

	if(increment >= 80)
	{
		$('.progress-bar, .btn-primary').css('background', '#f50')
	}

	if(increment >= 85)
	{
		$('.progress-bar, .btn-primary').css('background', '#f40')
	}
	if(increment >= 90)
	{
		$('.progress-bar, .btn-primary').css('background', '#f30')
		$('.btn-primary').val('Do it, NOW!')
	}
	if(increment >= 95)
	{
		$('.progress-bar, .btn-primary').css('background', '#f00')
	}

	if(increment >=100 )
	{
		$('input.form-control').attr('disabled', true)
		$('form').attr('action', '');
		$('.btn-primary').val('Out of time! (maybe..)').click(function () {
			$.removeCookie('counter');
			location.reload();
		})

		clearInterval(progress)
	}


	var seconds = 119 - Math.floor(Date.now() / 1000 - $.cookie('counter') / 1000);

	var minutes = 0;

	while (seconds >=60) {
		seconds = seconds - 60;
		minutes = minutes + 1;
	}

	minutes = minutes >= 0 ? minutes : 0;
	seconds = seconds >= 0 ? seconds : 0;

	var remaining_text = (minutes > 0) ? minutes + '\' ' + seconds + '"' : seconds + '"';

	$('.remaining').html(remaining_text)

}, 100)
*/


$().ready(DOM_ready)