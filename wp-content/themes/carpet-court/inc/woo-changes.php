<?php

require 'woo-cc_templates.php';

/* Display text before content in shop page */
add_action('woocommerce_archive_description', 'cc_display_before_content', 9);
if (!function_exists('cc_display_before_content')) {
    function cc_display_before_content() {
        if (is_post_type_archive('product')) {
            $shop_page = get_post(wc_get_page_id('shop'));
            if ($shop_page) {
                ?>
                <div class="">
                    <h2><?php _e('Product Guide', 'carpet-court'); ?></h2>
                </div>
                <?php
            }
        }
    }
}

/* Display text before categories in archive shop page */
add_action('woocommerce_before_shop_loop', 'cc_display_before_loop', 9);
if (!function_exists('cc_display_before_loop')) {
    function cc_display_before_loop() {
        if (is_post_type_archive('product')) {
            $shop_page = get_post(wc_get_page_id('shop'));
            if ($shop_page) {
                ?>
                <div class="">
                    <h2><?php _e('Know what you are looking for?', 'carpet-court'); ?></h2>
                </div>
                <?php
            }
        }
    }
}

/* Hide number of product count in archive page */
add_action('woocommerce_subcategory_count_html', 'cc_hide_product_count');
if (!function_exists('cc_hide_product_count')) {
    function cc_hide_product_count() {
        return '';
    }
}

/* Change number or products per row to 3 */
add_filter('loop_shop_columns', 'cc_loop_columns');
if (!function_exists('cc_loop_columns')) {
    function cc_loop_columns() {
        return 3;
    }
}

/*
 * Remove Default actions
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/* Hide title price,category and add to cart in product page */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

/*remove add to cart button*/
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

/*Remove star rating */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

