<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Carpet_Court
 */
get_header();

global $wpdb;
$table_name = $wpdb->prefix . 'slider_sliders';
$slider = get_field('slider_shortcode');
$mobile_slider = get_field('mobile_slider');
$show_random_slider = get_field('show_random_slider');

$add_slider_shortcode = '';
$cc_slider_ids = '';



$margin_top_class = '';
if ( empty( $add_slider_shortcode ) && empty( $cc_slider_ids ) ) {
    $margin_top_class = 'cpm-margin-no-slider';
}
?>

<?php if( get_field('enable_one_page_scroller', get_the_ID()) ){


    ?>
    <div id="primary" class="content-area container <?php echo $margin_top_class; ?>">
        <main id="main" class="row" role="main">
            <?php
            if( function_exists( 'woocommerce_breadcrumb' ) ) : woocommerce_breadcrumb(); endif;
            ?>
            <div class="entry-content">

            <?php



            if ( $show_random_slider == 'no' ) {
                if(get_field('add_slider_shortcode')){
                    echo '<div class="slider-view scroll-sec active">';
                    $add_slider_shortcode = get_field('add_slider_shortcode');
                    if ( !empty( $mobile_slider ) ) { ?>
                        <div class="mobile-view">
                            <?php echo do_shortcode( get_field('mobile_slider') ); ?>
                        </div>
                        <?php
                    }
                    ?>
                        <div class="desktop-view">
                            <?php echo do_shortcode($add_slider_shortcode); ?>
                        </div>
                        <?php

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
                        echo '<div class="slider-title-wrap animate-left"><div class="container"><span class="overlay" style="background-color: '.$rgba_col.'"></span>';
                        if( get_field('slider_title') ) echo '<h5 class="slider-title">'.get_field('slider_title').'</h5>';
                        if( get_field('slider_description') ) echo '<div class="slider-content">'.get_field('slider_description').'</div>';
                        echo '</div></div>';
                    }
					else
					{
					 /* echo '<div class="slider-title-wrap animate-left"><div class="container"><span class="overlay" style="background-color: '.$rgba_col.'"></span>';
                        if( get_field('slider_description') ) echo '<h5 class="slider-content">'.get_field('slider_description').'</h5>';
                       // if( get_field('slider_description') ) echo '<div class="slider-content">'.get_field('slider_description').'</div>';
                        echo '</div></div>';*/
$slider_description = get_field('slider_description');

                        if( !empty($slider_description ) && $slider_description !== ''  ) :
                      echo '<div class="slider-title-wrap animate-left"><div class="container"><span class="overlay" style="background-color: '.$rgba_col.'"></span>';
                            echo '<h5 class="slider-content">'.get_field('slider_description').'</h5>';
                       // if( get_field('slider_description') ) echo '<div class="slider-content">'.get_field('slider_description').'</div>';
                        echo '</div></div>';
                        endif;	

					}
                    if( have_rows('slider_links') ){
                        echo '<div class="slider-link-sec animate-right"><span class="overlay" style="background-color: '.$rgba_col.'"></span><ul>';
                        while( have_rows('slider_links') ) : the_row();
                            echo '<li><a href="'.get_sub_field('link_url').'">'.get_sub_field('link_text').'</a></li>';
                        endwhile;
                        echo '</ul></div>';
                    }
                    ?>
                    <a class="cc-scroll-down" href="#"><span></span></a>
                    </div>
                <?php }
            } else {
                echo '<div class="slider-view scroll-sec">';
                $cc_slider_ids = get_post_meta( $post->ID, 'selected_random_sliders', true );
                if( empty( $cc_slider_ids ) ) {
                    $cc_slider_ids = array( '1' );
                }
                shuffle( $cc_slider_ids ) ;
                echo do_shortcode( '[cc_slider id="'.$cc_slider_ids[0].'"]' );
                echo '</div>';
            }
            ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; // End of the loop. ?>
            </div><!-- .site-content -->
            </div><!-- .entry-content -->
        </main><!-- #main -->
    </div><!-- #primary -->
    <!-- Pop up for the diagnostic shortcode added to different pages -->
    <div class="modal grow" id="page-modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg modal-xlg" role="document">

            <div class="modal-content">
                <div class="modalbox-header pull-right">
                    <form>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                        </form>
                    </div>
                    <div class="modal-body" id="post-popup">
                        <iframe id="my_iframe" name="my_iframe" src="" width="100%" height="1200px"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of Pop up for the diagnostic shortcode added to different pages -->
    <?php get_footer(); ?>
<?php }else{?>
<div class="slider-view">
    <?php
    $show_slider = false;
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
        if ( !empty( $add_slider_shortcode ) ) {

            $show_slider = true;
        }
    } elseif ( $show_random_slider == 'yes' ) {
        $cc_slider_ids = get_post_meta( $post->ID, 'selected_random_sliders', true );
        if ( !empty( $cc_slider_ids ) ) {

            $show_slider = true;
        }
        if( empty( $cc_slider_ids ) ) {
            $cc_slider_ids = array( '1' );
        }
        shuffle( $cc_slider_ids ) ;
        echo do_shortcode( '[cc_slider id="'.$cc_slider_ids[0].'"]' );
    } else {
        echo do_shortcode( $slider );
    }
        $margin_top_class = '';
        if ( !$show_slider ) {
            $margin_top_class = 'cpm-margin-no-slider';
        }
    ?>
</div>

<div id="primary" class="content-area container <?php echo $margin_top_class; ?>">
	<main id="main" class="row" role="main">
        <?php
        if( function_exists( 'woocommerce_breadcrumb' ) ) : woocommerce_breadcrumb(); endif;
        ?>
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', 'page' );
		endwhile; // End of the loop.
		?>
	</main><!-- #main -->
</div><!-- #primary -->

<!-- Pop up for the diagnostic shortcode added to different pages -->
<div class="modal grow" id="page-modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg modal-xlg" role="document">

        <div class="modal-content">
            <div class="modalbox-header pull-right">
                <form>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                    </form>
                </div>
                <div class="modal-body" id="post-popup">
                    <iframe id="my_iframe" name="my_iframe" src="" width="100%" height="1200px"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- end of Pop up for the diagnostic shortcode added to different pages -->
<?php
get_footer();
}
