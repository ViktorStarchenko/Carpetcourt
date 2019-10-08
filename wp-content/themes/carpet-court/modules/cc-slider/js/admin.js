jQuery(document).ready(function () {
	jQuery('#arrows-type input[name="params[slider_navigation_type]"]').change(function(){
		jQuery(this).parents('ul').find('li.active').removeClass('active');
		jQuery(this).parents('li').addClass('active');
	});
	jQuery('#slider-loading-icon li').click(function(){ 
		jQuery(this).parents('ul').find('li.act').removeClass('act');
		jQuery(this).addClass('act');
	});	
	/*jQuery('.slider-options .save-slider-options').click(function(){
		alert("General Settings are disabled in free version. If you need those functionalityes, you need to buy the commercial version.");
	});*/	
		
	jQuery('input[data-slider="true"]').bind("slider:changed", function (event, data) {
		 jQuery(this).parent().find('span').html(parseInt(data.value)+"%");
		 jQuery(this).val(parseInt(data.value));
	});
		
	jQuery('.help').hover(function(){
           jQuery(this).parent().find('.help-block').removeClass('active');
           var width=jQuery(this).parent().find('.help-block').outerWidth();
            jQuery(this).parent().find('.help-block').addClass('active').css({'left':-((width /2)-10)});
        },function() {
			jQuery(this).parent().find('.help-block').removeClass('active');
	});
	
});

// sorting slider list
  jQuery(function() {
    jQuery( "#images-list" ).sortable({
      stop: function() {
			jQuery("#images-list li").removeClass('has-background');
			count=jQuery("#images-list li").length;
			for(var i=0;i<=count;i+=2){
					jQuery("#images-list li").eq(i).addClass("has-background");
			}
			jQuery("#images-list li").each(function(){
				jQuery(this).find('.order_by').val(jQuery(this).index());
			});
      },
      revert: true
    });
   // jQuery( "ul, li" ).disableSelection();
   
	// if overlay is disable the overlay color and image will be disable
	jQuery('#sl_overlay').on('change',function() {
		if(  jQuery(this).is(":checked") ) {
			$('#sl_overlay_color').removeAttr('disabled');
			$('#sl_overlay_image').removeAttr('disabled');
			$('#upload-btn').removeAttr('disabled');
		} else {
			$('#sl_overlay_color').attr('disabled','disabled');
			$('#sl_overlay_image').attr('disabled','disabled');
			$('#upload-btn').attr('disabled','disabled');
		}
	});

	jQuery('#sl_is_mobile').on('change',function() {
		if(  jQuery(this).is(":checked") ) {
			jQuery('#sl_mobile_text').removeAttr('disabled');
			jQuery('#sl_mobile_image').removeAttr('disabled');
			jQuery('#mobile-upload-btn').removeAttr('disabled');
		} else {
			jQuery('#sl_mobile_text').attr('disabled','disabled');
			jQuery('#sl_mobile_image').attr('disabled','disabled');
			jQuery('#mobile-upload-btn').attr('disabled','disabled');
		}
	});

  });