/* Show custom info of the product in product single page */
add_action('woocommerce_single_product_summary', 'cc_product_info', 35);
function cc_product_info() {

    global $product;


    $avoid_if = get_post_meta($product->id, 'avoid_if', true);
    $post_indent = get_post_meta($product->id, 'post_indent', true);
    $maintenance = get_post_meta($product->id, 'maintenance', true);



    if (!empty($avoid_if)) {
        echo '<div class="product-detail-label desktop-view">';
        printf(esc_html__('%sAvoid If:%s%s', 'carpet-court'), '<span>', '</span>', $avoid_if);
        echo '</div>';
    }

    if (!empty($maintenance)) {
        echo '<div class="product-detail-label desktop-view">';
        printf(esc_html__('%sMaintenance:%s%s', 'carpet-court'), '<span>', '</span>', $maintenance);
        echo '</div>';
    }
    if (!empty($post_indent) && $post_indent == 1 ) {
        echo '<div class="product-detail-label desktop-view">';
        printf('Please be aware this product will take approximately 8 - 12 weeks to arrive. If you need something sooner - check <a href="'.home_url().'/products/product-filter/">here</a>');
        echo '</div>';
    }

    // do_action('woocommerce_simple_add_to_cart');
    echo '<div class="cc-btn-wrap clearfix desktop-view">
    <a href="#" class="custom-addtowishlist-btn"><img src="'.get_template_directory_uri().'/assets/images/imgpsh_fullsize1.jpeg"></a>
    <a href="#book-modal" data-toggle="modal" data-target="#book-modal" class="btn-cc btn-block btn-cc-red ">';
    _e('<span class="fa fa-angle-right"></span>  BOOK MEASURE AND QUOTE', 'carpet-court');
    echo '</a></div>';



    ?>
    <div class="modal cc-model fade" id="book-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"
                        id="book-modal"><?php _e('Book A Free Measure and Quote', 'carpet-court'); ?></h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="col-sm-12">
                            <?php echo do_shortcode('[gravityform id=1 title=false description=false ajax=true]');
                        // cpm_measuer_and_quote_form();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    if (!function_exists('woocommerce_output_content_wrapper')) {
        function woocommerce_output_content_wrapper() {
            $template = get_option('template');
            switch ($template) {
                case 'twentyeleven' :
                echo '<div id="primary"><div id="content" role="main" class="twentyeleven">';
                break;
                case 'twentytwelve' :
                echo '<div id="primary" class="site-content"><div id="content" role="main" class="twentytwelve">';
                break;
                case 'twentythirteen' :
                echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';
                break;
                case 'twentyfourteen' :
                echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc">';
                break;
                case 'twentyfifteen' :
                echo '<div id="primary" role="main" class="content-area twentyfifteen"><div id="main" class="site-main t15wc">';
                break;
                case 'twentysixteen' :
                echo '<div id="primary" class="content-area twentysixteen"><main id="main" class="site-main" role="main">';
                break;
                default :
               // echo '<div class="container" ><div id="content" class="row" role="main">';
                break;
            }
        }
    }

    add_filter('woocommerce_breadcrumb_defaults', 'cc_alter_breadcrub_defults');
    function cc_alter_breadcrub_defults($default) {
        $new = $default;

        $new['wrap_before'] = '<div class="col-md-12">' . $default['wrap_before'];
        $new['wrap_after'] = $default['wrap_after'] . '</div>';

        return $new;
    }



    add_action('woocommerce_single_product_summary', 'cc_product_specs', 35);
    function cc_product_specs() {
        ?>
        <div class="cc-product-specs desktop-view">
            <span class="cc-sub-title alt-text"><?php _e('Product Info', 'carpet-court'); ?></span>
            <a class="collapse-icon" data-toggle="collapse" href="#collapse-specs" aria-expanded="true"
            aria-controls="collapse-specs">
            <span class="cc-icon-collapse"></span>
        </a>
        <hr/>
        <div class="collapse in" id="collapse-specs">
            <div class="collapse-container">
                <?php
                global $post, $product;
                $product_info = new WC_Product($product);

                /*Category*/
                $prod_category = get_the_terms($post->ID, 'product_cat');

                $cat_array = array();
                foreach ($prod_category as $prod_value) {
                    array_push( $cat_array, $prod_value->name);
                }
                $cat_count = sizeof($prod_category);

                ?>
                <div class="product-detail-label">
                    <span>category:</span>
                    <?php echo implode( ', ', $cat_array ); ?>
                </div>
                <?php

                /* Suits Styles */
                $suit_styles = get_field('suits_styles');

                $best_for = get_post_meta($product->id, 'best_for', true);
                if (!empty($best_for)) {
                        echo '<div class="product-detail-label book-for desktop-view">';
                        printf(esc_html__('%sBest For:%s%s', 'carpet-court'), '<span>', '</span>', $best_for);
                        echo '</div>';
                    }



                // printf(esc_html__('%s suits styles: %s%s', 'carpet-court'), '<span>', '</span>', $suit_styles);
                ?>
                <?php
                if ( !empty($suit_styles) ) {
                echo '<div class="product-detail-label">';
                    ?>
                <span> specifications: </span> <!-- <a class="blue-anchor" href="<?php //echo get_permalink( get_page_by_path('design-guide/style-guide') ); ?>">Learn about our styles</a>, -->
                    <a class="blue-anchor" target="_blank" href="<?php echo $suit_styles; ?>">View spec sheet</a>
                    <?php
                echo '</div>';
                }

                /* Suits LifeStyle */
                $suit_lifestyle = get_field('suits_lifestyle');
                if (!empty($suit_lifestyle)) {
                    echo '<div class="product-detail-label suits-lifestyle">';
                    printf(esc_html__('%s suits lifestyle: %s%s', 'carpet-court'), '<span>', '</span>', $suit_lifestyle);
                    echo '</div>';
                }

                /*Price*/
                $price = $product->get_price_html();
                if (!empty($price)) {
                    echo '<div class="product-detail-label">';
                    printf(esc_html__('%s price: %s%s', 'carpet-court'), '<span>', '</span>', $price);
                    echo '</div>';
                }

                /*Weight*/
                if ( $product_info->has_weight() ) {
                    $weight = $product_info->get_weight() . ' ' . esc_attr(get_option('woocommerce_weight_unit'));
                    if (!empty($weight)) {
                        echo '<div class="product-detail-label">';
                        printf(esc_html__('%s weight: %s%s', 'carpet-court'), '<span>', '</span>', $weight);
                        echo '</div>';
                    }
                }

                /*Fibre/ Materials*/
                $materials = get_the_terms($product->id, 'pa_materials');
                if (!empty($materials)) {
                    echo '<div class="product-detail-label">';
                    printf(esc_html__('%s material: %s', 'carpet-court'), '<span>', '</span>');
                    foreach ($materials as $material) {
                        echo $material->name;
                    }
                    echo '</div>';
                }

                $fibers = get_the_terms($product->id, 'pa_fibres');
                if (!empty($fibers)) {
                    echo '<div class="product-detail-label">';
                    printf(esc_html__('%s fibre: %s', 'carpet-court'), '<span>', '</span>');
                    foreach ($fibers as $fiber) {
                        echo $fiber->name;
                    }
                    echo '</div>';
                }

                /*Lifespan*/
                $lifespan = get_field('lifespan');
                if (!empty($lifespan)) {
                    echo '<div class="product-detail-label">';
                    printf(esc_html__('%s lifespan: %s%s', 'carpet-court'), '<span>', '</span>', $lifespan);
                    echo '</div>';
                }

                /*Stock*/
               // echo '<div class="product-detail-label">';
                //echo '<span>availability:</span>';
                //if ($product_info->is_in_stock()):
                  //  _e('In Stock', 'carpet-court');
               // else:
                   // _e('Out of Stock', 'carpet-court');
               // endif;
                //echo '</div>';
                ?>
            </div>
        </div>
    </div>
    <?php
}

