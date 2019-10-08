<?php
/**
 * Template Name: Search Product
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
    <div class="container">
        <div class="row">
           <?php
           if( function_exists( 'woocommerce_breadcrumb' ) ) : woocommerce_breadcrumb(); endif;
           ?>
       </div>
   </div>

   <div class="container-fluid pad0lr cpm-first-step">
    <div class="progrebar-header col-sm-12 clearfix wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1 ">

                    <div class="progressbar-life-desc text-center">
                        <h3>What do you need a floor for?</h3>
                    </div>

                    <ul id="cpm-progressbar">
                        <li class="li-rent active current" id="li-id-rent">
                            <h3 class="alt-text cc-effect-1"><a class="cpm-first-steps" href="#" id="cpm-rent"><span><?php _e('Rent','cc_filter_product');?></span></a></h3>
                            <span class="cpm-taxonomy-name">pa_rent</span>
                            <div class="selected-text"></div>
                        </li>
                        <li class="li-sell" id="li-id-sell">
                            <h3 class="alt-text cc-effect-1"><a class="cpm-first-steps" href="#" id="cpm-se;;"><span><?php _e('Sell','cc_filter_product');?></span></a></h3>
                            <span class="cpm-taxonomy-name">sell</span>
                            <div class="selected-text"></div>
                        </li>
                        <li class="li-keep" id="li-id-keep">
                            <h3 class="alt-text cc-effect-1"><a class="cpm-first-steps" href="#" id="cpm-keep"><span><?php _e('Keep','cc_filter_product');?></span></a></h3>
                            <div class="selected-text"></div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 pad0lr-xs cpm-col-fieldset">

        <div class="cpm-fieldset fieldset-rent fadeInUp animated" data-index="5">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                        <!-- floor list an images -->
                        <ul class="cc_filter row rent">
                            <?php cc_cpm_filter_template_loop('pa_rent'); ?>
                        </ul>
                        <input type="hidden" name="pa_rent" id="cc_rent"/>
                        <!-- <a href="#" class="next action-button">Next</a> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="cpm-fieldset fieldset-sell fadeInUp animated" data-index="6" style="display: none;">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                        <!-- floor list an images -->
                        <ul class="cc_filter row sell">
                            <?php cc_cpm_filter_template_loop('pa_sell'); ?>
                        </ul>
                        <input type="hidden" name="pa_sell" id="cc_sell"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="container-fluid pad0lr cpm-container-fluid" style="display: none;">

    <?php

    $field_blurb = get_field('blurb_text'); ?>


    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1 ">
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
    <!-- progressbar -->
    <div class="progrebar-header col-sm-12 clearfix wow fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                    <ul id="progressbar">
                        <li class="li-floor active current">
                            <h3 class="alt-text cc-effect-1"><span><?php _e('Floor Life','cc_filter_product');?></span></h3>
                            <span class="cpm-taxonomy-name">floor</span>
                            <div class="selected-text"></div>
                        </li>
                        <li class="li-style">
                            <h3 class="alt-text cc-effect-1"><span><?php _e('Style Life','cc_filter_product');?></span></h3>
                            <span class="cpm-taxonomy-name">style</span>
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

    <!-- fieldsets -->
    <div class="col-sm-12 pad0lr-xs">
        <fieldset data-index="0">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                        <!-- floor list an images -->
                        <ul class="cc_filter row floor">
                            <?php cc_filter_template_loop('pa_floor'); ?>
                        </ul>
                        <input type="hidden" name="pa_floor" id="cc_floor"/>
                        <a href="#" class="first-previous action-button">
                            <span class="fa fa-5x fa-angle-left"></span>
                            <span class="action-span"> Take another look</span></a>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset data-index="1">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                            <!-- Style list an images -->
                            <ul class="cc_filter row style">
                                <?php cc_filter_template_loop('pa_style'); ?>
                            </ul>
                            <input type="hidden" name="cc_style" id="cc_style"/>

                            <a href="#" class="previous action-button">
                                <span class="fa fa-5x fa-angle-left"></span>
                                <span class="action-span"> Take another look</span></a>

                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset data-index="2" class="color-palette">
                    <div class="container">
                        <div class="row">
                            <?php

                            if ( is_page('rent') || is_page('sell') || is_page('keep') ) {
                             ?>
                             <div class="cpm-bold">ALready chosen your colours or not planning on paintings?</div>
                             <div class="text-centre">
                               <div class="colored-cpm-bold">
                                SKIP COLOUR SELECTION AND VIEW ALL PRODUCTS
                            </div>
                        </div>
                        <div class="cpm-bold">
                          Or want us to suggest a colour scheme to match your floor?
                      </div>
                      <div class="cpm-light-text">
                          We've created 6 unique colour schemes that are on point, but also timeless - giving you design advice - without the cost of a designer. So whether you lean towards blue, greys, greens we'll have a floor suggestion for you.
                      </div>
                      <div class="text-centre">
                          <div class="colored-cpm-bold">CHOOSE YOUR COLOUR PALETTE</div>
                      </div>
                      <?php
                  }
                  ?>
                  <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                    <!-- Color list an images -->
                    <ul class="cc_filter row color">
                        <?php cc_filter_template_loop('product_color'); ?>
                    </ul>

                    <input type="hidden" name="cc_color" id="cc_color"/>


                    <a href="#" class="previous action-button">
                        <span class="fa fa-5x fa-angle-left"></span>
                        <span class="action-span">Take another look</span></a>

                    </div>
                </div>
            </div>
            <?php
            $child_path = PATH.'template-parts/product_color_child_title.php';
            include( $child_path );
            ?>
            <input type="hidden" name="cc_color_child" id="cc_color_child"/>
        </fieldset>

        <fieldset data-index="3">
            <!-- Results -->
            <div class="filter-radio">
                <?php
                $delivery_args = array(
                    'hide_empty' => false,
                    'orderby' => 'date',
                    'order' => 'ASC'
                    );
                $delivery_type = get_terms('product_delivery', $delivery_args);
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                            <div class="cc-seperator">
                                <h3><?php _e("When do you need it ?", "cc_filter_product") ?></h3>
                            </div>
                            <div class="row">
                                <div class="productdelay-wrap">
                                    <?php
                                    $del_count = 1;
                                    foreach ($delivery_type as $delivery):
                                        $checked = ($del_count == 1) ? 'checked="checked"' : '';
                                    $del_count++;
                                    ?>
                                    <div class="col-sm-4">
                                        <input type="radio" class="radio-custom"
                                        name="delivery" <?php echo $checked; ?>
                                        value="<?php echo $delivery->term_id ?>"/>
                                        <label for="radio-1"
                                        class="radio-custom-label"><?php echo $delivery->name ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cc-filter-dark">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="fig-content">
                            <span class="line-top"></span>
                            <h2 class="alt-text"><?php _e("PRODUCTS FOR YOU", "cc_filter_product") ?> </h2>
                            <span class="line-bottom"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="filter-results flexbox cpm-filter-result-open" id="cpm-filter-results-toggle">
            <div class="filter-left col"></div>
            <div class="filter-right col">
                <?php include(PATH . 'template-parts/filter_tabs.php'); ?>
                <div class="cpm-filter-results"></div>

            </div>
        </div>
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
</div>
<!--container ends-->
</section>

<?php
get_footer();