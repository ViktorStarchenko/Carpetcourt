  <?php
  /**
   * this template parts is for filter product result showing part on left
   */
  global $cc_options;

  ?>
  <form class="filter-form-left" action="" method="POST" name="frm-product-filter">
	  <div class="filter-lefts cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left cbp-spmenu-open" id="cbp-spmenu-s1">

		  <h4 class="filterpanel-title"><?php _e('Filter By','cc_filter_product'); ?></h4>

		  <div class="panel-group" id="accordion" >
			  <?php

			  if ( ( ( isset( $_POST['pa_rent'] ) && !empty( $_POST['pa_rent'] ) ) || ( isset( $_POST['pa_sell'] ) && !empty( $_POST['pa_sell'] ) ) ) || ( ( isset( $_POST['pa_floor'] ) && !empty( $_POST['pa_floor'] ) ) || ( isset( $_POST['pa_style'] ) && !empty( $_POST['pa_style'] ) ) ) ) { ?>
			  <script type="text/javascript">
				  jQuery('#heading-pa_color').parent().removeClass('hidden');
			  </script>
			  <?php
		  }

			$taxonomies = array(
			  'product_cat',
			  'pa_fibres',
			  'pa_floor',
			  'pa_style',
			  'product_color',
			  'pa_filter-colour',
			  'product_feature'
			  );

		  $counter = 0;

		  $color_palettes_array = array();
		  foreach($taxonomies as $taxonomy):
			  $counter++;
		  $tax_object = get_taxonomy( $taxonomy );
		  $tax_name = ( $taxonomy == "product_cat" )?"Type":$tax_object->labels->name;
 if ( $taxonomy == 'pa_floor' ) {
			  $tax_name = 'LifeStyle';
		  } 
		  
		  elseif ( $taxonomy == 'pa_fibres' ) {
			  $tax_name = 'Fibre';
		  }
		  elseif ( $taxonomy == 'pa_color' ) {
			  $tax_name = 'Colour Swatches';
		  } elseif ( $taxonomy == 'pa_filter-colour') {
			  $tax_name = 'Colour';
		  }

				  // fetch images from theme options
		  $image_url = '';
		  if( isset($cc_options[$taxonomy]) && isset($cc_options[$taxonomy]['url']) && $cc_options[$taxonomy]['url']!='' ) {
			  $image_url	= $cc_options[$taxonomy]['url'];
		  }
		   if ( $taxonomy == 'pa_fibres' ) {
			  $image_url	="https://carpetcourt.nz/wp-content/uploads/2017/09/floor.png";
		  }

		   //dump($taxonomy);
		   //dump($cc_options);

		  $alter_hidden_class = '';
		  if ( $taxonomy == 'pa_looks' || $taxonomy == 'pa_color' || $taxonomy == 'cpm_accents' ) {
			  $alter_hidden_class = 'hidden';
		  }

		  if ( isset( $_POST['child_product_color'] ) && !empty( $_POST['child_product_color'] ) && $taxonomy == 'cpm_accents' ) {
			  $alter_hidden_class = '';
		  }
		 
		  if (((get_query_var("type", 'false') != '7' && get_query_var("type", 'false') != 'false') || (isset($_POST['product_cat']) && $_POST['product_cat'][0] != '7') || (!isset($_POST['product_cat']))) && $taxonomy == 'pa_fibres') {
			  $alter_hidden_class = 'hidden';
		  }

		  if ( $taxonomy != 'cpm_accents' ) {
			  $additional_class = '';

			  if ( $taxonomy == 'product_feature'){
				  $additional_class = 'option-filter-lists';
			  }

			  $open_accodeion = '';
			  $icon_up_down = '';
			  // if ( $taxonomy != 'product_feature') {
				  $open_accodeion = 'in';
				  $icon_up_down = 'down';
			  // } else {
				 //  $icon_up_down = 'up';
			  // }
				  $nopp='';
			  /*$useragent=$_SERVER['HTTP_USER_AGENT'];

  if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)) )
	  {
		$nopp='in';
	  }
	  else
	  {
	  	$nopp='';
	  }*/
	  ?>
			  <div class="panel panel-default panel-transparent <?php echo $alter_hidden_class; ?> <?php echo $taxonomy;?> <?php echo $additional_class ; ?>">
				  <div class="panel-heading" role="tab" id="heading-<?php echo $taxonomy;?>">
					  <h4 class="panel-title">
						  <a class="accordion-toggle" data-toggle="collapse" href="#collapse-<?php echo $taxonomy;?>">

							  <?php if ( !is_null($image_url) ) { ?>
							  <span class="tax-icon"><img src="<?php echo $image_url?>" width="32px" height="32px" /></span>
							  <?php } ?>
							  <span class="tax-name"><?php echo $tax_name;?></span>
							  <i class="indicator arrow-chevron-<?php echo $icon_up_down; ?> pull-right"></i>
						  </a>
					  </h4>
				  </div>

				  <div id="collapse-<?php echo $taxonomy;?>" class="panel-collapse collapse <?php echo ( $counter == 1 )?'in':''; echo " ".$nopp.' '. $open_accodeion;?>" role="tabpanel" aria-labelledby="heading-<?php echo $taxonomy;?>">
					  <div class="panel-body">
						  <?php
						  if ( $taxonomy == 'pa_style' ) { ?>
						  <div class="cpm-style-text">
							  <a class="cpm-style-learn" href="<?php echo get_permalink( get_page_by_path( 'design-guide/style-guide' ) ); ?>">Learn more about our 6 design styles</a>
						  </div>
						  <?php
					  }
					  ?>
					  <ul class="panel-col col-<?php echo ($taxonomy=="product_color")?'two':'two'?>">
						  <?php
						  $args = array(
							  'hide_empty' => false,
							  'orderby'    => 'name',
							  'order'       => 'ASC',
							  'parent'	 => 0
							  );
							  
							if ( $taxonomy == 'pa_fibres' ) {
								$args['slug'] = array('polyester', 'polypropylene', 'rhino-carpet', 'solution-dyed-nylon', 'wool', 'wool-blend'); $args['orderby'] = 'slug';
							}
						  $loop_life = get_terms( $taxonomy, $args );

						  foreach($loop_life as $single) {

							  if ( $taxonomy == 'product_color' ) {
								  array_push( $color_palettes_array, $single->term_id );
							  }

							  $thumbnail_id = cc_get_term_meta( $single->term_id, 'thumbnail_id', true );

							  if( $taxonomy == "product_cat"){
								  $thumbnail_id = get_woocommerce_term_meta( $single->term_id, 'thumbnail_id', true );
							  }

							  $image = '';
							  if ( $thumbnail_id ) {
								  $image = wp_get_attachment_image_src( $thumbnail_id, ($taxonomy == "product_color")?'thumbnail':'thumbnail' );
								  $image = $image[0];
							  }

									  // Prevent esc_url from breaking spaces in urls for image embeds
									  // Ref: http://core.trac.wordpress.org/ticket/23605
							  $image = str_replace( ' ', '%20', $image );
								  // if ( $taxonomy == 'additional_option') {
								  // 	$template_path = PATH.'template-parts/additional_options_filter.php';
								  // } else {

							  $template_path = PATH.'template-parts/filter_accordion.php';
								  // }
							  include( $template_path );

								  } // loop
								  ?>
							  </ul>
						  </div>
					  </div>
				  </div>
				  <?php } else { ?>

				  <div class="panel panel-default panel-transparent <?php echo $alter_hidden_class; ?> <?php echo $taxonomy;?>">
					  <div class="panel-heading" role="tab" id="heading-<?php echo $taxonomy;?>">
						  <h4 class="panel-title">
							  <a role="button" data-toggle="collapse" href="#collapse-<?php echo $taxonomy;?>" aria-expanded="true" data-parent="#accordion" aria-controls="collapse-<?php echo $taxonomy;?>">
								  <?php if ( !is_null($image_url) ) { ?>
								  <span class="tax-icon"><img src="<?php echo $image_url?>" width="32px" height="32px" /></span>
								  <?php } ?>
								  <span class="tax-name">Accent Colours</span>
								  <i class="indicator arrow-chevron-<?php echo ( $counter == 1 )?'up':'down'?> pull-right"></i>
							  </a>
						  </h4>
					  </div>

					  <div id="collapse-<?php echo $taxonomy;?>" class="panel-collapse collapse <?php echo ( $counter == 1 )?'in':''?>" role="tabpanel" aria-labelledby="heading-<?php echo $taxonomy;?>">
						  <div class="panel-body">
							  <ul class="panel-col col-<?php echo ($taxonomy=="product_color")?'two':'two'?>">
								  <?php


								  foreach($color_palettes_array as $palettes_single) {

									  $palettes_terms = get_terms( 'product_color', array( 'parent' => $palettes_single, 'hide_empty' => false ) );
									  foreach ( $palettes_terms as $single ) {

										  $thumbnail_id = cc_get_term_meta( $single->term_id, 'thumbnail_id', true );

										  if( $taxonomy == "product_cat"){
											  $thumbnail_id = get_woocommerce_term_meta( $single->term_id, 'thumbnail_id', true );
										  }

										  $image = '';
										  if ( $thumbnail_id ) {
											  // $image = wp_get_attachment_image_src( $thumbnail_id, ($taxonomy == "product_color")?'thumbnail':'filtertype_image' );
											  $image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
											  $image = $image[0];
										  }

										  $image = str_replace( ' ', '%20', $image );
										  $template_path = PATH.'template-parts/child_filter_accordion.php';
										  include( $template_path );

									  } // loop
								  }
								  ?>
							  </ul>
						  </div>
					  </div>
				  </div>
				  <?php
			  } ?>
		  <?php endforeach; ?>
	  </div>


  </form>



  <script type="text/javascript">
	  var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
	  showLeft = document.getElementById( 'showLeft' ),
	  toggleOpen = document.getElementById( 'cpm-filter-results-toggle' ),
	  body = document.body;

	  showLeft.onclick = function() {
		  classie.toggle( this, 'active' );
		  classie.toggle( menuLeft, 'cbp-spmenu-open' );
		  classie.toggle( toggleOpen, 'cpm-filter-result-open' );
		  classie.toggle( toggleOpen, 'cpm-filter-result-close' );
		  // setTimeout(function(){
		  var range_heightt = 0;
		  jQuery('.list-product-wrap .list-product').each( function() {
			  if ( jQuery(this).height() > range_heightt ) {
				  range_heightt = jQuery(this).height();
			  }
		  });
			  if ( jQuery(this).hasClass('active') ) {
				  jQuery('.list-product-wrap .list-product').css('height', 'auto' )	;
			  }
			  if ( !jQuery(this).hasClass('active') ) {
				  jQuery('.list-product-wrap .list-product').height(
					  range_heightt );
			  }
		  // }, 1000);
	  };

	  // if ( jQuery('#showLeft').hasClass('active') ) {
	  // 	jQuery('.list-product-wrap .list-product').css( 'height','auto' );
	  // } else {
	  // 	setTimeout(function(){
	  // 	var range_heightt = 0;
	  // 	jQuery('.list-product-wrap .list-product').each( function() {
	  // 		if ( jQuery(this).height() > range_heightt ) {
	  // 			range_heightt = jQuery(this).height();
	  // 		}
	  // 	});
	  // 		jQuery('.list-product-wrap .list-product').height( range_heightt );
	  // 	}, 1000);
	  // }



	  jQuery(window).resize(function(){
		  if ( jQuery(window).width() > 768 ) {

			  classie.add( menuLeft, 'cbp-spmenu-open' );
		  }
	  });

  </script>
