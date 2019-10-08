<?php

function front_end_slider($images, $paramssld, $slider)
{
 ob_start();
 if(isset($slider)) {

	$sliderID            = $slider[0]->id;
	$slidertitle         = $slider[0]->name;
	$sliderheight        = $slider[0]->sl_height;
	$sliderwidth         = $slider[0]->sl_width;
	$sliderfullwidth     = $slider[0]->width_full_width;
	$slidereffect        = $slider[0]->slider_list_effects_s;
	$slidepausetime      = ($slider[0]->description+$slider[0]->param);
	$sliderpauseonhover  = $slider[0]->pause_on_hover;
	$sliderposition      = $slider[0]->sl_position;
	$slidechangespeed    = $slider[0]->param;
	$sliderloadingicon   = $slider[0]->sl_loading_icon;
	$sliderthumbslider   = $slider[0]->show_thumb;

	// mobile
	$slider_is_mobile        = $slider[0]->sl_is_mobile;
	$slider_mobile_text      = $slider[0]->sl_mobile_text;
	$slider_mobile_image     = $slider[0]->sl_mobile_image;

	$slideshow_title_position = explode('-', trim($paramssld['slider_title_position']));
	$slideshow_description_position = explode('-', trim($paramssld['slider_description_position']));
 }
	$hasyoutube=false;
	$hasvimeo=false;
	foreach ($images as $key => $image_row) {
		if(strpos($image_row->image_url,'youtube') !== false || strpos($image_row->image_url,'youtu.be') !== false){$hasyoutube=true;}
		if(strpos($image_row->image_url,'vimeo') !== false){$hasvimeo=true;}
	}

$GLOBALS['pause_time']=$slidepausetime;
$GLOBALS['thumbnail_width']=$sliderwidth;
$GLOBALS['changespeed']=$slider[0]->param;

?>
<script>
	var cc_video_playing={};
	var autoplayMatch={};
</script>


<?php if ( $hasvimeo == true ) { ?>
	<script src="<?php echo get_stylesheet_directory_uri(). '/modules/cc-slider/js/vimeo.lib.js'; ?>"></script>
	<script src="https://f.vimeocdn.com/js/froogaloop2.min.js "></script>
	<script>
		jQuery(function(){
			var vimeoPlayer = document.querySelector('iframe'),
				volumes = [],
				colors = [],
				i=0;
			<?php
				$i=0;
				//$vimeoparams=array_reverse($images);
				foreach ($images as $key => $image_row) {
					if($image_row->sl_type=="video" && strpos($image_row->image_url,'vimeo') !== false) {
			?>
						volumes[<?php echo $i; ?>] = '<?php echo intval($image_row->description)/100; ?>';
						colors[<?php echo $i; ?>] = '<?php echo $image_row->link_target; ?>';
			<?php
						$i++;
					} // end if
				}
			?>

			jQuery('iframe').each(function(){
				Froogaloop(this).addEvent('ready', ready);
			});

			jQuery(".sidedock,.controls").remove();

			function ready(player_id) {

				froogaloop = $f(player_id);

				function setupEventListeners() {

					function setVideoVolume(player_id,value) {
						Froogaloop(player_id).api('setVolume',value);
					}
					function setVideoColor(player_id,value) {
						Froogaloop(player_id).api('setColor',value);
					}
					function onPlay() {
						froogaloop.addEvent('play',
						function(){
							cc_video_playing['video_is_playing_'+<?php echo $sliderID; ?>]=true;
						});
					}
					function onPause() {
						froogaloop.addEvent('pause',
						function(){
							cc_video_playing['video_is_playing_'+<?php echo $sliderID; ?>]=false;
						});
					}
					function stopVimeoVideo(player){
						Froogaloop(player).api('pause');
					}
					setVideoVolume(player_id,volumes[i]);
					setVideoColor(player_id,colors[i]);
					i++;

					onPlay();
					onPause();
					jQuery('#cc_slideshow_left_<?php echo $sliderID; ?>, #cc_slideshow_right_<?php echo $sliderID; ?>,.cc_slideshow_dots_<?php echo $sliderID; ?>').click(function(){
						stopVimeoVideo(player_id);
					});
				}
				setupEventListeners();
			}
		});
	</script>
<?php } ?>

<?php if ( $hasyoutube == true) { ?>

<!-- <script src="<?php echo get_stylesheet_directory_uri(). '/modules/cc-slider/js/youtube.lib.js'; ?>"></script> -->
<script>
  	<?php
	  	function get_youtube_id_from_url($url) {
		  	if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) {
		  		return $match[1];
		  	}
		 }

	$i=0;
		foreach ($images as $key => $image_row ) {
				if ( $image_row->sl_type == "video" && strpos( $image_row->image_url, 'youtu' ) !== false ) {
  	?>
				var player_<?php echo $image_row->id; ?>;
	<?php
				}
			continue;
			$i++;
		}
	?>
		cc_video_playing['video_is_playing_'+<?php echo $sliderID; ?>]=false;
		function onYouTubeIframeAPIReady() {
			<?php foreach ( $images as $key => $image_row ) {
						if( $image_row->sl_type =="video" && strpos( $image_row->image_url, 'youtube' ) !== false ) { ?>
							player_<?php echo $image_row->id; ?> = new YT.Player('video_id_<?php echo $sliderID . "_" . $key;?>', {
							  height: '<?php echo $sliderheight; ?>',
							  width: '<?php echo $sliderwidth; ?>',
							  videoId: '<?php echo get_youtube_id_from_url($image_row->image_url); ?>',
							  playerVars: {
								'controls':  1,
								'showinfo': 1,
								'rel':0
							  },
							  events: {
								'onReady': onPlayerReady_<?php echo $image_row->id; ?>,
								'onStateChange': onPlayerStateChange_<?php echo $image_row->id; ?>,
								'loop':1
							  }
							});
			<?php } /*if ends*/ continue; } /*endforeach*/ ?>
		}


<?php
	foreach ($images as $key => $image_row) {
		if ( $image_row->sl_type =="video" && strpos( $image_row->image_url, 'youtu' ) !== false ) {
?>
		  function onPlayerReady_<?php echo $image_row->id; ?>(event) {
			 player_<?php echo $image_row->id; ?>.setVolume(<?php echo $images[$key]->description; ?>);
		  }

		  function onPlayerStateChange_<?php echo $image_row->id; ?>(event) {
			if (event.data == YT.PlayerState.PLAYING) {
				event.target.setPlaybackQuality('<?php echo $images[$key]->name; ?>');
				cc_video_playing['video_is_playing_'+<?php echo $sliderID; ?>]=true;

			} else if(event.data == YT.PlayerState.PAUSED){
				cc_video_playing['video_is_playing_'+<?php echo $sliderID; ?>]=false;

			}
		  }

<?php } /*if ends*/ continue; } /*endforeach*/ ?>

	function stopYoutubeVideo() {
		<?php
		$i=0;
		foreach ($images as $key => $image_row) {
			if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){
		?>
			player_<?php echo $image_row->id; ?>.pauseVideo();
		<?php
			}
			continue;
				$i++;
			}
		?>
	}
</script>
<?php } ?>

