<?php
/**
 * Template Name: Template Stain
 * * Description: Default Page for Stain-removal.
 *
 * @package Carpet_Court
 */
get_header(); ?>
<?php
global $wpdb;
$table_name = $wpdb->prefix . 'slider_sliders';
$slider = get_field('slider_shortcode');
$mobile_slider = get_field('mobile_slider');
$show_random_slider = get_field('show_random_slider');

$add_slider_shortcode = '';
$cc_slider_ids = '';
?>

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
<?php

if ( !empty( $mobile_slider ) ) { ?>

<div class="mobile-view">
    <?php echo do_shortcode( $mobile_slider ); ?>
</div>

<?php
}

$margin_top_class = '';
if ( empty( $add_slider_shortcode ) && empty( $cc_slider_ids ) ) {
    $margin_top_class = 'cpm-margin-no-slider';
}
?>

<div id="primary" class="content-area container <?php echo $margin_top_class; ?>">
  <main id="main" class="row" role="main">
    <div class="vc_row wpb_row vc_row-fluid">
        <div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner ">
            <div class="wpb_wrapper">
              <div class="wpb_text_column wpb_content_element ">
                  <div class="wpb_wrapper">
                          <h1 class="cc-vc-title" style="font-size: 40px; line-height: 1.2; text-align: center;">
                                <em>Stain removal</em>
                          </h1>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<?php if(function_exists('woocommerce_breadcrumb')):woocommerce_breadcrumb();endif;?>

    <?php

            $floor_terms = get_terms( array(
                'taxonomy' => 'floor_taxonomy',
                'hide_empty' => true,
                'number'  => 6
                ) );
            $fibre_terms = get_terms( array(
                'taxonomy' => 'fibre_taxonomy',
                'hide_empty' => true,
                'number'  => 6
                ) );
            $stains_terms = get_terms( array(
                'taxonomy' => 'top_five_taxonomy',
                'hide_empty' => true,
                ) );
                ?>


                <!-- KIND OF FLOOR STARTS -->
                <section class="floor-wrap col-md-12">
                    <div class="row">
                     <div class="col-md-12">
                      <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_border_width_3 vc_sep_pos_align_center vc_sep_color_grey wow fadeInUp vc_separator-has-text animated" style="visibility: visible; animation-name: fadeInUp;">
                       <span class="vc_sep_holder vc_sep_holder_l">
                        <span class="vc_sep_line"></span>
                    </span>
                    <h4>What is your stain?</h4>
                    <span class="vc_sep_holder vc_sep_holder_r">
                        <span class="vc_sep_line"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="row prod-cat-wrap">
            <?php
            if ( !empty( $stains_terms ) ) {
                foreach ($stains_terms as $stains_term_value) {

                    $term_id = $stains_term_value->term_id;
                            $thumbnail = get_field('taxonomy_image', 'top_five_taxonomy_' . $term_id);//cc_gal_image
                            $term_image = wp_get_attachment_image_src ( $thumbnail, 'category_image', true );
                            ?>

                            <div style="visibility: visible; animation-name: fadeInUp;" class="wow fadeInUp wpb_column vc_column_container vc_col-sm-2 animated">
                                <div class="prod-post vc_column-inner">
                                    <!-- <div class="prod-post selected"> -->
                                    <div class="wpb_wrapper">
                                        <div class="cc-gallery ">
                                            <a href="javascript:void(0)" id="cc-cat-floor-<?php echo $term_id; ?>" data-taxonomy="top_five_taxonomy" data-tab="<?php echo $term_id; ?>" class="cpm-stain cpm-floor cpm-stain-filter">
                                                <input type="hidden" name="floor_id" value="<?php echo $term_id; ?>"></input>
                                                <div class="cc-gallery-img cc-gallery-zoom">
                                                    <?php
                                                    if ( !empty($term_image[0] ) ) { ?>

                                                    <img src="<?php echo $term_image[0]; ?>">

                                                    <?php
                                                }
                                                ?>
                                                <div class="default-overlay" style="background-color:rgba(0,0,0,0.2)"></div> <figure class="figure-cross" data-backgroundcolor-hover="">
                                                <div class="cc-gallery-title">
                                                    <span class="span-cross" style="color: #ffffff">
                                                        <i class="line top" style="background-color: #ffffff"></i><?php echo $stains_term_value->name; ?><i class="line bottom" style="background-color: #ffffff"></i>
                                                    </span>
                                                </div>
                                            </figure>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }

            }
            ?>
        </div>
        <div class="space" style="height:32px; overflow: hidden;"></div>
    </section>
    <!-- KIND OF FLOOR ENDS -->


    <!-- STEPS STARTS -->
    <section class="steps-wrap col-md-12">
        <div class="row">
         <div class="col-md-12">
          <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_border_width_3 vc_sep_pos_align_center vc_sep_color_grey wow fadeInUp vc_separator-has-text animated" style="visibility: visible; animation-name: fadeInUp;">
           <span class="vc_sep_holder vc_sep_holder_l">
            <span class="vc_sep_line"></span>
        </span>
        <h4>What kind of carpet do you have?</h4>
        <span class="vc_sep_holder vc_sep_holder_r">
            <span class="vc_sep_line"></span>
        </span>
    </div>
    <?php

    $args = array(
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'       => 'ASC'
        );
    $tags = get_terms( 'fibre_taxonomy', $args );
    if( !empty( $tags ) ) {
        ?>
        <div class="tab-filters">
            <ul class="tab-filters-list">
                <?php
                foreach( $tags as $tag ) {
                    ?>
                    <li><a href="#"  class="tabss cpm-stain-filter" data-taxonomy="fibre_taxonomy" data-tab="<?php echo $tag->term_id;?>"><?php echo $tag->name?></a></li>
                    <?php
                }
                ?>
            </ul>

        </div>
        <?php
    }
    ?>
</div>
</div>


<div class="row-wrap" id="cpm-stain-removal">

</div>

<div class="space" style="height:32px; overflow: hidden;"></div>
<?php
    while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/content', 'page' );
                endwhile; // End of the loop.
?>
</section>
<!-- STEPS ENDS -->


</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
