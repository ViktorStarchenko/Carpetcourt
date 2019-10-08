<style type="text/css">
    .cat_block{
        width: 33.33333%;
        padding: 30px;
        float: left;
        text-align: center;
    }
    .fa-heart-o{
        position: relative;
        top:8px;
    }
    .cat_block img{
        width: 100%;
    }
    .cat_title{
        margin-top: -50px;
        display: block;
        font-weight: bold;
        color: white;
        font-size: 25px;
        letter-spacing: 2px;
    }
    .pad0lr-xs{
        padding-bottom: 20px !important;
        border-bottom: 3px solid #979797 !important;
        padding-top: 30px !important;
        margin-bottom: 20px;
    }
    .text_container{
        width: 90%;
        margin: 0 auto;
        margin-top: 30px;
    }
    #colophon{
        height: 0px;
    }
    
    .brand_prod{
        padding-top: 20px;
    }
    .list-product-wrap{
        max-width: 100% !important;
    }
    .cc-product-features li{
        margin-bottom: 0px !important;
    }
    .list-key-features {
    padding: 5px 0 !important;
    min-height: 95px;
}
.list-product .list-title .list-product-title{
    padding-bottom: 15px !important;
}
.view_all{
    display: block;
    text-align: center;
    margin-bottom: 45px;
}
.view_all a{
    color: white;
    font-weight: bold;
    background: #54c6d3;
    padding: 10px;

}
.view_all a:hover{
    color: white !important;
}
.brand-block{
    max-height: 363px;
}