<script>
	jQuery(document).ready(function($) {
		  $('.thumb_wrapper').on('click', function(ev) {

		  	var ccid = $(this).data('rowid'),
		  		myid = ccid;

		  		myid = parseInt(myid);
			  	eval('player_'+myid+'.playVideo()')
			   	ev.preventDefault();
		  });
	});

	if(typeof sliderID_array == "undefined"){
		var sliderID_array=[];
	}

	var data_<?php echo $sliderID; ?> = [];
	var event_stack_<?php echo $sliderID; ?> = [];
	cc_video_playing['video_is_playing_'+<?php echo $sliderID; ?>] = false;

	<?php
                $args = array(
                'numberposts' => 10,
                'offset' => 0,
                'category' => 0,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post_type' => 'post',
                'post_status' => 'draft, publish, future, pending, private',
                'suppress_filters' => true );
		$recent_posts = wp_get_recent_posts( $args, ARRAY_A );

		$i=0;

		foreach($images as $image){
			  	$imagerowstype=$image->sl_type;
				if($image->sl_type == ''){
				$imagerowstype='image';
				}
				switch($imagerowstype){

					case 'image':
						echo 'data_'.$sliderID.'["'.$i.'"]=[];';
						echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
						echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$image->image_url.'";';


						$strdesription=str_replace('"',"'",$image->description);
						$strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
						echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';


						$stralt=str_replace('"',"'",$image->name);
						$stralt=preg_replace( "/\r|\n/", " ", $stralt );
						echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
						$i++;
					break;

					case 'video':
						echo 'data_'.$sliderID.'["'.$i.'"]=[];';
						echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
						echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$image->image_url.'";';


						$strdesription=str_replace('"',"'",$image->description);
						$strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
						echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';


						$stralt=str_replace('"',"'",$image->name);
						$stralt=preg_replace( "/\r|\n/", " ", $stralt );
						echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
						$i++;
					break;

					case 'last_posts':
                        $keyForStoping = 0;
						foreach($recent_posts as $keyl => $recentimage){
                            if($image->name == "0"){
                                if(get_the_post_thumbnail($recentimage["ID"], 'thumbnail') != ''){
                                        if($keyl < $image->sl_url){
                                            echo 'data_'.$sliderID.'["'.$i.'"]=[];';
                                            echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
                                            echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$recentimage['guid'].'";';


                                            $strdesription=str_replace('"',"'",$recentimage['post_content']);
                                            $strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
                                            $strdesription=substr_replace($strdesription, "",$image->description);
                                            echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';


                                            $stralt=str_replace('"',"'",$recentimage['post_title']);
                                            $stralt=preg_replace( "/\r|\n/", " ", $stralt );
                                            echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
                                            $i++;
                                        }
                                    }
                            }
                            else{
                                $category_id = get_cat_ID($image->name);                            //       USER CHOOSED CATEGORY
                                $category_id_from_posts = wp_get_post_categories($recentimage['ID']);    //       GETTING ALL CATEGORIES FOR THIS POST
                                if($keyForStoping < $image->sl_url){
                                    if (in_array($category_id, $category_id_from_posts)){
                                        if(get_the_post_thumbnail($recentimage["ID"], 'thumbnail') != ''){
                                            $keyForStoping++;
                                                echo 'data_'.$sliderID.'["'.$i.'"]=[];';
                                                echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
                                                echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$recentimage['guid'].'";';


                                                $strdesription=str_replace('"',"'",$recentimage['post_content']);
                                                $strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
                                                $strdesription=substr_replace($strdesription, "",$image->description);
                                                echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';


                                                $stralt=str_replace('"',"'",$recentimage['post_title']);
                                                $stralt=preg_replace( "/\r|\n/", " ", $stralt );
                                                echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
                                                $i++;
                                        }
                                    }
                                }
                            }

						}
					break;
				}
		}
	?>



      var cc_trans_in_progress_<?php echo $sliderID; ?> = false;
      var cc_transition_duration_<?php echo $sliderID; ?> = <?php echo $slidechangespeed;?>;
      var cc_interval ={};
      var id_array_index=sliderID_array.length

	  <?php
	  		$cc_sliderId='';
	  		if(isset($cc_sliderId)){
	  		$cc_sliderId=$cc_sliderId;
		  	}else{
		  		$cc_sliderId='';
		  	}
		  	if($cc_sliderId==';'){
		  		$cc_sliderId='';
		  	}
	  if($slider[0]->show_thumb =='thumbnails'){
	  		$cc_sliderId=$slider[0]->id;
	  	}

	  	?>


	  var ifhasthumb ="<?php echo $sliderthumbslider; ?>";
	  sliderID_array[id_array_index] = <?php echo $cc_sliderId; ?>
      // Stop autoplay.
      window.clearInterval(cc_interval['cc_playInterval_'+<?php echo $sliderID; ?>]);

     var cc_current_key_<?php echo $sliderID; ?> = '<?php echo (isset($current_key) ? $current_key : ''); ?>';
	 function cc_move_dots_<?php echo $sliderID; ?>() {
        var image_left = jQuery(".cc_slideshow_dots_active_<?php echo $sliderID; ?>").position().left;
        var image_right = jQuery(".cc_slideshow_dots_active_<?php echo $sliderID; ?>").position().left + jQuery(".cc_slideshow_dots_active_<?php echo $sliderID; ?>").outerWidth(true);

      }
      function cc_testBrowser_cssTransitions_<?php echo $sliderID; ?>() {
        return cc_testDom_<?php echo $sliderID; ?>('Transition');
      }
      function cc_testBrowser_cssTransforms3d_<?php echo $sliderID; ?>() {
        return cc_testDom_<?php echo $sliderID; ?>('Perspective');
      }
      function cc_testDom_<?php echo $sliderID; ?>(prop) {
        // Browser vendor CSS prefixes.
        var browserVendors = ['', '-webkit-', '-moz-', '-ms-', '-o-', '-khtml-'];
        // Browser vendor DOM prefixes.
        var domPrefixes = ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'];
        var i = domPrefixes.length;
        while (i--) {
          if (typeof document.body.style[domPrefixes[i] + prop] !== 'undefined') {
            return true;
          }
        }
        return false;
      }
		function cc_cube_<?php echo $sliderID; ?>(tz, ntx, nty, nrx, nry, wrx, wry, current_image_class, next_image_class, direction) {

        /* If browser does not support 3d transforms/CSS transitions.*/

        if ( !cc_testBrowser_cssTransitions_<?php echo $sliderID; ?>() ) {

			jQuery(".cc_slideshow_dots_<?php echo $sliderID; ?>")
				.removeClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>")
				.addClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>");

        	jQuery("#cc_dots_" + cc_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>")
        		.removeClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>")
        		.addClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>");

          	return cc_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
        }

        if ( !cc_testBrowser_cssTransforms3d_<?php echo $sliderID; ?>() ) {

         	return cc_fallback3d_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
        }

		jQuery(current_image_class).css({'z-index': 'none'});

        jQuery(next_image_class).css({'z-index' : 2});

        cc_trans_in_progress_<?php echo $sliderID; ?> = true;

        /* Set active thumbnail.*/
		jQuery(".cc_slideshow_dots_<?php echo $sliderID; ?>")
			.removeClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>")
			.addClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>");

		jQuery("#cc_dots_" + cc_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>")
			.removeClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>")
			.addClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>");

        jQuery(".cc_slide_bg_<?php echo $sliderID; ?>").css('perspective', 1000);

        jQuery(current_image_class).css({
	        transform : 'translateZ(' + tz + 'px)',
	        backfaceVisibility : 'hidden'
        });

		jQuery(".cc_slideshow_image_wrap_<?php echo $sliderID; ?>,.cc_slide_bg_<?php echo $sliderID; ?>,.cc_slideshow_image_item_<?php echo $sliderID; ?>,.cc_slideshow_image_second_item_<?php echo $sliderID; ?> ").css('overflow', 'visible');

		jQuery(next_image_class).css({
			opacity : 1,
			filter: 'Alpha(opacity=100)',
			backfaceVisibility : 'hidden',
			transform : 'translateY(' + nty + 'px) translateX(' + ntx + 'px) rotateY('+ nry +'deg) rotateX('+ nrx +'deg)'
		});

        jQuery(".cc_slider_<?php echo $sliderID; ?>").css({
		    transform: 'translateZ(-' + tz + 'px)',
		    transformStyle: 'preserve-3d'
        });

        /* Execution steps.*/
        setTimeout(function () {

			jQuery(".cc_slider_<?php echo $sliderID; ?>").css({
				transition: 'all ' + cc_transition_duration_<?php echo $sliderID; ?> + 'ms ease-in-out',
				transform: 'translateZ(-' + tz + 'px) rotateX('+ wrx +'deg) rotateY('+ wry +'deg)'
			});

        }, 20);

        /* After transition.*/
        jQuery(".cc_slider_<?php echo $sliderID; ?>") .one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(cc_after_trans));

        function cc_after_trans() {

		  jQuery(".cc_slide_bg_<?php echo $sliderID; ?>,.cc_slideshow_image_item_<?php echo $sliderID; ?>,.cc_slideshow_image_second_item_<?php echo $sliderID; ?> ").css('overflow', 'hidden');

		  jQuery(".cc_slide_bg_<?php echo $sliderID; ?>").removeAttr('style');

          jQuery(current_image_class).removeAttr('style');

          jQuery(next_image_class).removeAttr('style');

          jQuery(".cc_slider_<?php echo $sliderID; ?>").removeAttr('style');

          jQuery(current_image_class).css({
          									'opacity' : 0,
          									 filter: 'Alpha(opacity=0)',
          									 'z-index': 1
      									});

          jQuery(next_image_class).css({
      										'opacity' : 1,
      										 filter: 'Alpha(opacity=1	0)',
      										 'z-index' : 2
  										});

          cc_trans_in_progress_<?php echo $sliderID; ?> = false;

          if ( typeof event_stack_<?php echo $sliderID; ?> !== 'undefined' && event_stack_<?php echo $sliderID; ?>.length > 0) {

            key = event_stack_<?php echo $sliderID; ?>[0].split("-");
            event_stack_<?php echo $sliderID; ?>.shift();
            cc_change_image_<?php echo $sliderID; ?>(key[0], key[1], data_<?php echo $sliderID; ?>, true, false );

          }

        }
      }


      function cc_cubeH_<?php echo $sliderID; ?>( current_image_class, next_image_class, direction ) {
			/* Set to half of image width.*/
			var dimension = jQuery(current_image_class).width() / 2;
			if ( direction == 'right' ) {
			  cc_cube_<?php echo $sliderID; ?>( dimension, dimension, 0, 0, 90, 0, -90, current_image_class, next_image_class, direction );
			} else if ( direction == 'left' ) {
			  cc_cube_<?php echo $sliderID; ?>( dimension, -dimension, 0, 0, -90, 0, 90, current_image_class, next_image_class, direction );
			}
      }

      function cc_cubeV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
	        /* Set to half of image height.*/
	        var dimension = jQuery(current_image_class).height() / 2;
	        /* If next slide.*/
	        if ( direction == 'right' ) {
	          cc_cube_<?php echo $sliderID; ?>(dimension, 0, -dimension, 90, 0, -90, 0, current_image_class, next_image_class, direction);
	        } else if ( direction == 'left' ) {
	          cc_cube_<?php echo $sliderID; ?>(dimension, 0, dimension, -90, 0, 90, 0, current_image_class, next_image_class, direction);
	        }
      }

      /* For browsers that does not support transitions.*/
      function cc_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        cc_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
      }

      /* For browsers that support transitions, but not 3d transforms (only used if primary transition makes use of 3d-transforms).*/
      function cc_fallback3d_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        cc_sliceV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
      }

      function cc_none_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
        jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});

        /* Set active thumbnail.*/
        jQuery(".cc_slideshow_dots_<?php echo $sliderID; ?>").removeClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#cc_dots_" + cc_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>");
      }

      function cc_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
		if (cc_testBrowser_cssTransitions_<?php echo $sliderID; ?>()) {

          jQuery(next_image_class).css('transition', 'opacity ' + cc_transition_duration_<?php echo $sliderID; ?> + 'ms linear');
		  jQuery(current_image_class).css('transition', 'opacity ' + cc_transition_duration_<?php echo $sliderID; ?> + 'ms linear');
          jQuery(current_image_class).css({
								          	'opacity' : 0,
								           'z-index': 1
								       });
          jQuery(next_image_class).css({
											'opacity' : 1,
											'z-index' : 2
								       	});
        } else {

			    jQuery(current_image_class).animate({
			  											'opacity' : 0,
			  										 	'z-index' : 1
			   										}, cc_transition_duration_<?php echo $sliderID; ?>);

			    jQuery(next_image_class).animate({
										              'opacity' : 1,
										              'z-index': 2
										            }, {
											              duration: cc_transition_duration_<?php echo $sliderID; ?>,
											              complete: function () {return false;}
											            });
			      // For IE.
		      	jQuery(current_image_class).fadeTo(cc_transition_duration_<?php echo $sliderID; ?>, 0);
		      	jQuery(next_image_class).fadeTo(cc_transition_duration_<?php echo $sliderID; ?>, 1);
        }

		jQuery(".cc_slideshow_dots_<?php echo $sliderID; ?>")
				.removeClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>")
				.addClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>");

		jQuery("#cc_dots_" + cc_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>")
				.removeClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>")
				.addClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>");

      }

      function cc_grid_<?php echo $sliderID; ?>(cols, rows, ro, tx, ty, sc, op, current_image_class, next_image_class, direction) {
        /* If browser does not support CSS transitions.*/
        if ( !cc_testBrowser_cssTransitions_<?php echo $sliderID; ?>() ) {

			jQuery(".cc_slideshow_dots_<?php echo $sliderID; ?>")
				.removeClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>")
				.addClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>");

        	jQuery("#cc_dots_" + cc_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>")
        		.removeClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>")
        		.addClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>");

          	return cc_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);

        }
        cc_trans_in_progress_<?php echo $sliderID; ?> = true;

        /* Set active thumbnail.*/
		jQuery(".cc_slideshow_dots_<?php echo $sliderID; ?>")
			.removeClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>")
			.addClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>");

        jQuery("#cc_dots_" + cc_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>")
	        .removeClass("cc_slideshow_dots_deactive_<?php echo $sliderID; ?>")
	        .addClass("cc_slideshow_dots_active_<?php echo $sliderID; ?>");

        /* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
        var count = (cc_transition_duration_<?php echo $sliderID; ?>) / (cols + rows);

        /* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/

        function cc_gridlet(width, height, top, img_top, left, img_left, src, imgWidth, imgHeight, c, r) {

          var delay = (c + r) * count;

          /* Return a gridlet elem with styles for specific transition.*/
          return jQuery('<div class="cc_gridlet_<?php echo $sliderID; ?>" />').css({
		            width : width,
		            height : height,
		            top : top,
		            left : left,
		            backgroundImage : 'url("' + src + '")',
		            backgroundColor: jQuery(".cc_slideshow_image_wrap_<?php echo $sliderID; ?>").css("background-color"),
		            /*backgroundColor: rgba(0, 0, 0, 0),*/
		            backgroundRepeat: 'no-repeat',
		            backgroundPosition : img_left + 'px ' + img_top + 'px',
		            backgroundSize : imgWidth + 'px ' + imgHeight + 'px',
		            transition : 'all ' + cc_transition_duration_<?php echo $sliderID; ?> + 'ms ease-in-out ' + delay + 'ms',
		            transform : 'none'
		          });
        }


        /* Get the current slide's image.*/
        var cur_img = jQuery(current_image_class).find('img');

        /* Create a grid to hold the gridlets.*/
        var grid = jQuery('<div />').addClass('cc_grid_<?php echo $sliderID; ?>');

        /* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
        jQuery(current_image_class).prepend(grid);

        /* vars to calculate positioning/size of gridlets*/
        var cont = jQuery(".cc_slide_bg_<?php echo $sliderID; ?>"),
        	imgWidth = cur_img.width(),
        	imgHeight = cur_img.height(),
        	contWidth = cont.width(),
            contHeight = cont.height(),
            imgSrc = cur_img.attr('src'), /*.replace('/thumb', ''),*/
            colWidth = Math.floor(contWidth / cols),
            rowHeight = Math.floor(contHeight / rows),
            colRemainder = contWidth - (cols * colWidth),
            colAdd = Math.ceil(colRemainder / cols),
            rowRemainder = contHeight - (rows * rowHeight),
            rowAdd = Math.ceil(rowRemainder / rows),
            leftDist = 0,
            img_leftDist = (jQuery(".cc_slide_bg_<?php echo $sliderID; ?>").width() - cur_img.width()) / 2;

        /* tx/ty args can be passed as 'auto'/'min-auto' (meaning use slide width/height or negative slide width/height).*/
        tx = tx === 'auto' ? contWidth : tx;
        tx = tx === 'min-auto' ? - contWidth : tx;
        ty = ty === 'auto' ? contHeight : ty;
        ty = ty === 'min-auto' ? - contHeight : ty;

        /* Loop through cols*/
        for (var i = 0; i < cols; i++) {
	          var topDist = 0,
	              img_topDst = (jQuery(".cc_slide_bg_<?php echo $sliderID; ?>").height() - cur_img.height()) / 2,
	              newColWidth = colWidth;

	          /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
	          if (colRemainder > 0) {
	            var add = colRemainder >= colAdd ? colAdd : colRemainder;
	            newColWidth += add;
	            colRemainder -= add;
	          }

	          /* Nested loop to create row gridlets for each col.*/
	          for (var j = 0; j < rows; j++)  {

		            var newRowHeight = rowHeight,
		                newRowRemainder = rowRemainder;

		            /* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
		            if (newRowRemainder > 0) {
		              add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
		              newRowHeight += add;
		              newRowRemainder -= add;
		            }

		            /* Create & append gridlet to grid.*/
		            grid.append(cc_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgWidth, imgHeight, i, j));
		            topDist += newRowHeight;
		            img_topDst -= newRowHeight;
	          }

	          img_leftDist -= newColWidth;
	          leftDist += newColWidth;
        }

        /* Set event listener on last gridlet to finish transitioning.*/
        var last_gridlet = grid.children().last();

        /* Show grid & hide the image it replaces.*/
        grid.show();
        cur_img.css('opacity', 0);

        /* Add identifying classes to corner gridlets (useful if applying border radius).*/
        grid.children().first().addClass('rs-top-left');
        grid.children().last().addClass('rs-bottom-right');
        grid.children().eq(rows - 1).addClass('rs-bottom-left');
        grid.children().eq(- rows).addClass('rs-top-right');

        /* Execution steps.*/
        setTimeout(function () {
					          grid.children().css({
					            opacity: op,
					            transform: 'rotate('+ ro +'deg) translateX('+ tx +'px) translateY('+ ty +'px) scale('+ sc +')'
					          });
					        }, 1);

        jQuery(next_image_class).css('opacity', 1);

        /* After transition.*/
        jQuery(last_gridlet).one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(cc_after_trans));

        function cc_after_trans() {
          jQuery(current_image_class).css({
  											'opacity' : 0,
          									'z-index': 1
          								});

          jQuery(next_image_class).css({
  											'opacity' : 1,
          									'z-index' : 2
          								});

          cur_img.css('opacity', 1);

          grid.remove();
          cc_trans_in_progress_<?php echo $sliderID; ?> = false;

          if ( typeof event_stack_<?php echo $sliderID; ?> !== 'undefined' && event_stack_<?php echo $sliderID; ?>.length > 0 ) {
            key = event_stack_<?php echo $sliderID; ?>[0].split("-");
            event_stack_<?php echo $sliderID; ?>.shift();
            cc_change_image_<?php echo $sliderID; ?>(key[0], key[1], data_<?php echo $sliderID; ?>, true,false);
          }

        }

      }


      function cc_sliceH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {

	        var translateX = '';
	        if (direction == 'right') {
	        	translateX = 'min-auto';
	        } else if (direction == 'left') {
	        	translateX = 'auto';
	        }
	        cc_grid_<?php echo $sliderID; ?>(1, 8, 0, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
      }

      function cc_sliceV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {

	        var translateY = '';
	        if (direction == 'right') {
	        	translateY = 'min-auto';
	        }
	        else if (direction == 'left') {
	        	translateY = 'auto';
	        }
	        cc_grid_<?php echo $sliderID; ?>(10, 1, 0, 0, translateY, 1, 0, current_image_class, next_image_class, direction);
      }

      function cc_slideV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {

        	var translateY = '';
	        if (direction == 'right') {
	        	translateY = 'auto';
	        }
	        else if (direction == 'left') {
	        	translateY = 'min-auto';
	        }
	        cc_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, translateY, 1, 1, current_image_class, next_image_class, direction);
      }

      function cc_slideH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {

	        var translateX = '';
	        if (direction == 'right') {
	          	translateX = 'min-auto';
	        }
	        else if (direction == 'left') {
	          	translateX = 'auto';
	        }
	        cc_grid_<?php echo $sliderID; ?>(1, 1, 0, translateX, 0, 1, 1, current_image_class, next_image_class, direction);
      }


      function cc_scaleOut_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        cc_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, 0, 1.5, 0, current_image_class, next_image_class, direction);
      }

      function cc_scaleIn_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        cc_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, 0, 0.5, 0, current_image_class, next_image_class, direction);
      }

      function cc_blockScale_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        cc_grid_<?php echo $sliderID; ?>(8, 6, 0, 0, 0, .6, 0, current_image_class, next_image_class, direction);
      }

      function cc_kaleidoscope_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        cc_grid_<?php echo $sliderID; ?>(10, 8, 0, 0, 0, 1, 0, current_image_class, next_image_class, direction);
      }

      function cc_fan_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
	        var rotate = '',
	        	translateX = '';

	        if (direction == 'right') {
	          	rotate = 45;
	          	translateX = 100;
	        }
	        else if (direction == 'left') {
	          	rotate = -45;
	          	translateX = -100;
	        }

        	cc_grid_<?php echo $sliderID; ?>(1, 10, rotate, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
      }

      function cc_blindV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        cc_grid_<?php echo $sliderID; ?>(1, 8, 0, 0, 0, .7, 0, current_image_class, next_image_class);
      }

      function cc_blindH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        cc_grid_<?php echo $sliderID; ?>(10, 1, 0, 0, 0, .7, 0, current_image_class, next_image_class);
      }

      function cc_random_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {

        var anims = [
	    				'sliceH',
	    				'sliceV',
	    				'slideH',
	    				'slideV',
	    				'scaleOut',
	    				'scaleIn',
	    				'blockScale',
	    				'kaleidoscope',
	    				'fan',
	    				'blindH',
	    				'blindV'
	    			];

        /* Pick a random transition from the anims array.*/
        this["cc_" + anims[Math.floor(Math.random() * anims.length)] + "_<?php echo $sliderID; ?>"](current_image_class, next_image_class, direction);

      }

  	function iterator_<?php echo $sliderID; ?>() {
        return 1;
    }

     function cc_change_image_<?php echo $sliderID; ?>(current_key, key, data_<?php echo $sliderID; ?>, from_effect,clicked) {

        if ( data_<?php echo $sliderID; ?>[key] ) {

			if( cc_video_playing['video_is_playing_'+<?php echo $sliderID; ?>] && !clicked){
				return false;
			}

          if ( !from_effect ) {
	            // Change image key.
	            jQuery("#cc_current_image_key_<?php echo $sliderID; ?>").val(key);
				current_key = jQuery(".cc_slideshow_dots_active_<?php echo $sliderID; ?>").attr("data-image_key");
          }

          if ( cc_trans_in_progress_<?php echo $sliderID; ?> ) {
	            event_stack_<?php echo $sliderID; ?>.push(current_key + '-' + key);
	            return;
          }

          var direction = 'right';
			if ( cc_current_key_<?php echo $sliderID; ?> > key ) {
				direction = 'left';
			} else if ( cc_current_key_<?php echo $sliderID; ?> == key ) {
				return false;
			}

          // Set active thumbnail position.

          cc_current_key_<?php echo $sliderID; ?> = key;
          //Change image id, title, description.
          jQuery("#cc_slideshow_image_<?php echo $sliderID; ?>").attr('data-image_id', data_<?php echo $sliderID; ?>[key]["id"]);


		  jQuery(".cc_slideshow_title_text_<?php echo $sliderID; ?>").html(data_<?php echo $sliderID; ?>[key]["alt"]);
          jQuery(".cc_slideshow_description_text_<?php echo $sliderID; ?>").html(data_<?php echo $sliderID; ?>[key]["description"]);

		  var current_image_class = "#image_id_<?php echo $sliderID; ?>_" + data_<?php echo $sliderID; ?>[current_key]["id"];
          var next_image_class = "#image_id_<?php echo $sliderID; ?>_" + data_<?php echo $sliderID; ?>[key]["id"];



		 if(jQuery(current_image_class).find('.cc_video_frame_<?php echo $sliderID; ?>').length>0) {

				var streffect='<?php echo $slidereffect; ?>';
				if ( streffect == "cubeV" || streffect == "cubeH" || streffect == "none" || streffect == "fade" ){
					cc_<?php echo $slidereffect; ?>_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
				} else {
					cc_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
				}

		  }else{
				cc_<?php echo $slidereffect; ?>_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
		  }


		jQuery('.cc_slideshow_title_text_<?php echo $sliderID; ?>').removeClass('none');

		if( jQuery('.cc_slideshow_title_text_<?php echo $sliderID; ?>').html() == "" ) {
				jQuery('.cc_slideshow_title_text_<?php echo $sliderID; ?>').addClass('none');
			}

		jQuery('.cc_slideshow_description_text_<?php echo $sliderID; ?>').removeClass('none');

		if( jQuery('.cc_slideshow_description_text_<?php echo $sliderID; ?>').html() == "" ) {
			jQuery('.cc_slideshow_description_text_<?php echo $sliderID; ?>').addClass('none');
		}



		jQuery(current_image_class).find('.cc_slideshow_title_text_<?php echo $sliderID; ?>').addClass('none');
		jQuery(current_image_class).find('.cc_slideshow_description_text_<?php echo $sliderID; ?>').addClass('none');

		 cc_move_dots_<?php echo $sliderID; ?>();
		<?php foreach ( $images as $key => $image_row ) {
				if( $image_row->sl_type == "video" and strpos( $image_row->image_url, 'youtube' ) !== false ) {	?>
				stopYoutubeVideo();
		<?php } } ?>

		window.clearInterval(cc_interval['cc_playInterval_'+<?php echo $sliderID; ?>]);
		play_<?php echo $sliderID; ?>();

        }

      }

	  var staticthumbWidth;

      jQuery(window).load(function(){

      	staticthumbWidth=jQuery('#cc_thumb_slider>li').width();

      })

     function cc_popup_resize_<?php echo $sliderID; ?>() {

		var staticsliderwidth = <?php echo $sliderwidth;?>,
			sliderwidth = <?php echo $sliderwidth;?>,
			thumbWidth = jQuery(".cc_slideshow_thumbnails_<?php echo $sliderID; ?>").width(),
			bodyWidth = jQuery(window).width(),
        	parentWidth = jQuery(".cc_slideshow_image_wrap_<?php echo $sliderID; ?>").parent().width();

        <?php
        if( $sliderfullwidth == "on" ) {
        	?>
        	staticsliderwidth = sliderwidth = jQuery(window).width();
        	<?php
        }
        ?>


		//if responsive js late responsive.js @  take body size and not parent div
		jQuery(".cc_slideshow_thumbnails_<?php echo $sliderID; ?>").css({
																	height: <?php echo $paramssld['slider_thumb_height']; ?>
																});
		if( sliderwidth>parentWidth ) {
			sliderwidth=parentWidth;
		}

		if( sliderwidth>bodyWidth ) {
			sliderwidth=bodyWidth;
		}

		var str = ( <?php echo $sliderheight;?>/staticsliderwidth );


			jQuery(".cc_slideshow_thumbnails_<?php echo $sliderID; ?>").css({
																				width: thumbWidth
																			});

			var str2=(<?php echo $paramssld['slider_thumb_height']; ?>/staticthumbWidth);

			jQuery(".cc_slideshow_thumbnails_<?php echo $sliderID; ?>").css({
																				height: thumbWidth*str2
																			});
			jQuery(".bx-viewport").css({
											height: thumbWidth*str2
										});

		jQuery(".cc_slideshow_image_wrap_<?php echo $sliderID; ?>").css({
																			width: (sliderwidth)
																		});

		jQuery(".cc_slideshow_image_wrap_<?php echo $sliderID; ?>").css({
																			height: ((sliderwidth) * str)
																		});

		jQuery(".cc_slideshow_image_container_<?php echo $sliderID; ?>").css({
																			width: (sliderwidth)
																		});

		jQuery(".cc_slideshow_image_container_<?php echo $sliderID; ?>").css({
																			height: ((sliderwidth) * str)
																		});

		if( "<?php echo $slideshow_title_position[1]; ?>" == "middle" ) {
			var titlemargintopminus = jQuery(".cc_slideshow_title_text_<?php echo $sliderID; ?>").outerHeight()/2;
		}

		if( "<?php echo $slideshow_title_position[0]; ?>" == "center" ) {
			var titlemarginleftminus = jQuery(".cc_slideshow_title_text_<?php echo $sliderID; ?>").outerWidth()/2;
		}

		jQuery(".cc_slideshow_title_text_<?php echo $sliderID; ?>").css({
																			cssText: "margin-top:-" + titlemargintopminus + "px; margin-left:-"+titlemarginleftminus+"px;"
																		});

		if( "<?php echo $slideshow_description_position[1]; ?>" == "middle" ) {
			var descriptionmargintopminus = jQuery(".cc_slideshow_description_text_<?php echo $sliderID; ?>").outerHeight()/2;
		}

		if( "<?php echo $slideshow_description_position[0]; ?>" == "center" ) {
			var descriptionmarginleftminus = jQuery(".cc_slideshow_description_text_<?php echo $sliderID; ?>").outerWidth()/2;
		}

		jQuery(".cc_slideshow_description_text_<?php echo $sliderID; ?>").css({
																				cssText: "margin-top:-" + descriptionmargintopminus + "px; margin-left:-"+descriptionmarginleftminus+"px;"
																			});

        jQuery("#cc_loading_image_<?php echo $sliderID; ?>").css({
														        	display: "none"
														        });

        jQuery(".cc_slideshow_image_wrap1_<?php echo $sliderID; ?>").css({
														        	display: "block"
														        });

		jQuery(".cc_slideshow_image_wrap_<?php echo $sliderID; ?>").removeClass("nocolor");



		if("<?php echo $paramssld['slider_crop_image']; ?>"=="resize"){

			jQuery(".cc_slideshow_image_<?php echo $sliderID; ?>,  .cc_slideshow_image_container_<?php echo $sliderID; ?> img").css({
				cssText: "width:" + sliderwidth + "px; height:" + ((sliderwidth) * str)	+"px;"
			});

		} else {

			jQuery(".cc_slideshow_image_<?php echo $sliderID; ?>,.cc_slideshow_image_item2_<?php echo $sliderID; ?>").css({
				cssText: "max-width: " + sliderwidth + "px !important; max-height: " + (sliderwidth * str) + "px !important;"
			  });

		}

			jQuery('.cc_video_frame_<?php echo $sliderID; ?>').each(function (e) {
				jQuery(this).width(sliderwidth);
					jQuery(this).height(sliderwidth * str);
			});
      }

      jQuery(window).load(function () {

		jQuery(window).resize(function() {
			cc_popup_resize_<?php echo $sliderID; ?>();
		});

		jQuery('#cc_slideshow_left_<?php echo $sliderID; ?>').on('click',function(){
			cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), (parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()) - iterator_<?php echo $sliderID; ?>()) >= 0 ? (parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()) - iterator_<?php echo $sliderID; ?>()) % data_<?php echo $sliderID; ?>.length : data_<?php echo $sliderID; ?>.length - 1, data_<?php echo $sliderID; ?>,false,true);
			return false;
		});

		jQuery('#cc_slideshow_right_<?php echo $sliderID; ?>').on('click',function(){
			cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), (parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()) + iterator_<?php echo $sliderID; ?>()) % data_<?php echo $sliderID; ?>.length, data_<?php echo $sliderID; ?>,false,true);
			return false;
		});


		cc_popup_resize_<?php echo $sliderID; ?>();
        /* Disable right click.*/
        jQuery('div[id^="cc_container"]').bind("contextmenu", function () {
          return false;
        });

		/*HOVER SLIDESHOW*/
		jQuery("#cc_slideshow_image_container_<?php echo $sliderID; ?>, .cc_slideshow_image_container_<?php echo $sliderID; ?>, .cc_slideshow_dots_container_<?php echo $sliderID; ?>,#cc_slideshow_right_<?php echo $sliderID; ?>,#cc_slideshow_left_<?php echo $sliderID; ?>").hover(function(){
			jQuery("#cc_slideshow_right_<?php echo $sliderID; ?>").css({'display':'inline'});
			jQuery("#cc_slideshow_left_<?php echo $sliderID; ?>").css({'display':'inline'});
		},function(){
			jQuery("#cc_slideshow_right_<?php echo $sliderID; ?>").css({'display':'none'});
			jQuery("#cc_slideshow_left_<?php echo $sliderID; ?>").css({'display':'none'});
		});

		var pausehover="<?php echo $sliderpauseonhover;?>";
		if(pausehover=="on"){
			jQuery("#cc_slideshow_image_container_<?php echo $sliderID; ?>, .cc_slideshow_image_container_<?php echo $sliderID; ?>").hover(function(){
				window.clearInterval(cc_interval['cc_playInterval_'+<?php echo $sliderID; ?>]);
			},function(){
				window.clearInterval(cc_interval['cc_playInterval_'+<?php echo $sliderID; ?>]);
				play_<?php echo $sliderID; ?>();
			});
		}
          play_<?php echo $sliderID; ?>();
      });
		//var cc_play={};

      function play_<?php echo $sliderID; ?>(){
        /* Play.*/
        cc_interval['cc_playInterval_'+<?php echo $sliderID; ?>] = setInterval(function () {
          var iterator = 1;
          cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), (parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()) + iterator) % data_<?php echo $sliderID; ?>.length, data_<?php echo $sliderID; ?>,false,false);
        }, '<?php echo $slidepausetime; ?>');
      }

      jQuery(window).focus(function() {
        var i_<?php echo $sliderID; ?> = 0;
        jQuery(".cc_slider_<?php echo $sliderID; ?>").children("div").each(function () {
          if (jQuery(this).css('opacity') == 1) {
            jQuery("#cc_current_image_key_<?php echo $sliderID; ?>").val(i_<?php echo $sliderID; ?>);
          }
          i_<?php echo $sliderID; ?>++;
        });
      });
      jQuery(window).blur(function() {
        event_stack_<?php echo $sliderID; ?> = [];
      });
    </script>

