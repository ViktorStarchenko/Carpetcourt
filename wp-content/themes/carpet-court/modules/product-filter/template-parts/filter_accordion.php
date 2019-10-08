<?php
/**
 * filter page used in loop
 */
// get post id

    $active_class = '';
    $checked = '';
if ( isset( $_POST['product_color'] ) &&  !empty( $_POST['product_color'] ) ) {

    $term_related_id = get_term_meta($single->term_id, 'related_post_id', true);

    $checked = checked( $single->term_id, (isset( $_POST['product_color'] ) && $single->term_id == $_POST['product_color'] ? $single->term_id : '' ), false );
    if ( isset( $_POST['product_color'] ) && $single->term_id == $_POST['product_color'] ) {
        $active_class = 'active';
    }

}

if ( $taxonomy != 'product_color' ) {

    $term_related_id = get_term_meta($single->term_id, 'related_post_id', true);

    $checked = checked( $single->term_id, (isset( $_POST[$taxonomy] ) && in_array( $single->term_id, $_POST[$taxonomy] ) ? $single->term_id : '' ), false );
    // $active_class = '';
    if ( isset( $_POST[$taxonomy] ) && in_array( $single->term_id, $_POST[$taxonomy] ) ) {
        $active_class = 'active';
    }
}


$pa_color_class = "";
$pa_color_array = array();
if ( $taxonomy == 'pa_color' && !empty( $_POST['pa_floor'] ) ) {

    foreach ($_POST['pa_floor'] as $floor_value) {
        $related_color_swatches = cc_get_term_meta( $floor_value, 'related_color_swatches', true );
        foreach ($related_color_swatches as $rel_svalue) {
            if ( !in_array( $rel_svalue, $pa_color_array ) ) {
                array_push( $pa_color_array, $rel_svalue );
            }
        }
    }

}

if ( $taxonomy == 'pa_color' && !empty( $_POST['pa_style'] ) ) {

    foreach ($_POST['pa_style'] as $pa_style) {
        $related_color_swatches_pa_style = cc_get_term_meta( $pa_style, 'related_color_swatches', true );
        foreach ($related_color_swatches_pa_style as $r_svalue) {
            if ( !in_array( $r_svalue, $pa_color_array ) ) {
                array_push( $pa_color_array, $r_svalue );
            }
        }
    }

}

if ( $taxonomy == 'pa_color' && !empty( $_POST['product_color'] ) ) {

    foreach ($_POST['product_color'] as $product_color) {
        $related_color_swatches_product_color = cc_get_term_meta( $product_color, 'related_color_swatches', true );
        foreach ($related_color_swatches_product_color as $r_cvalue) {
            if ( !in_array( $r_cvalue, $pa_color_array  ) ) {
                array_push( $pa_color_array, $r_cvalue );
            }
        }
    }

}

if ( !empty( $pa_color_array ) ) {
    if ( in_array( $single->term_id, $pa_color_array ) ) {
        $pa_color_class = "";
    } else {
        $pa_color_class = "hidden";
    }
}


$filter_color_class = '';
$col_rel_life = array();

$pa_filter_class = '';
if ( isset( $_POST['pa_filter_color'] ) && !empty( $_POST['pa_filter_color'] ) && in_array( $single->term_id, $_POST['pa_filter_color'] ) ) {
    $pa_filter_class = 'active';
    $checked = 'checked="checked"';
}

