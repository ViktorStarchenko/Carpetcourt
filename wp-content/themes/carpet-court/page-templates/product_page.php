<style type="text/css">
    .cat_block{
        width: 33.33333%;
        padding: 30px;
        float: left;
        text-align: center;
    }
    .cat_block img{
        width: 100%;
    }
    .fa-heart-o{
        position: relative;
        top:8px;
    }
    .cat_title{
        margin-top: -50px;
        display: block;
        font-weight: bold;
        color: white;
        font-size: 25px;
        letter-spacing: 2px;
    }
    
    .text_container{
        width: 90%;
        margin: 0 auto;
        margin-top: 30px;
    }
    #colophon{
        height: 0px;
    }
    .product-filter-banner img{
    width: 100%;
}
</style>
<?php
/**
 * Template Name: Product page
 */
get_header();

$field = $value='';

foreach($_POST as $key => $val) {
    if( isset( $_POST[$key] ) ) {
        $field = $key;
        $value = $val;
        break;
    }
}
if($field !='') {
    ?>
    <script>
        var post_key={<?php echo $field;?>:[<?php echo implode(",", $value );?>]};
    </script>
<?php }

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
    $show_slider = false;
    if ( $show_random_slider == 'no' ) {
        $add_slider_shortcode = get_field('add_slider_shortcode');
        echo do_shortcode($add_slider_shortcode);
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
    if ( !$show_slider ) {
        $margin_top_class = 'cpm-margin-no-slider';
    }
?>
<?php //echo do_shortcode('[websitetour id="7871"]'); ?>
<div class="container-fluid pad0lr <?php echo $margin_top_class; ?>" id="home-content-wrap">
    <?php
        $product_banner = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
        if ( !empty( $product_banner ) ) {
            ?>
        <div class="product-filter-banner">
            <img src="<?php echo $product_banner; ?>">
        </div>

            <?php
        }

    ?>

    <main id="main" role="main">
        <div id="hidden_breadcrumb" style="display:none;">
            <?php if(function_exists('woocommerce_breadcrumb')):woocommerce_breadcrumb();endif;?>
        </div>
        <div class="col-md-12 pad0lr-xs">
        <div class="text_container">
            <?php the_content(); ?>
        </div>
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
                                <h4 class="media-heading">see our specials</h4>
                              </div>
                                      </a>
                            </li> <!-- media ends-->
                        </ul>
                    </div>


                </div>
            </div>
        </div>
                <div style="margin: 0 30px;">
                   <?php
   $prod_categories = get_terms( 'product_cat', array(
        'orderby'    => 'name',
        'order'      => 'ASC',
        'parent' => 0,
        'hide_empty' => true
    ));

    foreach( $prod_categories as $prod_cat ) :
        $cat_id = $prod_cat->term_id;
		$cat_slug = $prod_cat->slug;
        $cat_thumb_id = get_woocommerce_term_meta( $prod_cat->term_id, 'thumbnail_id', true );
        $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'shop_catalog' );
        $term_link = get_term_link( $prod_cat, 'product_cat' );?>

        <?php
                if ($cat_id == 7) {?>
                    <div class="cat_block">
                    <div class="cat_img">
                    <a href="https://carpetcourt.nz/fibers/<?php echo $cat_slug; ?>/">
                    <div class="overlay"></div>
                     <img src="<?php echo $shop_catalog_img[0]; ?>" alt="<?php echo $prod_cat->name; ?>" />
                    </a>
                    </div>
                    <a class="cat_title" href="https://carpetcourt.nz/fibers/<?php echo $cat_slug; ?>/"><?php echo $prod_cat->name; ?></a>
                    </div>
                  <?php  }
                  else{
         ?>


        <div class="cat_block">
        <div class="cat_img">
        <a href="https://carpetcourt.nz/category/<?php echo $cat_slug; ?>">
        <div class="overlay"></div>
         <img src="<?php echo $shop_catalog_img[0]; ?>" alt="<?php echo $prod_cat->name; ?>" />
        </a>
        </div>
        <a class="cat_title" href="https://carpetcourt.nz/category/<?php echo $cat_slug; ?>/"><?php echo $prod_cat->name; ?></a>
        </div>

    <?php } endforeach; wp_reset_query();
 ?>

                        </div>
                    <!-- </div> -->
                </div>
        </div>
        
    </main>
</div>
<?php get_footer();