<style>
	.thumb_image{
		  position: absolute;
		  width: 100%;
		  height: 100%;
		  top: 0;
		  left:0;
	}

	.play-button-slider{
		top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
	}
	.youtube-icon { position: absolute;

    background:url(<?php echo get_stylesheet_directory_uri(); ?>/modules/cc-slider/images/play.youtube.png) center center no-repeat;background-size:14%;}
</style>

	<?php
    $args = array(
    'numberposts' => 10,
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'draft, publish, future, pending, private',
    'suppress_filters' => true );

    $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
	//print_r($recent_posts);
	//echo get_the_post_thumbnail(1, 'thumbnail');
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( 1 ), 'thumbnail' );
	?>
	<?php if( $slider_is_mobile == "on" ) {?>
		<div class="cc-slides-mobile visible-xs">
			<?php if($slider_mobile_image != '') { ?>
				<img src="<?php echo$slider_mobile_image?>" />
				<div class="mobile-text"><?php echo $slider_mobile_text?></div>
			<?php }	?>
		</div>
		<?php }	?>
<?php if($sliderloadingicon == "on")	{ ?>
<div class="cc-slides-desktop <?php echo ( $slider_is_mobile != "on" )?'':'hidden-xs'; ?> cc_slideshow_image_wrap_<?php echo $sliderID; ?> nocolor">
<?php } else { ?>
<div class="cc-slides-desktop <?php echo ( $slider_is_mobile != "on" )?'':'hidden-xs'; ?> cc_slideshow_image_wrap_<?php echo $sliderID; ?> ">
<?php } ?>
	<?php if($sliderloadingicon == "on")	{ ?>
		<div id="cc_loading_image_<?php echo $sliderID;  ?>" class="display" ><img  src="<?php echo get_stylesheet_directory_uri(). '/modules/cc-slider/Front_images/loading/loading'.$paramssld["loading_icon_type"].'.gif'; ?>" alt="" /> </div>
		<div class="cc_slideshow_image_wrap1_<?php echo $sliderID; ?> nodisplay">
	<?php } else { ?>
		<div id="cc_loading_image_<?php echo $sliderID; ?>" class="nodisplay"> <img src="<?php echo get_stylesheet_directory_uri(). '/modules/cc-slider/Front_images/loading/loading'.$paramssld["loading_icon_type"].'.gif'; ?>"  alt="" width="100" height="100" style=" margin: 0px auto;" /> </div>
		<div class="cc_slideshow_image_wrap1_<?php echo $sliderID; ?>" class="display">
	<?php } ?>
      <?php
      $current_pos = 0;
      ?>

		<!-- ##########################DOTS######################### -->
        <div class="cc_slideshow_dots_container_<?php echo $sliderID; ?>">
			  <div class="cc_slideshow_dots_thumbnails_<?php echo $sliderID; ?>">
				<?php
				$current_image_id=0;
				$current_pos =0;
				$current_key=0;
				$stri=0;
				foreach ($images as $key => $image_row) {
			  	$imagerowstype=$image_row->sl_type;
				if($image_row->sl_type == ''){
				$imagerowstype='image';
				}
				switch($imagerowstype){

							case 'image':

							  if ($image_row->id == $current_image_id) {
								$current_pos = $stri;
								$current_key = $stri;
							  }

							?>
								<div id="cc_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="cc_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($key==$current_image_id) ? 'cc_slideshow_dots_active_' . $sliderID : 'cc_slideshow_dots_deactive_' . $sliderID); ?>" onclick="if(jQuery(this).hasClass('cc_slideshow_dots_active_<?php echo $sliderID; ?>')) { return false; } cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" data-image_id="<?php echo $image_row->id; ?>" data-image_key="<?php echo $stri; ?>"></div>
							<?php
							  $stri++;
							break;
							case 'video':

							  if ($image_row->id == $current_image_id) {
								$current_pos = $stri;
								$current_key = $stri;
							  }

							?>
								<div id="cc_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="cc_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($key==$current_image_id) ? 'cc_slideshow_dots_active_' . $sliderID : 'cc_slideshow_dots_deactive_' . $sliderID); ?>" onclick="if(jQuery(this).hasClass('cc_slideshow_dots_active_<?php echo $sliderID; ?>')) { return false; } cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" data-image_id="<?php echo $image_row->id; ?>" data-image_key="<?php echo $stri; ?>"></div>
							<?php
							  $stri++;
							break;
							case 'last_posts':

                                                        $keyForStoping = 0;
							foreach($recent_posts as $lkeys => $last_posts){
                                                            if($image_row->name == "0"){
                                                                if($lkeys < $image_row->sl_url){
                                                                    if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
                                                                    $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

                                                                      if ($image_row->id == $current_image_id) {
                                                                            $current_pos = $stri;
                                                                            $current_key = $stri;
                                                                      }
                                                                    ?>
                                                                            <div id="cc_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="cc_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($stri==$current_image_id) ? 'cc_slideshow_dots_active_' . $sliderID : 'cc_slideshow_dots_deactive_' . $sliderID); ?>" onclick="if(jQuery(this).hasClass('cc_slideshow_dots_active_<?php echo $sliderID; ?>')) { return false; } cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" data-image_id="<?php echo $image_row->id; ?>" data-image_key="<?php echo $stri; ?>"></div>
                                                                    <?php
                                                                      $stri++;
                                                                    }
                                                                }
                                                            }
                                                            else{
                                                                $category_id = get_cat_ID($image_row->name);                            //       USER CHOOSED CATEGORY
                                                                $category_id_from_posts = wp_get_post_categories($last_posts['ID']);    //       GETTING ALL CATEGORIES FOR THIS POST
                                                                if($keyForStoping < $image_row->sl_url){
                                                                    if (in_array($category_id, $category_id_from_posts)){
                                                                            if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
                                                                                $keyForStoping++;
                                                                                $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

                                                                                  if ($image_row->id == $current_image_id) {
                                                                                        $current_pos = $stri;
                                                                                        $current_key = $stri;
                                                                                  }
                                                                                ?>
                                                                                        <div id="cc_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="cc_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($stri==$current_image_id) ? 'cc_slideshow_dots_active_' . $sliderID : 'cc_slideshow_dots_deactive_' . $sliderID); ?>" onclick="if(jQuery(this).hasClass('cc_slideshow_dots_active_<?php echo $sliderID; ?>')) { return false; } cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" data-image_id="<?php echo $image_row->id; ?>" data-image_key="<?php echo $stri; ?>"></div>
                                                                                <?php
                                                                                  $stri++;
                                                                                }
                                                                    }
                                                                }
                                                            }

							}

							break;
					}
				}
				?>
			  </div>

			<?php
			   if ($paramssld['slider_show_arrows']=="on") {
			 ?>
				<a id="cc_slideshow_left_<?php echo $sliderID; ?>" href="#">
					<div id="cc_slideshow_left-ico_<?php echo $sliderID; ?>">
					<div><i class="cc_slideshow_prev_btn_<?php echo $sliderID; ?> fa"></i></div></div>
				</a>

				<a id="cc_slideshow_right_<?php echo $sliderID; ?>" href="#">
					<div id="cc_slideshow_right-ico_<?php echo $sliderID;?>">
					<div><i class="cc_slideshow_next_btn_<?php echo $sliderID; ?> fa"></i></div></div>
				</a>
			<?php
			}
			?>
		</div>
	  <!-- ##########################IMAGES######################### -->

      <div id="cc_slideshow_image_container_<?php echo $sliderID; ?>" class="cc_slideshow_image_container_<?php echo $sliderID; ?>">
        <div class="cc_slide_container_<?php echo $sliderID; ?>">
          <div class="cc_slide_bg_<?php echo $sliderID; ?>">
            <ul class="cc_slider_<?php echo $sliderID; ?>">
			  <?php
			  $i=0;

			  foreach ($images as $key => $image_row) {
			  	$imagerowstype=$image_row->sl_type;
				if($image_row->sl_type == ''){
				$imagerowstype='image';
				}
				switch($imagerowstype){
					case 'image':
						$target="";
                            /************Alt tag functions*********************/
                            if(!function_exists('pippin_get_image_id')){
                                function pippin_get_image_id($image_url) {
                                    global $wpdb;
                                    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
                                    if($attachment)
                                    return $attachment[0];

                                }
                            }
                            if (!function_exists('wp_get_attachment')){
                                function wp_get_attachment( $attachment_id ) {
                                    $attachment = get_post( $attachment_id );
                                    return array(
                                    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                                    'caption' => $attachment->post_excerpt,
                                    'description' => $attachment->post_content,
                                    'href' => get_permalink( $attachment->ID ),
                                    'src' => $attachment->guid,
                                    'title' => $attachment->post_title
                                    );
                                }
                            }
                            /**************************************************/
						?>
						  <li class="cc_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">
							<div class="cc_slider_wrapper_slide">
								<?php if($image_row->sl_url!=""){
									if ( $image_row->link_target=="on" ) {
										$target='target="_blank"';
									}
									echo '<div class="cc_slider_image_wrap" ><a href="'.$image_row->sl_url.'" '.$target.'>';
								}
		                            $idofatt=pippin_get_image_id($image_row->image_url);
		                            $somearray=wp_get_attachment($idofatt);
		                        ?>
								<img id="cc_slideshow_image_<?php echo $sliderID; ?>_<?php echo $key ;?>" class="cc_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $image_row->image_url; ?>"  alt="<?php if($image_row->name == "") echo $somearray['alt'];else echo $image_row->name; ?>" data-image_id="<?php echo $image_row->id; ?>" />
								<div class="default-overlay"></div>
								<?php if($image_row->sl_url!=""){ echo '</a></div>'; }?>
                                <div class="slideshow-middle">
                                    <div class="slideshow-vertical-middle">
                                         <div class="slideshow-wrap">
                                                <div class="cc_slideshow_title_text cc_slideshow_title_text_<?php echo $sliderID; ?> <?php if(trim($image_row->name)=="") echo "none"; ?>">
                                                    <?php echo $image_row->name; ?>
                                                </div>
                                                <div class="cc_slideshow_description_text cc_slideshow_description_text_<?php echo $sliderID; ?> <?php if(trim($image_row->description)=="") echo "none"; ?>">
                                                    <?php echo stripslashes( $image_row->description ); ?>
                                                </div>
                                                <?php if( $image_row->sl_is_shortcode == "on" ) { ?>
                                                <div class="cc_slidershow_shortcode hidden-sm hidden-xs cc_slidershow_shortcode_<?php echo $sliderID; ?>">
                                                    <div class="container">
                                                        <div class="row">
                                                            <?php echo do_shortcode( stripslashes( $image_row->sl_add_shortcode ) );?>
                                                         </div>
                                                     </div>
                                                </div>
                                                <?php } ?>
                                                <?php if( $image_row->sl_button_text != '' && $image_row->sl_button_url != '' ) { ?>
                                                <div class="button btn-cc btn-cc-red">
                                                    <a class="button_text" href="<?php echo $image_row->sl_button_url?>" target="<?php echo ( $image_row->sl_button_attr == "on" )?'_new':'_parent'?>" ><i class="fa fa-angle-right"></i>&nbsp;<?php echo $image_row->sl_button_text; ?></a>
                                                </div>
                                        </div>
                                    </div>
								</div>
								<?php } ?>
							</div>
						  </li>
					  <?php
					$i++;
					break;

					case 'last_posts':

                            $keyForStoping = 0;
							foreach($recent_posts as $lkeys => $last_posts){
		                                            if($image_row->name == "0"){
		                                                if($lkeys < $image_row->sl_url){
		                                                    $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

		                                                    if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
		                                                    $target="";
		                                                    ?>
		                                                      <li class="cc_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">
		                                                            <?php if ($image_row->sl_postlink=="1"){
		                                                                            if ($image_row->link_target=="on"){$target='target="_blank"';}
		                                                                            echo '<a href="'.$last_posts["guid"].'" '.$target.'>';
		                                                            } ?>
		                                                            <img id="cc_slideshow_image_<?php echo $sliderID; ?>_<?php echo $key ;?>" class="cc_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $imagethumb[0]; ?>"  alt=" <?php echo $last_posts["post_title"]; ?>" data-image_id="<?php echo $image_row->id; ?>" />
		                                                            <?php if($image_row->sl_postlink=="1"){ echo '</a>'; }?>
		                                                            <div class="cc_slideshow_title_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_title"])=="") echo "none";  if($image_row->sl_stitle!="1") echo " hidden"; ?>">
		                                                                            <?php echo $last_posts["post_title"]; ?>
		                                                            </div>
		                                                            <div class="cc_slideshow_description_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_content"])=="") echo "none"; if($image_row->sl_sdesc!="1") echo " hidden"; ?>">
		                                                                    <?php
		                                                                    echo substr_replace($last_posts["post_content"], "", $image_row->description); ?>
		                                                            </div>
		                                                     </li>
		                                                      <?php
		                                                    $i++;
		                                                    }
		                                                }
		                                            }
		                                            else{
		                                                $category_id = get_cat_ID($image_row->name);                            //       USER CHOOSED CATEGORY
		                                                $category_id_from_posts = wp_get_post_categories($last_posts['ID']);    //       GETTING ALL CATEGORIES FOR THIS POST
		                                                if($keyForStoping < $image_row->sl_url){
		                                                    if (in_array($category_id, $category_id_from_posts)){
		                                                        $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );
		                                                        if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
		                                                            $keyForStoping++;
		                                                            $target="";
		                                                        ?>
		                                                          <li class="cc_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">
		                                                                <?php if ($image_row->sl_postlink=="1"){
		                                                                                if ($image_row->link_target=="on"){$target='target="_blank"';}
		                                                                                echo '<a href="'.$last_posts["guid"].'" '.$target.'>';
		                                                                } ?>
		                                                                <img id="cc_slideshow_image_<?php echo $sliderID; ?>" class="cc_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $imagethumb[0]; ?>"  alt="<?php echo $last_posts["post_title"]; ?>" data-image_id="<?php echo $image_row->id; ?>" />
		                                                                <?php if($image_row->sl_postlink=="1"){ echo '</a>'; }?>
		                                                                <div class="cc_slideshow_title_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_title"])=="") echo "none";  if($image_row->sl_stitle!="1") echo " hidden"; ?>">
		                                                                                <?php echo $last_posts["post_title"]; ?>
		                                                                </div>
		                                                                <div class="cc_slideshow_description_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_content"])=="") echo "none"; if($image_row->sl_sdesc!="1") echo " hidden"; ?>">
		                                                                        <?php
		                                                                        echo substr_replace($last_posts["post_content"], "", $image_row->description); ?>
		                                                                </div>
		                                                         </li>
		                                                          <?php
		                                                        $i++;
		                                                        }
		                                                    }
		                                                }
		                                            }
							}
					break;
					case 'video':

						?>
						<li class="cc_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">
							<?php
								if(strpos($image_row->image_url,'youtube') !== false || strpos($rowimages->image_url,'youtu') !== false) {
									$video_thumb_url=get_youtube_id_from_url($image_row->image_url);
								?>
									<div id="video_id_<?php echo $sliderID;?>_<?php echo $key ;?>" class="cc_video_frame_<?php echo $sliderID; ?>"></div>
									<div class="thumb_wrapper" data-rowid="<?php echo $image_row->id; ?>" onclick="thevid=document.getElementById('video_id_<?php echo $sliderID;?>_<?php echo $key ;?>'); thevid.style.display='block'; this.style.display='none'">
									<img  class="thumb_image" src="https://i.ytimg.com/vi/<?php echo $video_thumb_url; ?>/hqdefault.jpg">
									<div class="play-button-slider youtube-icon"></div>
									</div>
							<?php } else {
									$vimeo = $image_row->image_url;
									$imgid =  end(explode( "/", $vimeo ));

									?>
								<iframe id="player_<?php echo $key ;?>"  class="cc_video_frame_<?php echo $sliderID; ?>" src="//player.vimeo.com/video/<?php echo $imgid; ?>?api=1&player_id=player_<?php echo $key ;?>&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
							<?php } ?>
						</li>
					<?php
					$i++;
					break;
				} // switch case ends
			 } // for each ends
			  ?>
            </ul>
          </div>
		  <input  type="hidden" id="cc_current_image_key_<?php echo $sliderID; ?>" value="0" />
        </div>
      </div>
      	</div>