.list-product{
    max-height: 328px;
    min-height: 328px !important;
}
.product-filter-banner img{
    width: 100%;
}
@media only screen and (min-width : 1400px) {
    .brand-block{
    max-height: 415px;
    }
.list-product{
    max-height: 383px;
    min-height: 383px !important;
}
}
</style>
<?php
/**
/* Template Name:Brand page
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
                <div class="col-lg-8">
                    <?php the_content(); ?>
                </div>
                <div class="col-lg-4">
                   <?php
                    echo (get_post_meta($post->ID, 'video for brand page', true)); ?>
               
                </div>
            </div>
           <?php 
		   $cat = get_term_by( 'slug', get_query_var("cat_slug"), 'product_cat' );
		   $cat_id = $cat -> term_id;
		   $fibre = get_term_by( 'slug', get_query_var("fibre_slug"), 'pa_fibres' );
		   $fib_id = $fibre -> term_id;
		   $fib = 'pa_fibres';
		   $brand = get_term_by( 'slug', get_query_var("brand_slug"), 'product_brand' );
           $barand_id = $brand -> term_id;

            global $wpdb;
            $table_name = $wpdb->prefix . "terms";
            $cat_name = $wpdb->get_results("SELECT slug from $table_name WHERE term_id = $cat_id");
            foreach ($cat_name as $row2) {
               $cat_slag =$row2->slug;
                 }

                if ($cat_slag == 'carpet') {
                    echo '<div class="list-product-wrap">';
                       $args = array(
                    'post_type' => 'product',
                    'product_cat' => $cat_slag,
                    //'posts_per_page' => 4,
                    'tax_query' => array(
                  array(
                    'taxonomy'      => 'product_brand',
                    'terms'         => $barand_id,
                    'field'         => 'id',
                    'operator'      => 'IN'
                  ),
                   array(
                    'taxonomy'      => $fib,
                    'terms'         => $fib_id,
                    'field'         => 'id',
                    'operator'      => 'IN'
                  )
              )
            );
         }
         else{
           echo '<div class="list-product-wrap">';
               $args = array(
            'post_type' => 'product',
            'product_cat' => $cat_slag,
            //'posts_per_page' => 4,
            'tax_query' => array(
          array(
            'taxonomy'      => 'product_brand',
            'terms'         => $barand_id,
            'field'         => 'id',
            'operator'      => 'IN'
          )
      )
    );
    }
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) { ?>
        <h3><?php echo $row->name; ?></h3>
       <?php while ( $loop->have_posts() ) : $loop->the_post();
            global $product;
            $get_permalink = get_permalink(); ?>
<div class="col-md-6 brand-block">
<a href="<?php echo $get_permalink; ?>" class="list-product flexbox clearfix wow fadeInUp">


        <div class="list-image-link col">
            <?php
            $is_ribbon = get_field('top_seller');
             $fetImg = get_field('feature_tag');
             //print_r( $fetImg);

            $ribbon_text = ( !empty( $is_ribbon ) && in_array("yes", $is_ribbon) )?get_field('ribbon_label'):NULL;
            if ( !empty( $is_ribbon ) && in_array("yes", $is_ribbon) && !is_null( $ribbon_text ) ) {
                ?>
                <div class="ribbon-text"><?php echo $ribbon_text;?></div>
                <?php } ?>

                <div class="list-image">
                    <?php
                    $product_wide_image = get_field('diagnostic_filter_image');
                    $image_feature_url = get_field('featured_image');

                    if( isset( $product_wide_image['sizes']['product-wide'] ) ) { ?>
                    <img src="<?php echo $product_wide_image['sizes']['product-wide']?>" alt="<?php echo $product_wide_image['title'];?>" />
                    <?php
                } elseif( !empty( $image_feature_url ) ) {
                    ?>
                    <img src="<?php echo $image_feature_url; ?>" />
                    <?php

                } else {
                    if ( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail( get_the_ID(), 'product-wide' );
                    }
                }
                ?>

            </div>
            <div class="color-term-name ts-term" style="display:table;"><span class="term-span"><?php echo $fetImg;?></span></div>
            <div class="desc-and-link bg-green text-white clearfix desktop-view">
                <div class="list-desc">
                    <?php
                    the_excerpt();
                    ?>
                </div>

            </div>
        </div>
        <div class="list-title col">
            <h4 class="list-product-title"><?php the_title() ?></h4>
            <?php cpm_get_product_ratings( get_the_ID() ); ?>
            <div class="list-attributes">
                <?php
                    // Get product attributes for fibre and material
                $taxonomies_slug = array(
                    'pa_materials',
                    'pa_fibres',
                    );

                foreach ($taxonomies_slug as $slug):
                    $tax_detail = get_taxonomy($slug);
                $attributes = $product->get_attribute($slug);
                if ($attributes != ''):
                    ?>
                <div class="list-attribute">
                    <span><?php echo $tax_detail->labels->name; ?>:</span>
                    <?php echo $attributes; ?>
                </div>
                <?php
                endif;
                endforeach;
                ?>
            </div>
            <div class="list-key-features clearfix">
                <ul class="cc-product-features hi-icon-effect-9 hi-icon-small hi-icon-effect-9b">
                    <?php
                    $features = get_the_terms(get_the_ID(), 'product_feature');
                    if ($features):
                        foreach ($features as $feature):
                            $thumbnail_id = cc_get_term_meta($feature->term_id, 'thumbnail_id', true);
                        $image = cc_placeholder_img_src();
                        if ($thumbnail_id) {
                                // $image = wp_get_attachment_thumb_url( $thumbnail_id );
                            $image = wp_get_attachment_image_src($thumbnail_id, 'category_image');
                            $image = $image[0];
                        }

                            // Prevent esc_url from breaking spaces in urls for image embeds
                            // Ref: http://core.trac.wordpress.org/ticket/23605
                        $image = str_replace(' ', '%20', $image);
                        ?>
                        <li>
                           <span class="hi-icon hi-icon-images" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $feature->name );?>">
                               <img src="<?php echo esc_url($image) ?>" alt="<?php echo $feature->name; ?>" width="35" height="35" />
                           </span>
                       </li>
                       <?php
                       endforeach;
                       endif;
                       ?>
                   </ul>
               </div>
               <div class="list-color-available">
                <?php
                $color_values = get_the_terms( get_the_ID(), 'pa_color');
                $pa_floor = $pa_style = $product_color = '';

                // $taxonomy_array = array( 'pa_floor', 'pa_filter-colour' );
                $taxonomy_array = array( 'pa_filter-colour' );

                $related_swatches_array = array();
                foreach ($taxonomy_array as $taxonomy ) {
                    if ( isset( $_POST[$taxonomy] ) && !empty( $_POST[$taxonomy] ) ) {

                        if ( is_array( $_POST[$taxonomy] ) ) {

                            foreach ($_POST[$taxonomy] as $get_value) {

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
                       $related_color_swatches = cc_get_term_meta( $_POST[$taxonomy], 'related_'.$taxonomy, true );
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

        $colors_array = array();
        if ( !empty( $related_swatches_array ) ) {
            $count_k = 0;
            foreach ($color_values as $keys => $color_value) {
                            // if ( !in_array( $color_value->term_id, $related_swatches_array ) ) {
                            //     unset( $colors[$keys] );
                            // }
                if( ( $keyyy = array_search( $color_value->term_id, $related_swatches_array ) ) !== false ) {
                    $colors_array = array($keyyy.$count_k => $color_values[$keys]) + $colors_array;
                } else {
                    $colors_array[$count_k] = $color_values[$keys];
                }
                $count_k++;
            }
        } else {
            $colors_array = $color_values;
        }
        $total_color = count( $colors_array );
        if ( !empty($colors_array) ) {
                // echo "<pre>";
                // print_r($colors_array);
                // echo "</pre>";
            ?>
            <span class="cpm-list-color"><?php
                printf( __("%d colours available","cc_product_filter"), $total_color );
                ?></span>
                <ul>
                    <?php
                    $color_count = 0;
                    $color_non_count = 0;
                    foreach ( $colors_array as $color ) {
                        $term_id = $color->term_id;
                        $term_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true );
                        $thumbnail_id = absint( get_term_meta( $term_id, 'thumbnail_id', true ) );
                        $image = '';
                        if ( !empty( $term_image ) ) {
                            $image = $term_image;
                        } else{
                          if ( $thumbnail_id ) {
                            $image = wp_get_attachment_thumb_url( $thumbnail_id );
                        }
                    }


                    if( $image != '' ) {
                        $li_class='';
                        $terms_related = get_term_meta( $color->term_id, 'pa_color_rel_lifes', true );
                        ?>
                        <div style="display:none">
                            <?php
                            // $array_related = array();
                            // $related_class = '';
                            // if(!empty($terms_related))
                            // {
                            //     foreach ($terms_related as $term_key => $term_array_value) {
                            //         # code...
                            //         $terms_name = get_terms(array(
                            //                 'taxonomy'  =>  $term_key,
                            //                 'hide_empty'    =>  false,
                            //                 'include'   => $term_array_value
                            //             )
                            //         );
                            //         if($terms_name)
                            //         {
                            //             foreach($terms_name as $single_terms)
                            //                 $related_class .= ' '.$single_terms->slug;
                            //         }
                            //     }
                            // }
                            // print_r($terms_related);

                            $dis_flag = 1;
                            if( isset($_POST['pa_filter-colour']) && !empty($_POST['pa_filter-colour']) ){
                                $dis_flag = 0;
                                $selected_colors = $_POST['pa_filter-colour'];
                                foreach ($selected_colors as $value) {
                                    if( in_array( $value, $terms_related['pa_filter-colour'] ) ){
                                        $dis_flag = 1;
                                        break;
                                    }
                                }
                            }
                            

                            ?>
                        </div>
                        <?php

                        if($dis_flag == 1){
                        ?>
                        <li><img src="<?php echo esc_url( $image ); ?>" width="35px" height="35px" data-cid="<?php echo $color->term_id; ?>" id="color-i-<?php echo $color->term_id; ?>" data-href="<?php echo $image; ?>" aria-controls="<?php echo $color->term_id; ?>" data-term="<?php echo $color->name; ?>" data-large-image="<?php echo $image; ?>" /></li>
                        <?php
                        }
                        $color_non_count++;
                    }

                    $color_count++;

                    if( $color_non_count >= 6 ){
                        break;
                    }

                }

            }
            ?>
        </ul>
    </div>
    <div class="desc-and-link bg-green text-white clearfix mobile-view">
        <div class="list-desc">
            <?php
            the_excerpt();
            ?>
        </div>

    </div>
    <div class="tsrange">
    <div class="range-btn btn btn-cc btn-cc-white">


        <!-- <a href="<?php //echo $get_permalink; ?>" class="btn btn-cc btn-cc-white">-->
        <?php _e("SEE THE RANGE", "cc_filter_product") ?>
        <!--</a> -->
    </div>
    </div>
</div>


<!-- </div> -->
</a>
</div><?php
            endwhile; ?>
      <?php  } else {
           // echo __( 'No products found' );
        }
        echo '</div>';
        wp_reset_postdata();

        ?>

           
        </div>
    </main>
</div>

<?php get_footer();
