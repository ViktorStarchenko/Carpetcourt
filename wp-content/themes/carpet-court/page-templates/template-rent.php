<?php
/*
* Template Name: Rent
*
*/
get_header();

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

<section id="home-content-wrap" class="<?php echo $margin_top_class; ?>">
    <!-- <div class="container">
        <div class="row">
         <?php
         // if( function_exists( 'woocommerce_breadcrumb' ) ) : woocommerce_breadcrumb(); endif;
         ?>
     </div>
 </div> -->

 <div class="container-fluid pad0lr cpm-full-width">
 <?php
     $product_banner = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
     if ( !empty( $product_banner ) ) {
         ?>

     <div class="product-filter-banner hidden">
         <img src="<?php echo $product_banner; ?>">
     </div>
         <?php
     }
 ?>
    <!-- <div class="container-fluid pad0lr cpm-container-fluid" style="display: none;"> -->
    <!-- progressbar -->
    <div class="progrebar-header col-sm-12 clearfix wow fadeInUp hidden">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                    <ul id="progressbar">

                     <li class="li-rent active current" id="li-id-rent">
                         <h3 class="alt-text cc-effect-1"><a class="cpm-first-steps" href="#" id="cpm-rent"><span><?php _e('Rent','cc_filter_product');?></span></a></h3>
                         <span class="cpm-taxonomy-name">pa_rent</span>
                         <div class="selected-text"></div>
                     </li>
                     <li class="li-color">
                         <h3 class="alt-text cc-effect-1"><span><?php _e('Colour Life','cc_filter_product');?></span></h3>
                         <span class="cpm-taxonomy-name">color</span>
                         <div class="selected-text"></div>
                     </li>
                     <li class="li-results">
                        <h3 class="alt-text cc-effect-1"><span><?php _e('Results','cc_filter_product');?></span></h3>
                        <div class="selected-text"></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php

$field_blurb = get_field('blurb_text'); ?>


<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1 ">

            <div class="progressbar-life-desc text-center rent-qns">
                <h3>Who are your tenants?</h3>
            </div>
            <?php if ( !empty( $field_blurb[0]['text_content_blurb'] ) ) { ?>
            <div class="progressbar-life-desc text-center">
                <?php $field = 0;
                foreach ($field_blurb as $desc): ?>
                <div class="life-desc" data-index="<?php echo $field++; ?>"><?php echo $desc['text_content_blurb']; ?></div>
            <?php endforeach; ?>
        </div>
        <?php } ?>
    </div>
</div>
</div>

