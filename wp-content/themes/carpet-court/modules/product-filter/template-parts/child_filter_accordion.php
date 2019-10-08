<?php
/**
 * filter page used in loop
 */
// get post id
$term_related_id = get_term_meta($single->term_id, 'related_post_id', true);

$checked = checked( $single->term_id, (isset( $_POST['child_product_color'] ) && $single->term_id == $_POST['child_product_color'] ? $single->term_id : '' ), false );
$active_class = '';
if ( isset( $_POST['child_product_color'] ) && $single->term_id == $_POST['child_product_color'] ) {
    $active_class = 'active';
}


$pa_color_class = "";
$pa_color_array = array();
if ( !empty( $_POST['product_color'] ) ) {
    $child_terms = get_term_children( $_POST['product_color'], 'product_color' );

    if ( in_array( $single->term_id, $child_terms ) ) {
        $pa_color_class = '';
    } else {
        $pa_color_class = 'hidden';
    }

}

?>
<li class="<?php  echo $active_class.' '.$pa_color_class; ?> cpm-parent neer <?php echo $palettes_single; ?>" data-slug="<?php echo $single->slug; ?>">
    <?php if ( !empty( $image ) ) { ?>
    <figure class="fig-hover">
    	<a href="#" class="cpm-img-checkbox">

            <img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr__( 'Thumbnail', 'cc_product_filter' );?>"  class="wp-post-image"/>
    	</a>
    </figure>
            <?php }  ?>
    <div class="ms-checkbox">
    <input type="radio" name="child_product_color"  class="filter-checkbox-btn checkbox-custom child_product_color cpm_hide" id="term_<?php echo $single->term_id; ?>" data-taxonomy="product_color" value="<?php echo $single->term_id; ?>" data-term="<?php echo $single->slug; ?>" <?php echo $checked;?> />
    <label for="term_<?php echo $single->term_id ?>" class="checkbox-custom-label"><span><?php echo $single->name ?></span></label>
    </div>

</li>