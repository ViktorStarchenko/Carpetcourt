jQuery(document).ready(function() {
 	if(typeof cc_bx =="undefined") {
		var cc_bx = new Array();
	}
	
	function init_cc_bx_slider(sliderID,index) {		
		if (cc_obj == undefined) {
				cc_obj = '';
		}
		if (cc_video_playing == undefined) {
				cc_video_playing = '';
		}
		if (cc_interval == undefined) {
				cc_interval = '';
		}
			
		var array_ind=cc_bx.length;
			
			
		cc_bx[array_ind] = jQuery(".cc_slideshow_thumbs_"+sliderID+"").bxSlider({
			slideWidth: cc_obj.width_thumbs,
			minSlides: cc_obj.slideCount,
			maxSlides:cc_obj.slideCount,
			moveSlides: 1,
			auto: true, 
			pause: +cc_obj.pauseTime,
			pager: false,
			controls: false,
			mode: 'horizontal',
			infiniteLoop:true,
			speed: +cc_obj.speed
		});

		///on hover on slider stop both slider and thumbnail slider 
		jQuery("ul[class^='cc_slider_"+sliderID+"']").hover(function(){
			cc_bx[array_ind].stopAuto();
		},function(){
			cc_bx[array_ind].startAuto();
		});

		//on hovering thumbnail slider stop both
		jQuery("ul[class^='cc_slideshow_thumbs_"+sliderID+"']").hover(function(){
			window.clearInterval(cc_interval['cc_playInterval_'+sliderID]);
			cc_bx[array_ind].stopAuto();
		},function(){
		//var interval = cc_playInterval_1;
		window.clearInterval(cc_interval['cc_playInterval_'+sliderID]);
			//cc_play['function play_'+sliderID](); 
			eval('play_'+sliderID+'()')
			cc_bx[array_ind].startAuto();
		});


		jQuery(".cc_slideshow_thumbs_"+sliderID).find('li').on('click',function(){
			window.clearInterval(cc_interval['cc_playInterval_'+sliderID]);
			//jQuery(this).parent().unbind();
			cc_bx[array_ind].stopAuto();
		});

		jQuery(".cc_slideshow_thumbs_container_"+sliderID).find("a[class^='bx-']").on('click',function(){
			window.clearInterval(cc_interval['cc_playInterval_'+sliderID]);
			//jQuery("ul[class^='cc_slideshow_thumbs_"+sliderID+"']").unbind();
			cc_bx[array_ind].stopAuto();
		});

		jQuery("#cc_slideshow_left_"+sliderID).on('click',function(){
			cc_bx[array_ind].goToPrevSlide();

			cc_bx[array_ind].stopAuto();
			restart=setTimeout(function(){
				cc_bx[array_ind].startAuto();
				},+cc_obj.speed)
		});

		jQuery("#cc_slideshow_right_"+sliderID).on('click',function(){
			cc_bx[array_ind].goToNextSlide();
			cc_bx[array_ind].stopAuto();
			restart=setTimeout(function(){
				cc_bx[array_ind].startAuto();
				},+cc_obj.speed)
	  	});


 		if ( cc_video_playing['video_is_playing_'+sliderID] == true ) {
			cc_bx[array_ind].stopAuto();
		} else if ( cc_video_playing['video_is_playing_'+sliderID] == false ) {
			cc_bx[array_ind].startAuto();
		}

		if ( jQuery('#cc_loading_image_'+sliderID).css('display')=='table-cell' ) {
			cc_bx[array_ind].stopAuto();
		} else if( jQuery('#cc_loading_image_'+sliderID).css('display')=='none' ) {
			cc_bx[array_ind].startAuto();
		}
		
	}

	if(typeof sliderID_array !== "undefined"){
		jQuery.each(sliderID_array,function(ind,val){
			var sliderID=val;
			init_cc_bx_slider(val,ind);
		});
	}
		
	//}			

});