// add_action('woocommerce_single_product_summary', 'cc_product_colors', 35);
function cc_product_colors() {
    ?>
    <div class="cc-product-color desktop-view">
        <span class="cc-sub-title alt-text"><?php _e('Colours', 'carpet-court'); ?></span>
        <a class="collapse-icon" data-toggle="collapse" href="#collapse-color" aria-expanded="true" aria-controls="collapse-color">
            <span class="cc-icon-collapse"></span>
        </a>
        <hr/>
        <div class="collapse in" id="collapse-color">
            <div class="collapse-container">

                <?php
                global $product;
            // $colors = get_the_terms($product->id, 'pa_color');
                $colors = wp_get_object_terms( $product->id, 'pa_color' );


                $pa_floor = $pa_style = $product_color = '';

                $taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell' );

                $related_swatches_array = array();
                foreach ($taxonomy_array as $taxonomy ) {
                    if ( isset( $_GET[$taxonomy] ) && !empty( $_GET[$taxonomy] ) ) {

                        if ( is_array( $_GET[$taxonomy] ) ) {

                            foreach ($_GET[$taxonomy] as $get_value) {

                                $related_color_swatches = cc_get_term_meta( $get_value, 'related_'.$taxonomy, true );
                                if ( !empty( $related_color_swatches ) ) {

                                    foreach ($related_color_swatches as $swatches_value) {
                                       if ( !in_array($swatches_value, $related_swatches_array ) ) {
                                           array_push( $related_swatches_array, $swatches_value );
                                       }
                                   }
                               }
                           }
                       } else {
                         $related_color_swatches = cc_get_term_meta( $_GET[$taxonomy], 'related_'.$taxonomy, true );
                         if ( !empty( $related_color_swatches ) ) {

                             foreach ($related_color_swatches as $swatches_value) {
                                if ( !in_array($swatches_value, $related_swatches_array ) ) {
                                    array_push( $related_swatches_array, $swatches_value );
                                }
                            }
                        }
                    }

                }
            }

            if ( !empty( $related_swatches_array ) ) {
                foreach ($colors as $keys => $color_value) {
                    if ( !in_array( $color_value->term_id, $related_swatches_array ) ) {
                        unset( $colors[$keys] );
                    }
                }
            }

            if (!empty($colors)) {
                $first = true;
                foreach ($colors as $color) {
                    if ($first === true) {
                        echo '<div class="product-detail-label single-selected-color">';
                        printf(__('%s Selected Colour:&nbsp; %s%s', 'carpet-court'), '<span>', '</span>', $color->name);
                        echo '</div>';
                        echo '<ul id="color-tab" class="nav nav-tabs" role="tablist">';
                    }
                    $thumbnail_id = get_term_meta($color->term_id, 'thumbnail_id', true);
                    $term_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true );
                    if ( !empty( $term_image ) ) {

                        $active = (true == $first) ? 'active' : '';

                    // $image = wp_get_attachment_image_src($thumbnail_id);
                        echo '<li role="presentation" class="' . $active . '" data-color="' . $color->name . '">';
                        echo '<a href="#' . $color->term_id . '" data-cid="' . $color->term_id . '" id="color-i-' . $color->term_id . '" data-href="'.$term_image.'" aria-controls="' . $color->term_id . '" role="tab" data-toggle="tab" class="clearfix" data-term="'.$color->name.'"><img class="color-swatches-patches" src="' . $term_image . '" data-large-image="' . $term_image . '"></a>';
                        echo '</li>';

                    } elseif ($thumbnail_id) {
                        $active = (true == $first) ? 'active' : '';

                        $image = wp_get_attachment_image_src($thumbnail_id);
                        echo '<li role="presentation" class="' . $active . '" data-color="' . $color->name . '">';
                        echo '<a href="#' . $color->term_id . '" data-cid="' . $color->term_id . '" id="color-i-' . $color->term_id . '" data-href="'.$image[0].'" aria-controls="' . $color->term_id . '" role="tab" data-toggle="tab" class="clearfix" data-term="'.$color->name.'"><img class="color-swatches-patches" src="' . $image[0] . '" data-large-image="' . $image[0] . '"></a>';
                        echo '</li>';

                    }
                    $first = false;
                }
                echo "<li role='presentation' data-color='all' class='all-select' style='display:none;'><a href='#all' aria-controls='all' role='tab' data-toggle='tab' class='clearfix' aria-expanded='false'>Show All</a></li>";
                echo '</ul>';
            }
            ?>
        </div>
    </div>
