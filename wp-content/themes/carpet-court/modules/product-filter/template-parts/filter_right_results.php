<?php
/**
 * this template parts is for filter product result showing part on right
 */
?>
<?php
// echo '<pre>';
//     print_r($product_query);
// echo '</pre>';
if ($product_query->have_posts()):

    $counter = 1;
?>
<div class="list-product-wrap">
    <?php //echo '<p>ctn '.$product_query->post_count.'</p>';
    while ($product_query->have_posts()) : $product_query->the_post();

    global $product;
    ?>
    <?php
    $get_permalink = get_permalink();
    if ( !empty( $_POST['pa_floor'][0] ) && isset( $_POST['pa_floor'][0] ) ) {
        $floor_array = array();
        foreach ($_POST['pa_floor'] as $floor ) {
            if ( !empty( $floor ) ) {

                array_push( $floor_array, $floor );
            }
        }

        $get_permalink = add_query_arg('pa_floor', implode(',', $floor_array), $get_permalink );
    }
    $filter_p_c = 'pa_filter-colour';
    if ( !empty( $_POST[$filter_p_c][0] ) && isset( $_POST[$filter_p_c][0] ) ) {
        $pa_filter = array();
        foreach ($_POST[$filter_p_c] as $f_c ) {
            if ( !empty( $f_c ) ) {

                array_push( $pa_filter, $f_c );
            }
        }
        $get_permalink = add_query_arg('pa_filter-colour', implode(',', $pa_filter), $get_permalink );
    }
    if ( !empty( $_POST['pa_style'][0] ) && isset( $_POST['pa_style'][0] ) ) {
        $style_array = array();
        foreach ($_POST['pa_style'] as $style ) {
            if ( !empty( $style ) ) {

                array_push( $style_array, $style );
            }
        }
        $get_permalink = add_query_arg('pa_style', implode(',', $style_array), $get_permalink );
    }
    if ( !empty( $_POST['pa_looks'][0] ) && isset( $_POST['pa_looks'][0] ) ) {
        $looks_array = array();
        foreach ($_POST['pa_looks'] as $looks ) {
            if ( !empty( $looks ) ) {

                array_push( $looks_array, $looks );
            }
        }
        $get_permalink = add_query_arg('pa_looks', implode(',', $looks_array), $get_permalink );
    }
    if ( !empty( $_POST['product_brand'][0] ) && isset( $_POST['product_brand'][0] ) ) {
        $product_brand_array = array();
        foreach ($_POST['product_brand'] as $product_brand ) {
            if ( !empty( $product_brand ) ) {

                array_push( $product_brand_array, $product_brand );
            }
        }
        $get_permalink = add_query_arg('product_brand', implode(',', $product_brand_array), $get_permalink );
    }
    if ( !empty( $_POST['pa_rooms'][0] ) && isset( $_POST['pa_rooms'][0] ) ) {
        $pa_rooms_array = array();
        foreach ($_POST['pa_rooms'] as $pa_rooms ) {
            if ( !empty( $pa_rooms ) ) {

                array_push( $pa_rooms_array, $pa_rooms );
            }
        }
        $get_permalink = add_query_arg('pa_rooms', implode(',', $pa_rooms_array), $get_permalink );
    }
    if ( !empty( $_POST['additional_option'][0] ) && isset( $_POST['additional_option'][0] ) ) {
        $additional_option_array = array();
        foreach ($_POST['additional_option'] as $additional_option ) {
            if ( !empty( $additional_option ) ) {

                array_push( $additional_option_array, $additional_option );
            }
        }
        $get_permalink = add_query_arg('additional_option', implode(',', $additional_option_array), $get_permalink );
    }
    if ( !empty( $_POST['pa_rent'][0] ) && isset( $_POST['pa_rent'][0] ) ) {
        $pa_rent_array = array();
        foreach ($_POST['pa_rent'] as $pa_rent ) {
            if ( !empty( $pa_rent ) ) {

                array_push( $pa_rent_array, $pa_rent );
            }
        }
        $get_permalink = add_query_arg('pa_rent', implode(',', $pa_rent_array), $get_permalink );
    }
    if ( !empty( $_POST['pa_sell'][0] ) && isset( $_POST['pa_sell'][0] ) ) {
        $pa_sell_array = array();
        foreach ($_POST['pa_sell'] as $pa_sell ) {
            if ( !empty( $pa_sell ) ) {

                array_push( $pa_sell_array, $pa_sell );
            }
        }
        $get_permalink = add_query_arg('pa_sell', implode(',', $pa_sell_array), $get_permalink );
    }
    if ( !empty( $_POST['product_cat'][0] ) && isset( $_POST['product_cat'][0] ) ) {
        $product_cat_array = array();
        foreach ($_POST['product_cat'] as $product_cat ) {
            if ( !empty( $product_cat ) ) {

                array_push( $product_cat_array, $product_cat );
            }
        }
        $get_permalink = add_query_arg('product_cat', implode(',', $product_cat_array), $get_permalink );
    }
    if ( !empty( $_POST['child_product_color'] ) && isset( $_POST['child_product_color'] ) ) {
        $get_permalink = add_query_arg('child_product_color', $_POST['child_product_color'], $get_permalink );
    }

    if ( !empty( $_POST['product_feature'][0] ) && isset( $_POST['product_feature'][0] ) ) {
        $feature_array = array();
        foreach ($_POST['product_feature'] as $feature ) {
            if ( !empty( $feature ) ) {

                array_push( $feature_array, $feature );
            }
        }
        $get_permalink = add_query_arg('product_feature', implode(',', $feature_array), $get_permalink );
    }


    ?>
    <!-- <a href="<?php //echo $get_permalink; ?>"> -->
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
                            // if( ($dis_flag != 0) && isset($_POST['pa_floor']) && !empty($_POST['pa_floor']) ){
                            //     $selected_floors = $_POST['pa_floor'];
                            //     foreach ($selected_floors as $value) {
                            //         if( !in_array( $value, $terms_related['pa_floor'] ) ){
                            //             $dis_flag = 0;
                            //         }
                            //     }
                            // }
                            // if( ($dis_flag != 0) && isset($_POST['pa_rent']) && !empty($_POST['pa_rent']) ){
                            //     $selected_floors = $_POST['pa_rent'];
                            //     foreach ($selected_floors as $value) {
                            //         if( !in_array( $value, $terms_related['pa_rent'] ) ){
                            //             $dis_flag = 0;
                            //         }
                            //     }
                            // }
                            // if( ($dis_flag != 0) && isset($_POST['pa_sell']) && !empty($_POST['pa_sell']) ){
                            //     $selected_floors = $_POST['pa_sell'];
                            //     foreach ($selected_floors as $value) {
                            //         if( !in_array( $value, $terms_related['pa_sell'] ) ){
                            //             $dis_flag = 0;
                            //         }
                            //     }
                            // }

                            ?>
                        </div>
                        <?php

                        /*<li><a href="#<?php echo $color->term_id; ?>" data-cid="<?php echo $color->term_id; ?>" id="color-i-<?php echo $color->term_id; ?>" data-href="<?php echo $image; ?>" aria-controls="<?php echo $color->term_id; ?>" data-term="<?php echo $color->name; ?>"><img src="<?php echo esc_url( $image ); ?>" width="35px" height="35px" data-large-image="<?php echo $image; ?>" /></a></li>*/
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

<?php

if ( ( $counter % 2 == 0 && isset( $_POST['tabs'] ) ) || ( $counter % 2 == 0 && isset( $_POST['delivery'] ) ) ) { ?>
<div class="clearfix"></div>
<?php
}
$counter++;
endwhile;
wp_reset_postdata();

include( PATH.'template-parts/pagination.php' );

wp_reset_query(); ?>
</div>
<?php
else:
    ?>
<div class="no-products-found cpm-noproduct">
    <?php _e("More specials available soon","cc_product_filter");?>
</div>
<?php
endif;

/*
?>
<div class="modal cc-model fade" id="book-free-modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="bookk-modal"><?php //_e('Book A Free Measure and Quote', 'carpet-court'); ?></h4>
        </div>
        <div class="modal-body clearfix">
            <div class="col-sm-12">
              <?php //cpm_measuer_and_quote_form(); ?>
          </div>
      </div>
  </div>
</div>
</div>

<?php */
