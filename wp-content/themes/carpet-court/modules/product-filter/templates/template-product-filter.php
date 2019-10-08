<?php
/**
 * Template Name: Product Filter
 */
get_header();

$pagename = get_query_var('pagename');  

if (get_query_var("type") != "type") {
	$type = get_term_by( 'slug', get_query_var("type"), 'product_cat' );
	$type_id = $type -> term_id;
	$_POST['product_cat'] = $type_id;
	
	if ($type_id == '7') {
		$fibres = get_term_by( 'slug', get_query_var("fibres"), 'pa_fibres' );
		if ($fibres) {
			$fibres_id = $fibres -> term_id;
			$_POST['pa_fibres'] = $fibres_id;
		}
		else {
			$_POST['pa_fibres'] = '';
		}
	}
}

$feature = get_term_by( 'slug', get_query_var("feature"), 'product_feature' );
if ($feature) {
	$feature_id = $feature -> term_id;
	$_POST['product_feature'] = $feature_id;
}
else if ($type_id == '7' && $_POST['pa_fibres'] == '') {
	$fibres = get_term_by( 'slug', get_query_var("feature"), 'pa_fibres' );
	$fibres_id = $fibres -> term_id;
	$_POST['pa_fibres'] = $fibres_id;
}

if (get_query_var("lifestyle") != "lifestyle") {
	$lifestyle = get_term_by('slug', get_query_var("lifestyle"), 'pa_floor');
	if ($lifestyle) {
		$lifestyle_id = $lifestyle -> term_id;
		$_POST['pa_floor'] = $lifestyle_id;
	}
	else if ($type_id == '7' && $_POST['pa_fibres'] == '') {
		$fibres = get_term_by( 'slug', get_query_var("lifestyle"), 'pa_fibres' );
		$fibres_id = $fibres -> term_id;
		$_POST['pa_fibres'] = $fibres_id;
	}
}

$field = $value='';

$scriptvar = '<script>var post_key={';

foreach($_POST as $key => $val) {
    if( isset( $_POST[$key] ) ) {
        $field = $key;
        $value = $val;
        $scriptvar .= $field . ':["' . $value . '"],';
    }
}
$scriptvar .= 'product_tag' . ':"all"';
$scriptvar .= '};</script>';

echo $scriptvar;

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
                <div class="filter-results flexbox cpm-filter-result-open" id="cpm-filter-results-toggle">
                    <div class="filter-left col"></div>
                    <!-- <div class="col-md-12"> -->
                        <div class="filter-right col">
                        <?php include(PATH . 'template-parts/filter_tabs.php'); ?>
                        <div class="cpm-filter-results"></div>

                        </div>
                    <!-- </div> -->
                </div>
        </div>
    </main>
</div>
<?php get_footer();