<!-- multistep form -->
<div id="msform">


    <!-- fieldsets -->
    <div class="col-sm-12 pad0lr-xs">

       <fieldset data-index="1"  class="cpm-pa_rent">
         <ul class="cc_filter full-width-filter rent">
             <?php cc_cpm_filter_template_loop('pa_rent'); ?>
         </ul>
         <input type="hidden" name="pa_rent" id="cc_rent"/>

         <!-- custom link for take another look -->
         <a href="<?php echo site_url('flooring-finder'); ?>" class="previouss action-button">
             <span class="fa fa-5x fa-angle-left"></span>
             <span class="action-span">Take another look</span>
         </a>

     </fieldset>

     <fieldset data-index="2" class="color-palette">
             <?php

             if ( is_page('rent') || is_page('sell') || is_page('keep') ) {
                ?>
                <div class="container">
                           <div class="cpm-bold2">Now, choose the type of colour you're looking for</div>
				<div class="cpm-light-text">Natural and timeless choices or go bold with colours or patterns.</div>
                            <div class="text-centre">
                                <div class="colored-cpm-bold">
                                   <a href="#" class="skip-action">
                                       Or skip, and see all colours
                                   </a>
                               </div>
                           </div>

                  </div>
           <?php
       }
       ?>

       <ul class="cc_filter full-width-filter color">
         <?php cc_filter_template_loop('pa_filter-colour'); ?>
     </ul>

     <input type="hidden" name="cc_color" id="cc_color"/>


     <a href="#" class="previous action-button">
         <span class="fa fa-5x fa-angle-left"></span>
         <span class="action-span">Take another look</span></a>
     <?php
     // $child_path = PATH.'template-parts/product_color_child_title.php';
     // include( $child_path );
     ?>
     <!-- <input type="hidden" name="cc_color_child" id="cc_color_child"/> -->
     <a href="#" class="previous color-previous action-button hidden">
         <span class="fa fa-5x fa-angle-left"></span>
         <span class="action-span"> Take another look</span></a>

     </fieldset>


     <fieldset data-index="3"  class="results-section">
        <!-- Results -->
        <!-- <div class="filter-radio">
            <?php
            /*$delivery_args = array(
                'hide_empty' => false,
                'orderby' => 'date',
                'order' => 'ASC'
                );
            $delivery_type = get_terms('product_delivery', $delivery_args);*/
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                        <div class="cc-seperator">
                            <h3><?php //_e("When do you need it ?", "cc_filter_product") ?></h3>
                        </div>
                        <div class="row">
                            <div class="productdelay-wrap">
                                <?php
                                /*$del_count = 1;
                                foreach ($delivery_type as $delivery):
                                    $checked = ($del_count == 1) ? 'checked="checked"' : '';
                                $del_count++;*/
                                ?>
                                <div class="col-sm-4">
                                    <input type="radio" class="radio-custom"
                                    name="delivery" <?php //echo $checked; ?>
                                    value="<?php //echo $delivery->term_id ?>"/>
                                    <label for="radio-1"
                                    class="radio-custom-label"><?php //echo $delivery->name ?></label>
                                </div>
                            <?php //endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="cc-filter-dark">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <!-- <div class="fig-content">
                                <span class="line-top"></span>
                                <h2 class="alt-text"><?php //_e("PRODUCTS FOR YOU", "cc_filter_product") ?> </h2>
                                <span class="line-bottom"></span>
                            </div> -->
                            <ul class="thumbs-step">
                                <li class="media">
                                  <a href="<?php echo esc_url(home_url('/')); ?>measure-and-quote/">
                                  <div class="media-left">
                                    <img class="media-object" src="<?php echo get_template_directory_uri(); ?>/assets/images/tape.png" alt="Generic placeholder image">
                                    </div>
                                  <div class="media-body">
                                    <h4 class="media-heading">BOOK A MEASURE AND QUOTE</h4>
                                  </div>
                                  </a>
                                </li> <!-- media ends-->
                                <li class="media">
                                  <a href="<?php echo esc_url(home_url('/')); ?>advice/q-card/">
                                  <div class="media-left">
                                    <img class="media-object" src="<?php echo get_template_directory_uri(); ?>/assets/images/dollar.png" alt="Generic placeholder image">
                                    </div>
                                  <div class="media-body">
                                    <h4 class="media-heading">FINANCE YOUR FLOOR</h4>
                                  </div>
                                  </a>
                                </li> <!-- media ends-->
                                <li class="media">
                                  <a href="javascript:void(0)" onclick="document.getElementById('cc-cat-form-specials').submit(); return false;" >
                                  <div class="media-left">
                                    <img class="media-object" src="<?php echo get_template_directory_uri(); ?>/assets/images/tag.png" alt="Generic placeholder image">
                                    </div>
                                <form style="display: none;" id="cc-cat-form-specials" action="<?php echo esc_url( home_url() ); ?>/product-filter/" method="POST" >
                                      <?php $term = get_term_by( 'name', 'Specials', 'product_tag', OBJECT );  ?>
                                      <input name="product_tag[]" value="<?php echo $term->term_id; ?>" type="hidden">
                                  </form>
                                  <div class="media-body">
                                    <h4 class="media-heading">SEE OUR SPECIALS</h4>
                                  </div>
                                      </a>
                                </li> <!-- media ends-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

    <div class="filter-results flexbox cpm-filter-result-close" id="cpm-filter-results-toggle">
        <div class="filter-left col"></div>
        <div class="filter-right col">
            <?php include(PATH . 'template-parts/filter_tabs.php'); ?>
            <div class="cpm-filter-results"></div>

        </div>
    </div>
    <a href="#" class="previous result-previous action-button hidden">
        <span class="fa fa-5x fa-angle-left"></span>
        <span class="action-span"> Take another look</span></a>
    </fieldset>
</div>
</div>

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
    <div class="modal grow" id="product_color-modal-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg modal-xlg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="product_color_post-popup">

                </div>
            </div>
        </div>
    </div>
</div>
<!--container ends-->
</section>

<?php get_footer();