jQuery(document).ready(function($) {

	var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',');
	$('.number_count').each(function(){
		var num = $(this).data('number'),
			ID = $(this).attr('id');

		$('#' + ID).animateNumber({
			number : num,
			numberStep: comma_separator_number_step
		},5000);

	});
});