<!-- slider thumbs  -->

<script>
jQuery(document).ready(function($) {


	setInterval(function() {
	jQuery('.cc_slider_<?php echo $sliderID; ?>').find("li").each(function (){

  		if($(this).css("opacity") == "1"){

  			var img_id=$(this).attr('id');
  			jQuery('.cc_slideshow_thumbs_<?php echo $sliderID; ?>').each(function (){
  				var allListElements = $( 'li[id='+img_id+']' );

  				$(this).find(allListElements).not(".bx-clone").each(function() {


  					jQuery('.cc_slideshow_thumbs_<?php echo $sliderID; ?> li').find(".trans_back").css('background','rgba(255,255,255,0.3)');
  					$(this).find('.trans_back').css('background','none');



  				})



  			})

  		}

	})
},100)




})
</script>


</div>
<?php if($sliderthumbslider=='thumbnails'){?>
<div class="cc_slideshow_thumbs_container_<?php echo $sliderID; ?>">
			  <ul id="cc_thumb_slider" class="cc_slideshow_thumbs_<?php echo $sliderID; ?>">
				<?php
				$i = $current_image_id = $current_pos = $current_key = $stri=0;

				foreach ($images as $key => $image_row) {
				  	$imagerowstype=$image_row->sl_type;

					if($image_row->sl_type == ''){
					$imagerowstype='image';
					}
					switch($imagerowstype){

						case 'image':

						  if ($image_row->id == $current_image_id) {
							$current_pos = $stri;
							$current_key = $stri;
						  }

							?>

							<li id="image_id_<?php echo $sliderID.'_'.$i ?>" class="cc_slideshow_thumbnails_<?php echo $sliderID; ?>" onclick="if(jQuery(this).hasClass('cc_slideshow_thumbnails_active_<?php echo $sliderID; ?>')) { return false; } cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" data-image_id="<?php echo $image_row->id; ?>" data-image_key="<?php echo $stri; ?>">
									<img class="sl_thumb_img" src="<?php echo $image_row->image_url; ?>" />
									<div class="trans_back" ></div>
									<input type="hidden" id="time" name="time" value="<?php echo $slidepausetime; ?>">

							</li>
							<?php
							  $stri++;
							   $i++;
							break;
						case 'video':

							$url=$image_row->image_url;

							if(strpos($image_row->image_url,'youtube') !== false || strpos($image_row->image_url,'youtu') !== false) {
								$video_thumb_url=get_youtube_id_from_url($image_row->image_url);
								$thumburl='<img class="sl_thumb_img" src="http://img.youtube.com/vi/'.$video_thumb_url.'/mqdefault.jpg" alt="" />';
								$liclass="youtube";
							}else if ( strpos($image_row->image_url,'vimeo') !== false ) {
								$liclass="vimeo";
								$vimeo = $image_row->image_url;
								$imgid =  end(explode( "/", $vimeo ));
								$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$imgid.".php"));
								$imgsrc=$hash[0]['thumbnail_large'];
								$thumburl ='<img src="'.$imgsrc.'" alt="" />';
							}

						  	if ($image_row->id == $current_image_id) {
								$current_pos = $stri;
								$current_key = $stri;
						  	}

							?>
							<li id="image_id_<?php echo $sliderID.'_'.$i ?>" class="cc_slideshow_thumbnails_<?php echo $sliderID; ?>" onclick="if(jQuery(this).hasClass('cc_slideshow_thumbnails_active_<?php echo $sliderID; ?>')) { return false; } cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" data-image_id="<?php echo $image_row->id; ?>" data-image_key="<?php echo $stri; ?>">
								<?php echo $thumburl; ?>
								<div class="play-icon <?=$liclass; ?>"></div>
								<div class="trans_back" ></div>
								<input type="hidden" id="time" name="time" value="<?php echo $slidepausetime; ?>" slide="<?php echo $sliderID; ?>">
							</li>


							<?php
							  $stri++;
							  $i++;
							break;
						case 'last_posts':
	                                $keyForStoping = 0;
									foreach($recent_posts as $lkeys => $last_posts) {
	                                    if($image_row->name == "0"){
	                                        if($lkeys < $image_row->sl_url){
	                                            $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

	                                            if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
	                                            $target="";
	                                            ?>
	                                              <li id="image_id_<?php echo $sliderID.'_'.$i ?>" class="cc_slideshow_thumbnails_<?php echo $sliderID; ?>" onclick="if(jQuery(this).hasClass('cc_slideshow_thumbnails_active_<?php echo $sliderID; ?>')) { return false; } cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" data-image_id="<?php echo $image_row->id; ?>" data-image_key="<?php echo $stri; ?>">

	                                                    <img class="sl_thumb_img" src="<?php echo $imagethumb[0]; ?>"/>
	                                                    <div class="trans_back" ></div>
														<input type="hidden" id="time" name="time" value="<?php echo $slidepausetime; ?>">

	                                             </li>
	                                              <?php
	                                            $i++;
	                                            }
	                                        }
	                                    } else {
	                                        $category_id = get_cat_ID($image_row->name);                            //       USER CHOOSED CATEGORY
	                                        $category_id_from_posts = wp_get_post_categories($last_posts['ID']);    //       GETTING ALL CATEGORIES FOR THIS POST
	                                        if($keyForStoping < $image_row->sl_url){
	                                            if (in_array($category_id, $category_id_from_posts)){
	                                                $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );
	                                                if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
	                                                    $keyForStoping++;
	                                                    $target="";
	                                                ?>
	                                                   <li id="image_id_<?php echo $sliderID.'_'.$i ?>" class="cc_slideshow_thumbnails_<?php echo $sliderID; ?>" onclick="if(jQuery(this).hasClass('cc_slideshow_thumbnails_active_<?php echo $sliderID; ?>')) { return false; } cc_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#cc_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" data-image_id="<?php echo $image_row->id; ?>" data-image_key="<?php echo $stri; ?>">

	                                                        <img id="cc_slideshow_image_<?php echo $sliderID; ?>" class="cc_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $imagethumb[0]; ?>"/>
	                                                        <div class="trans_back" ></div>
															<input type="hidden" id="time" name="time" value="<?php echo $slidepausetime; ?>">

	                                                 </li>
	                                                  <?php
	                                                $i++;
	                                                }
	                                            }
	                                        }
	                                    }
									} // ends foreach
									break;

					}



				}

			?>

			  </ul>
	</div>
<?php }
	return ob_get_clean();
}