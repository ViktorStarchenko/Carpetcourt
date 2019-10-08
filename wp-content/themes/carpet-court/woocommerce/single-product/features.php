<?php
/**
 * Single Product Key features
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;  ?>

<div class="cc-product-color clearfix desktop-view">
    <h2 class="inner-section-title inner-section-title-1 alt-text"><span><?php _e('Colours', 'carpet-court'); ?></span></h2>
        <!-- <a class="collapse-icon" data-toggle="collapse" href="#collapse-color" aria-expanded="true" aria-controls="collapse-color">
            <span class="cc-icon-collapse"></span>
        </a> -->
        <!-- <hr/> -->
        <div class="collapse in abc" id="collapse-color">
            <!-- <div class="collapse-container"> -->

            <?php
                // global $product;
            // $colors = get_the_terms($product->id, 'pa_color');
            $colors = get_the_terms( $product->id, 'pa_color' );


            $pa_floor = $pa_style = $product_color = '';

            $taxonomy_array = array( 'pa_floor', 'pa_style', 'product_color', 'pa_rent', 'pa_sell', 'pa_filter-colour' );

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

    $colors_array = array();
    if ( !empty( $related_swatches_array ) ) {
        $count_k = 0;
        foreach ($colors as $keys => $color_value) {
                    // if ( !in_array( $color_value->term_id, $related_swatches_array ) ) {
                    //     unset( $colors[$keys] );
                    // }
            if( ( $keyyy = array_search( $color_value->term_id, $related_swatches_array ) ) !== false ) {
                $colors_array = array($keyyy.$count_k => $colors[$keys]) + $colors_array;
            } else {
                $colors_array[$count_k] = $colors[$keys];
            }
            $count_k++;
        }
    } else {
        $colors_array = $colors;
    }

    if (!empty($colors_array)) {
        $first = true;
        foreach ($colors_array as $color) {
            if ($first === true) {
                echo '<div class="product-detail-label single-selected-color">';
                printf(__('%s Selected Colour : %s%s', 'carpet-court'), '<span>', '</span>', $color->name);
                echo '</div>';
                echo '<ul id="color-tab" class="nav nav-tabs" role="tablist">';
            }
            $thumbnail_id = get_term_meta($color->term_id, 'thumbnail_id', true);
            $term_image = get_term_meta( $color->term_id, 'cpm_color_thumbnail', true );
            if ($term_image) {
                $active = (true == $first) ? 'active' : '';

                echo '<li role="presentation" class="' . $active . '" data-color="' . $color->name . '">';
                echo '<a href="#' . $color->term_id . '" data-cid="' . $color->term_id . '" id="color-i-' . $color->term_id . '" data-href="'.$term_image.'" aria-controls="' . $color->term_id . '" role="tab" data-toggle="tab" class="clearfix" data-term="'.$color->name.'"><img class="color-swatches-patches" src="' . $term_image . '" width="100" height="100" data-large-image="' . $term_image . '"></a>';
                echo '</li>';
            } elseif ($thumbnail_id) {
                $active = (true == $first) ? 'active' : '';

                $image = wp_get_attachment_image_src($thumbnail_id);
                echo '<li role="presentation" class="' . $active . '" data-color="' . $color->name . '">';
                echo '<a href="#' . $color->term_id . '" data-cid="' . $color->term_id . '" id="color-i-' . $color->term_id . '" data-href="'.$image[0].'" aria-controls="' . $color->term_id . '" role="tab" data-toggle="tab" class="clearfix" data-term="'.$color->name.'"><img class="color-swatches-patches" src="' . $image[0] . '" width="100" height="100" data-large-image="' . $image[0] . '"></a>';
                echo '</li>';
            }
            $first = false;
        }
        echo '</ul>';
    }
    ?>
    <!-- </div> -->
</div>
</div>

<?php


$features = get_the_terms( $product->ID, 'product_feature' );
if ( $features && ! is_wp_error( $features ) ) :
    ?>

<div class="cc-works-well clearfix desktop-view">
   <h2 class="inner-section-title inner-section-title-1 alt-text"><span><?php _e('Key Features','carpet-court');?></span></h2>
   <ul class="cc-product-features hi-icon-effect-9 hi-icon-big hi-icon-effect-9b text-center">
       <?php
       $key_features = array();
       foreach ( $features as $term ) {
           $key_features[] = $term->name;
           $thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
           if ( $thumbnail_id ) {
              $image = wp_get_attachment_thumb_url( $thumbnail_id );
          } else {
              $image = wc_placeholder_img_src();
          }
          $image = str_replace( ' ', '%20', $image );
          ?>
          <li>
            <span class="hi-icon hi-icon-images" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $term->name );?>">
               <img src="<?php echo esc_url( $image );?>" alt="<?php echo esc_attr( $term->name );?>"  />
           </span>
       </li>
       <?php
   }
   ?>

</ul>
</div>
<?php endif; ?>
<!-- <div class="cc-works-well clearfix desktop-view">
<h2 class="inner-section-title inner-section-title-1 alt-text"><span><?php //_e('Description','carpet-court');?></span></h2>
<?php //the_content(); ?>
</div> -->