</div>
    <!-- <div class="cc-resene-color">
        <span class="cc-sub-title alt-text"><?php _e('Resene Colour Matches', 'carpet-court'); ?></span>
        <a class="collapse-icon" data-toggle="collapse" href="#collapse-resene" aria-expanded="true"
           aria-controls="collapse-resene">
            <span class="cc-icon-collapse"></span>
        </a>
        <hr/>
        <div class="collapse in" id="collapse-resene">
            <div class="collapse-container">
                <div class="tab-content">
                    <?php
                    // $resene_matches = get_field('resene_match');
                    // if (!empty($resene_matches)) {
                    //     $first_match = true;
                    //     foreach ((array) $resene_matches as $resene_match) {
                    //         $active = (true == $first_match) ? "in active" : '';
                    //         echo '<div role="tabpanel" class="tab-pane fade ' . $active . '" id="' . $resene_match['color'] . '">';
                    //         if (!empty($resene_match['nice_and_neutral'])) {
                    //             echo '<div class="product-detail-label resene-section-label">';
                    //             _e('<span>Nice and Neutral</span>', 'carpet-court');
                    //             echo '<img src="' . $resene_match['nice_and_neutral'] . '">';
                    //             echo '</div>';
                    //         }
                    //         if (!empty($resene_match['a_touch_of_color'])) {
                    //             echo '<div class="product-detail-label resene-section-label">';
                    //             _e('<span>A Touch of Colour</span>', 'carpet-court');
                    //             echo '<img src="' . $resene_match['a_touch_of_color'] . '">';
                    //             echo '</div>';
                    //         }
                    //         if (!empty($resene_match['color_lovers'])) {
                    //             echo '<div class="product-detail-label resene-section-label">';
                    //             _e('<span>Colour Lovers</span>', 'carpet-court');
                    //             echo '<img src="' . $resene_match['color_lovers'] . '">';
                    //             echo '</div>';
                    //         }
                    //         echo '</div>';
                    //         $first_match = false;
                    //     }
                    // }
                    ?>
                </div>
            </div>
        </div>
    </div> -->
    <?php
}

