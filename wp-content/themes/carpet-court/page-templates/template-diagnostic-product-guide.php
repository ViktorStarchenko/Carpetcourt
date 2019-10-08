<?php
/*
* Template Name: Product Guide Diagnostics
*
*/
get_header();

$slider = get_field('slider_shortcode');
$mobile_slider = get_field('mobile_slider');
$show_random_slider = get_field('show_random_slider'); ?>

<div class="desktop-view">
    <?php
    if ( $show_random_slider == 'no' ) {
    	$add_slider_shortcode = get_field('add_slider_shortcode');
    	echo do_shortcode($add_slider_shortcode);
        $rgba_col = 'rgba(12, 11, 11, 0.33)';
        $opacity = 1;
        if( get_field('background_opacity') ){
            $opacity = get_field('background_opacity');
        }
        if( get_field('background_color') ){
            $hex_color = get_field('background_color');
            $rgba_col = cpm_hex2rgba($hex_color, $opacity);
        }
        if( !empty( get_field('slider_title') ) ){
            echo '<div class="slider-title-wrap"><div class="container"><span class="overlay" style="background-color: '.$rgba_col.'"></span>';
            if( get_field('slider_title') ) echo '<h5 class="slider-title">'.get_field('slider_title').'</h5>';
            if( get_field('slider_description') ) echo '<div class="slider-content">'.get_field('slider_description').'</div>';
            echo '</div></div>';
        }
    } elseif ( $show_random_slider == 'yes' ) {
    	$cc_slider_ids = get_post_meta( $post->ID, 'selected_random_sliders', true );
        if( empty( $cc_slider_ids ) ) {
            $cc_slider_ids = array( '1' );
        }
        shuffle( $cc_slider_ids ) ;
        echo do_shortcode( '[cc_slider id="'.$cc_slider_ids[0].'"]' );
    } else {
    	echo do_shortcode( $slider );
    } ?>
</div>
<div class="mobile-view">
    <?php echo do_shortcode( $mobile_slider ); ?>
</div>

<section id="home-content-wrap">
	<div class="container">
		<div class="row">
			<?php
			if( function_exists( 'woocommerce_breadcrumb' ) ) : woocommerce_breadcrumb(); endif;
			?>
		</div>
	</div>



	<div class="container-fluid pad0lr cpm-container-fluid full-width">

		<div id="msform" class="no-top-margin">
			<div class="col-sm-12 pad0lr-xs">
				<fieldset>
					<div class="container">
						<div class="row">
							<div class="col-sm-12 col-md-10 col-md-offset-1 ">
								<!-- floor list an images -->
								<div class="progressbar-life-desc text-center floor-qns">
									<h3>What do you need a floor for?</h3>
								</div>
								<div class="progressbar-life-desc text-center style-qns hidden">
									<h3>What look do you like?</h3>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>

	</div>
	<div class="container-fluid pad0lr cpm-container-fluid">
		<ul class="cc_filter full-width-filter">
			<?php cc_cpm_image_lists('rent'); ?>
			<?php cc_cpm_image_lists('sell'); ?>
			<?php cc_cpm_image_lists('keep'); ?>
		</ul>
	</div>

</section>
<?php

get_footer();