if ( $taxonomy == 'pa_filter-colour') {

    foreach ($_POST as $taxonomy_key => $post_value) {

        if ( taxonomy_exists( $taxonomy_key ) ) {

            if ( is_array( $post_value ) ) {

                foreach ($post_value as $value_id ) {

                    $related_color_swatches = cc_get_term_meta( $value_id, 'related_'.$taxonomy_key, true );

                    if ( !empty( $related_color_swatches[0] ) ) {
                        foreach ($related_color_swatches as $rel_swatches_value) {
                            $term_exists = term_exists( $rel_swatches_value, 'pa_filter-colour' );
                            if ($term_exists !== 0 && $term_exists !== null) {
                                if ( !in_array( $rel_swatches_value, $col_rel_life ) ) {
                                    array_push( $col_rel_life, $rel_swatches_value );
                                }
                            }
                        }
                    }

                }
            } else {
                $related_color_swatches = cc_get_term_meta( $post_value, 'related_'.$taxonomy_key, true );

                if ( !empty( $related_color_swatches[0] ) ) {
                    foreach ($related_color_swatches as $rel_swatches_value) {
                        $term_exists = term_exists( $rel_swatches_value, 'pa_filter-colour' );
                        if ($term_exists !== 0 && $term_exists !== null) {
                            if ( !in_array( $rel_swatches_value, $col_rel_life ) ) {
                                array_push( $col_rel_life, $rel_swatches_value );
                            }
                        }
                    }
                }

            }
        } elseif ( $taxonomy_key == 'child_product_color' ) {

            if ( is_array( $post_value ) && !empty( $post_value ) ) {

                foreach ($post_value as $value_id ) {

                    $related_color_swatches = cc_get_term_meta( $value_id, 'related_product_color', true );

                    if ( !empty( $related_color_swatches[0] ) ) {
                        foreach ($related_color_swatches as $rel_swatches_value) {
                            $term_exists = term_exists( $rel_swatches_value, 'pa_filter-colour' );
                            if ($term_exists !== 0 && $term_exists !== null) {
                                if ( !in_array( $rel_swatches_value, $col_rel_life ) ) {
                                    array_push( $col_rel_life, $rel_swatches_value );
                                }
                            }
                        }
                    }

                }
            }

        }
    }

}


if ( !empty( $related_color_swatches ) ) {


    $term_exists = term_exists( $rel_swatches_value, 'pa_filter-colour' );
    if ($term_exists !== 0 && $term_exists !== null) {

        if ( !empty( $related_color_swatches ) && !in_array($single->term_id, $related_color_swatches ) ) {
            $filter_color_class = 'hidden';
        } else {
            $filter_color_class = '';
        }
    }
} else {
    $filter_color_class = '';
}


$brand_n_types = '';
$features_n_types = '';
$li_flag = 1;
if ( $taxonomy == 'product_brand' ) {

    $related_brands = cc_get_term_meta( $single->term_id, 'related_product_cat', true );
    if ( !empty( $related_brands ) ) {

        $brand_n_types = implode( ' ', $related_brands );
    }

}
if ( $taxonomy == 'product_feature' ) {

    $related_feature_n_types = cc_get_term_meta( $single->term_id, 'related_cat_features_type', true );
    if ( !empty( $related_feature_n_types ) ) {

          $features_n_types = implode( ' ', $related_feature_n_types );
		 //echo '--'.$single->term_id;
    }

    if( isset( $_POST['product_cat'] ) ) {
        $product_cat = $_POST['product_cat'];
        if( !in_array($product_cat[0], $related_feature_n_types))
            $li_flag = 0 ;
    }

}

?>
<li class="<?php  echo $active_class ." ".$pa_color_class." ".$pa_filter_class; ?> cpm-parent <?php echo $filter_color_class; ?><?php echo ' '.$brand_n_types; ?> <?php echo ' '.$features_n_types; ?>" data-slug="<?php echo $single->slug; ?>" <?php if( $li_flag == 0) echo 'style="display: none;"';?>>
    
    <figure class="fig-hover">


        <a href="javascript:void(0);" class="cpm-img-checkbox">
<?php if ( !empty( $image ) ) { ?>
            <img src="<?php echo esc_url($image); ?>" class="wp-post-image"/>
			 <?php } ?>
        </a>
    </figure>
   
    <div class="ms-checkbox">

        <?php
        $name = '';
        if ( $taxonomy == 'product_color') {
            $name = $taxonomy;
        } else {
            $name = $taxonomy.'[]';
        }
        ?>
        <input type="radio" name="<?php echo $name; ?>"  class="filter-checkbox-btn checkbox-custom <?php echo $taxonomy; ?> cpm_hide" id="term_<?php echo $single->term_id; ?>" data-taxonomy="<?php echo $taxonomy; ?>" value="<?php echo $single->term_id; ?>" data-term="<?php echo $single->slug; ?>" <?php echo $checked;?> />
        <label for="term_<?php echo $single->term_id; ?>" class="checkbox-custom-label"><span><?php echo $single->name; ?></span></label>
    </div>

</li>