add_action('woocommerce_single_product_summary', 'cpm_add_star_rating', 35);
function cpm_add_star_rating() { ?>
<div class="cc-resene-reviews">
    <span class="cc-sub-title alt-text">Ratings & Reviews</span>
    <a class="collapse-icon" data-toggle="collapse" href="#cpm-ratings" aria-expanded="true" aria-controls="cpm-ratings">
        <span class="cc-icon-collapse"></span>
    </a>
    <hr>
    <div class="collapse in" id="cpm-ratings">
        <div class="collapse-container">
            <div class="tab-content">
                <?php wc_get_template( 'single-product/rating.php' ); ?>
                <div class="cpm-reviews-tab-wrapper">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#what-others-say" aria-controls="what-others-say" role="tab" data-toggle="tab"><?php _e( 'What others say', 'carpet-court' ); ?></a></li>
                        <li role="presentation"><a href="#have-your-say" aria-controls="have-your-say" role="tab" data-toggle="tab"><?php _e( 'Have Your Say', 'carpet-court' ); ?></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="what-others-say">
                        </div>
                        <div role="tabpanel" class="tab-pane" id="have-your-say">
                            <?php comments_template(); ?>
                        </div>

                    </div>
                </div> <!-- Cpm-review-tab-wrapper end -->
            </div>
        </div>
    </div>
</div>
<!-- Branding -->
<div class="cc-brand-cpm">
    <span class="cc-sub-title alt-text">Brand</span>
    <a class="collapse-icon" data-toggle="collapse" href="#cpm-branding" aria-expanded="true" aria-controls="cpm-branding">
        <span class="cc-icon-collapse"></span>
    </a>
    <hr>
    <div class="collapse in" id="cpm-branding">
        <div class="collapse-container">
            <div class="tab-content">
                <?php
                $brandss = get_the_terms( $product->ID, 'product_brand' );
                $brand_thumbnail_id = get_term_meta($brandss[0]->term_id, 'thumbnail_id', true);
                $brand_image = wp_get_attachment_image_src($brand_thumbnail_id, 'large');
                if ( !empty( $brand_image[0] ) ) {
                    ?>
                    <img src="<?php echo $brand_image[0]; ?>">

                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Finance -->
<div class="cc-cpm-finance">
    <span class="cc-sub-title alt-text">Finance</span>
    <a class="collapse-icon" data-toggle="collapse" href="#cc-cpm-finance" aria-expanded="true" aria-controls="cc-cpm-finance">
        <span class="cc-icon-collapse"></span>
    </a>
    <hr>
    <div class="collapse in" id="cc-cpm-finance">
        <div class="collapse-container">
            <div class="tab-content">
			<?php global $cc_options; ?>
                 <a href="<?php echo esc_url( $cc_options['product_finance_link']); ?>" target="_blank">
                    <img src="<?php echo esc_url($cc_options['product_finance_media']['url']); ?>">
                 </a>
			</div>
        </div>
    </div>
</div>
<?php

}




add_action('cc_woocommerce_after_single_product_images', 'cc_woocommerce_template_single_title', 10);
add_action('cc_woocommerce_after_single_product_images', 'cc_woocommerce_template_single_description', 10);
add_action('cc_woocommerce_after_single_product_images', 'cc_woocommerce_template_book_button', 10);

add_action('cc_woocommerce_after_single_product_images', 'woocommerce_template_single_key_feaures', 10);

/*works well with section in product detail page*/
add_action('cc_woocommerce_after_single_product_images', 'woocommerce_template_single_works_well', 15);

/*other products you might like section in product detail page*/
add_action('cc_woocommerce_after_single_product_images', 'woocommerce_template_single_other_products', 20);


/*add starting wrappers for images in the woocommerce*/
add_action('before_cc_woo_images', 'before_cc_woo_images_wrapper', 10);
function before_cc_woo_images_wrapper() {
    echo '<div class="col-xs-12 col-md-8 col-sm-6 " >';
}

/*add wishlist button*/
add_action('before_cc_woo_images', 'cc_show_wishlist', 15);
function cc_show_wishlist() {
    wc_get_template( 'single-product/title.php' );
    ?>
    <div class="user-wishlist pull-right clearfix">
        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
    </div>
    <?php
}

/*add ending wrappers for images in the woocommerce*/
add_action('after_cc_woo_images', 'after_cc_woo_images_wrapper', 10);
function after_cc_woo_images_wrapper() {
    echo '</div>';
}

/*show user info in account page*/
add_action('woocommerce_before_my_account', 'cc_user_info');
function cc_user_info() {
    //global $current_user;
    //get_currentuserinfo();
    $current_user = wp_get_current_user();
    ?>
    <div class="my-details cc-user-details">
        <h3 class="alt-text font-normal"><?php _e('My Details', 'carpet-court'); ?></h3>
        <h4><?php _e('Contact Information', 'carpet-court'); ?></h4>
        <div class="row">
            <!-- <div class="col-sm-4">
                <div class="mt-10 mb-10 user-info">
                    <span><?php //_e('First Name:', 'carpet-court'); ?></span>
                    <?php //echo $current_user->user_firstname; ?>
                </div>
            </div> -->
            <!-- <div class="col-sm-4">
                <div class="mt-10 mb-10 user-info">
                    <span><?php //_e('Last Name:', 'carpet-court'); ?></span>
                    <?php //echo $current_user->user_lastname; ?>
                </div>
            </div> -->
            <div class="col-sm-4">
                <div class="mt-10 mb-10 user-info">
                    <span><?php _e('Email:', 'carpet-court'); ?></span>
                    <?php echo $current_user->user_email; ?>
                </div>
            </div>
            <!-- <div class="col-sm-4">
                <div class="mt-10 mb-10 user-info">
                    <span><?php //_e('Mobile:', 'carpet-court'); ?></span>
                    <?php //echo $current_user->billing_phone; ?>
                </div>
            </div> -->
            <!-- <div class="col-sm-4">
                <div class="mt-10 mb-10 user-info">
                    <span><?php //_e('Address:', 'carpet-court'); ?></span>
                    <?php //echo $current_user->billing_address_1; ?>
                </div>
            </div> -->
            <div class="col-sm-4">
                <a href="<?php echo wc_customer_edit_account_url();?>" class="btn btn-cc btn-block btn-ltr btn-cc-empty">
                    <?php _e('Edit account details', 'carpet-court'); ?>
                </a>
            </div>
        </div>
    </div>
    <hr class="thin-hr">
    <?php
}

// add_action('woocommerce_after_my_account','cc_user_wishlist_section',20);

function cc_user_wishlist_section() {
    $wishlist_url = '#';
    if( function_exists( 'YITH_WCWL' ) ){
        $wishlist_url = YITH_WCWL()->get_wishlist_url();
    }
    ?>
    <div class="my-details cc-user-wishlist-section pad0lr-xs col-md-6 pad0r-md pad0lr-sm">
      <h3 class="alt-text font-normal"><?php _e('Wishlist', 'carpet-court'); ?></h3>
      <div class="row">
          <div class="col-sm-12">
              <a href="<?php echo $wishlist_url; ?>"
               class="btn btn-cc btn-block btn-ltr btn-cc-empty"><?php _e("Check your wishlist items", "carpet-court"); ?></a>
           </div>
       </div>
   </div>
   <hr class="thin-hr">
   <?php
}
add_action('woocommerce_after_my_account','cc_user_remove_account_section',25);
function cc_user_remove_account_section() {
    ?>
    <div class="my-details cc-user-remove-section" >
        <h3 class="alt-text font-normal"><?php _e('Remove Account', 'carpet-court'); ?></h3>
        <div class="row">
            <div class="col-sm-6">
                <div><?php _e('Would you like to remove your account?','carpet-court');?></div>
                <div><?php _e('Please note this not reversible','carpet-court');?></div>

                <div id="woo-user-remove-alert" class="alert alert-dismissible fade in" role="alert">
                    <div id="alert-msg"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <a href="#" id="woo-remove-user" class="btn btn-block btn-cc-regular-red"><?php _e("Remove Account","carpet-court");?></a>
            </div>
        </div>
    </div>
    <hr class="thin-hr">
    <?php
}

add_action('wp_ajax_remove_woo_user_account','woo_remove_user_account');
add_action('wp_ajax_nopriv_remove_woo_user_account','woo_remove_user_account');

function woo_remove_user_account(){
    global $wpdb;
    check_ajax_referer( 'woo_user_remove', 'ajax_nonce' );

    $user = get_current_user_id();
    require_once(ABSPATH.'wp-admin/includes/user.php' );
    $result = wp_delete_user( $user );

    $response = array();

    if( $result ){
        $response['status'] = TRUE;
        $response['message'] = __("Your Account has beed removed succesfully","carpet-court");
    } else {
        $response['status']  = FALSE;
        $response['message'] = __("Unable to remove your account.Please try again after reloading your page.","carpet-court");
    }

    echo json_encode( $response );
    die;
}

function product_review_comment_template( $comment_template ) {
    global $post;
    if( $post->post_type === 'product' ) {
        return dirname(__FILE__). '/reviews.php';
    }
}
// add_filter( 'comments_template', 'product_review_comment_template' );

// add_action( 'woocommerce_after_shop_loop_item_title', array( WC_Wishlists_Plugin, 'add_to_wishlist_button' ), 10 );